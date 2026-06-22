<?php

namespace Database\Seeders;

use App\Models\Grant;
use App\Models\News;
use App\Models\Organization;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Database\Seeder;

class PICSDSeeder extends Seeder
{
    public function run(): void
    {
        // Organizations
        $univ = Organization::updateOrCreate(['name' => 'Таджикский Национальный Университет'], [
            'type' => 'university',
            'region' => 'Душанбе',
            'website' => 'https://tnu.tj',
            'verification_status' => 'verified',
            'verified_at' => now(),
        ]);

        $nii = Organization::updateOrCreate(['name' => 'Институт химии им. В.И. Никитина'], [
            'type' => 'nii',
            'region' => 'Душанбе',
            'website' => 'https://chemistry.tj',
            'verification_status' => 'verified',
            'verified_at' => now(),
        ]);

        $scientist = User::where('role', 'scientist')->first() ?? User::factory()->create(['role' => 'scientist', 'name' => 'Доктор Саидов']);
        
        // Link Test User to Organization
        User::where('email', 'test@example.com')->update([
            'organization_id' => $univ->id,
            'role' => 'scientist',
            'position' => 'Старший научный сотрудник',
            'verification_status' => 'verified'
        ]);

        // News
        News::create([
            'title' => 'На форуме в Душанбе обсудили будущее ИИ в Центральной Азии',
            'content' => 'Международный форум собрал более 500 экспертов для обсуждения стратегий цифровой трансформации и внедрения искусственного интеллекта в экономику региона.',
            'category' => 'Forum',
            'is_featured' => true,
            'published_at' => now(),
        ]);

        News::create([
            'title' => 'Новый грант для молодых ученых Академии наук РТ',
            'content' => 'Министерство образования и науки объявило о запуске новой программы поддержки научно-технических инициатив молодых специалистов с общим бюджетом 1 млн сомони.',
            'category' => 'Grant',
            'published_at' => now()->subDays(2),
        ]);

        // Technologies
        Technology::create([
            'title' => 'Система спутникового мониторинга ледников Памира',
            'description' => 'Автоматизированная платформа для анализа динамики таяния ледников с использованием данных ДЗЗ и алгоритмов машинного обучения.',
            'problem' => 'Трудность доступа к высокогорным районам и потребность в точном прогнозировании водных ресурсов.',
            'solution' => 'Использование спутниковых снимков высокого разрешения и нейронных сетей для детекции изменений границ ледникового покрова.',
            'trl' => 7,
            'status' => 'ready',
            'owner_id' => $scientist->id,
            'organization_id' => $univ->id,
            'category' => 'Экология',
            'cost' => 150000,
        ]);

        Technology::create([
            'title' => 'Гель для очистки сточных вод промышленных предприятий',
            'description' => 'Высокоэффективный биоразлагаемый полимерный сорбент для удаления ионов тяжелых металлов из промышленных стоков.',
            'problem' => 'Загрязнение рек отходами горнодобывающей промышленности.',
            'solution' => 'Применение сорбента на основе местного сырья, снижающее стоимость очистки на 40%.',
            'trl' => 5,
            'status' => 'prototype',
            'owner_id' => $scientist->id,
            'organization_id' => $nii->id,
            'category' => 'Экология',
            'cost' => 45000,
        ]);

        // Grants
        Grant::create([
            'title' => 'Грант Президента РТ для молодых ученых 2026',
            'description' => 'Конкурс на получение грантов для проведения научно-исследовательских работ по приоритетным направлениям развития науки.',
            'provider' => 'Министерство образования и науки РТ',
            'budget' => 500000,
            'deadline' => now()->addMonths(3),
            'requirements' => 'Возраст до 35 лет, наличие степени кандидата наук приветствуется.',
            'status' => 'active',
        ]);
    }
}
