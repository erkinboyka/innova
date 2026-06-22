<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrlQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            ['level' => 1, 'question' => 'Наблюдались ли и задокументированы фундаментальные научные принципы?', 'type' => 'boolean', 'order' => 1],
            ['level' => 2, 'question' => 'Сформулирована ли технологическая концепция или применение?', 'type' => 'boolean', 'order' => 2],
            ['level' => 3, 'question' => 'Проведены ли аналитические и экспериментальные доказательства концепции?', 'type' => 'boolean', 'order' => 3],
            ['level' => 4, 'question' => 'Проверены ли компоненты или макеты в лабораторных условиях?', 'type' => 'boolean', 'order' => 4],
            ['level' => 5, 'question' => 'Проверены ли компоненты или прототипы в соответствующей (реалистичной) среде?', 'type' => 'boolean', 'order' => 5],
            ['level' => 6, 'question' => 'Продемонстрирован ли прототип в соответствующей среде?', 'type' => 'boolean', 'order' => 6],
            ['level' => 7, 'question' => 'Продемонстрирована ли система в эксплуатационных условиях?', 'type' => 'boolean', 'order' => 7],
            ['level' => 8, 'question' => 'Завершена ли и квалифицирована система в окончательной форме?', 'type' => 'boolean', 'order' => 8],
            ['level' => 9, 'question' => 'Доказана ли успешная эксплуатация системы в реальных условиях?', 'type' => 'boolean', 'order' => 9],
        ];

        foreach ($questions as $q) {
            \App\Models\TrlQuestion::create($q);
        }
    }
}
