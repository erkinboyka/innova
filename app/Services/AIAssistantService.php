<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Throwable;

class AIAssistantService
{
    /**
     * @return array<string, mixed>
     */
    public function analyzePatent(string $text): array
    {
        if (blank(config('openai.api_key'))) {
            return $this->localAnalysis($text);
        }

        try {
            $response = OpenAI::chat()->create([
                'model' => config('openai.model', 'gpt-4.1-mini'),
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => implode(' ', [
                            'Ты эксперт по коммерциализации научных разработок, TRL, патентам и грантовым программам.',
                            'Верни только JSON с ключами: summary, strengths, weaknesses, potential, risks, business_model, score.',
                            'score должен быть целым числом от 0 до 100.',
                        ]),
                    ],
                    [
                        'role' => 'user',
                        'content' => $text,
                    ],
                ],
            ]);

            $content = $response->choices[0]->message->content ?? '{}';
            $decoded = json_decode($content, true, flags: JSON_THROW_ON_ERROR);

            return $this->normalizeAnalysis($decoded);
        } catch (Throwable $exception) {
            Log::warning('AI patent analysis failed, using local fallback.', [
                'exception' => $exception->getMessage(),
            ]);

            return $this->localAnalysis($text);
        }
    }

    /**
     * @return list<array{name: string, match: string, focus: string}>
     */
    public function matchInvestors(int $technologyId): array
    {
        return [
            ['name' => 'TajInvest Venture', 'match' => '94%', 'focus' => 'AgTech, Industry 4.0'],
            ['name' => 'Central Asia Impact Fund', 'match' => '87%', 'focus' => 'Energy, Medicine, Education'],
            ['name' => 'Dushanbe Business Angels', 'match' => '81%', 'focus' => 'Early-stage prototypes'],
        ];
    }

    public function generateGrantApplication(int $technologyId): string
    {
        return "Заявка на грант для разработки #{$technologyId}\n\n"
            . "1. Актуальность: разработка решает прикладную задачу экономики Республики Таджикистан.\n"
            . "2. План работ: TRL-оценка, лабораторная проверка, пилот с отраслевым партнером.\n"
            . "3. Ожидаемый результат: подготовка технологии к коммерциализации и внедрению.";
    }

    /**
     * @param array<string, mixed> $analysis
     * @return array<string, mixed>
     */
    private function normalizeAnalysis(array $analysis): array
    {
        return [
            'summary' => (string) ($analysis['summary'] ?? 'Описание требует уточнения.'),
            'strengths' => array_values((array) ($analysis['strengths'] ?? [])),
            'weaknesses' => array_values((array) ($analysis['weaknesses'] ?? [])),
            'potential' => (string) ($analysis['potential'] ?? 'Потенциал будет определён после проверки рынка.'),
            'risks' => array_values((array) ($analysis['risks'] ?? [])),
            'business_model' => (string) ($analysis['business_model'] ?? 'Рекомендуется пилот и лицензирование.'),
            'score' => max(0, min(100, (int) ($analysis['score'] ?? 50))),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function localAnalysis(string $text): array
    {
        $cleanText = trim($text);
        $length = mb_strlen($cleanText);
        $hasMarket = preg_match('/рынок|клиент|покупател|заказчик|бизнес|коммерц/ui', $cleanText) === 1;
        $hasIp = preg_match('/патент|авторск|интеллектуальн|лиценз/ui', $cleanText) === 1;
        $hasPilot = preg_match('/пилот|испытан|прототип|TRL|внедрен/ui', $cleanText) === 1;

        $score = 45
            + min(20, (int) floor($length / 600) * 4)
            + ($hasMarket ? 15 : 0)
            + ($hasIp ? 10 : 0)
            + ($hasPilot ? 10 : 0);

        return [
            'summary' => 'Разработка имеет прикладной потенциал, но для конкурсной заявки нужно явно связать научный результат с рынком, правами на ИС, пилотным внедрением и ожидаемым экономическим эффектом.',
            'strengths' => array_values(array_filter([
                'Есть базовое описание научно-технической идеи.',
                $hasIp ? 'В тексте упоминается защита интеллектуальной собственности.' : null,
                $hasPilot ? 'Есть признаки готовности к пилоту или прототипированию.' : null,
                $hasMarket ? 'Обозначена связь с рынком или заказчиком.' : null,
            ])),
            'weaknesses' => array_values(array_filter([
                $hasMarket ? null : 'Не хватает описания целевого рынка, клиента и платёжеспособного спроса.',
                $hasIp ? null : 'Не описан статус интеллектуальной собственности и патентная стратегия.',
                $hasPilot ? null : 'Не хватает подтверждённых испытаний, пилота или плана повышения TRL.',
            ])),
            'potential' => $hasMarket && $hasPilot
                ? 'Коммерческий потенциал выше среднего: можно готовить пилот, инвестиционный паспорт и переговоры с отраслевым партнёром.'
                : 'Коммерческий потенциал предварительный: сначала нужно усилить рыночное обоснование и план внедрения.',
            'risks' => [
                'Недостаточная проверка спроса со стороны бизнеса.',
                'Неоформленные права на результаты интеллектуальной деятельности.',
                'Слабая финансовая модель внедрения.',
            ],
            'business_model' => 'Рекомендуемая модель: пилот с предприятием, затем лицензирование, совместное внедрение или продажа прав на технологию.',
            'score' => max(0, min(100, $score)),
        ];
    }
}
