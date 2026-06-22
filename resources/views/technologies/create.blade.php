<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-white">
                {{ isset($technology) ? 'Редактирование разработки' : 'Новая разработка и TRL-оценка' }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">Карточка проекта для реестра, конкурса и дальнейшего вывода на marketplace.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-[1480px] px-4 py-6 sm:px-6 lg:px-8" x-data="trlWizard({{ (int) old('trl', $technology->trl ?? 1) }})">
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-12">
            <form action="{{ isset($technology) ? route('technologies.update', $technology) : route('technologies.store') }}" method="POST" class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20 lg:col-span-8">
                @csrf
                @isset($technology)
                    @method('PATCH')
                @endisset

                @if($trlQuestions->isNotEmpty())
                    <template x-for="[questionId, level] in Object.entries(answers)" :key="questionId">
                        <input type="hidden" name="trl_answers[]" :value="level">
                    </template>
                @endif

                <div class="mb-5 flex items-center gap-2 border-b border-white/8 pb-4">
                    <button type="button" @click="step = 'info'" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-[0.14em]" :class="step === 'info' ? 'bg-emerald-400 text-slate-950' : 'bg-slate-900 text-slate-400'">Описание</button>
                    <button type="button" @click="step = 'trl'" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-[0.14em]" :class="step === 'trl' ? 'bg-emerald-400 text-slate-950' : 'bg-slate-900 text-slate-400'">TRL</button>
                </div>

                <div class="space-y-5" x-show="step === 'info'">
                    <div>
                        <label class="mb-2 block text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">Название разработки</label>
                        <input type="text" name="title" value="{{ old('title', $technology->title ?? '') }}" required class="h-11 w-full rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                        <x-input-error :messages="$errors->get('title')" class="mt-2 text-xs text-red-400" />
                    </div>

                    <div>
                        <label class="mb-2 block text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">Описание технологии</label>
                        <textarea name="description" rows="8" required class="w-full rounded-xl border-slate-800 bg-slate-950/70 p-4 text-sm leading-6 text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">{{ old('description', $technology->description ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2 text-xs text-red-400" />
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">НИИ / университет</label>
                            <select name="organization_id" class="h-11 w-full rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                                <option value="">Без организации</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->id }}" @selected((string) old('organization_id', $technology->organization_id ?? '') === (string) $org->id)>{{ $org->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">Коммерческий статус</label>
                            <select name="status" class="h-11 w-full rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                                @foreach([
                                    'draft' => 'Черновик',
                                    'research' => 'Исследование',
                                    'prototype' => 'Прототип',
                                    'selling' => 'Продажа патента',
                                    'licensing' => 'Лицензирование',
                                    'investor_searching' => 'Ищет инвестиции',
                                    'ready' => 'Готово к внедрению',
                                ] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', $technology->status ?? 'draft') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-xs text-red-400" />
                        </div>
                    </div>

                    @if($trlQuestions->isEmpty())
                        <div>
                            <label class="mb-2 block text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">TRL уровень</label>
                            <select name="trl" class="h-11 w-full rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                                @for($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}" @selected((int) old('trl', $technology->trl ?? 1) === $i)>TRL {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    @endif

                    <button type="button" @click="step = 'trl'" class="h-11 rounded-xl bg-slate-800 px-5 text-xs font-black uppercase tracking-[0.14em] text-white hover:bg-slate-700">Перейти к TRL</button>
                </div>

                <div class="space-y-4" x-show="step === 'trl'" x-cloak>
                    @if($trlQuestions->isNotEmpty())
                        @foreach($trlQuestions as $question)
                            <button type="button" class="flex w-full items-center justify-between gap-4 rounded-xl border p-4 text-left transition" :class="answers['{{ $question->id }}'] ? 'border-emerald-400/50 bg-emerald-400/10' : 'border-white/8 bg-slate-950/50 hover:border-white/20'" @click="toggleAnswer('{{ $question->id }}', {{ $question->level }})">
                                <span>
                                    <span class="block text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">TRL {{ $question->level }}</span>
                                    <span class="mt-1 block text-sm font-semibold text-slate-200">{{ $question->question }}</span>
                                </span>
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border" :class="answers['{{ $question->id }}'] ? 'border-emerald-300 bg-emerald-300' : 'border-slate-700'">
                                    <span class="h-2 w-2 rounded-full bg-slate-950" x-show="answers['{{ $question->id }}']"></span>
                                </span>
                            </button>
                        @endforeach
                    @else
                        <div class="rounded-xl border border-amber-400/20 bg-amber-400/10 p-4 text-sm text-amber-100">Вопросы TRL не загружены. Запустите `TrlQuestionSeeder`, чтобы включить автоматическую оценку.</div>
                    @endif

                    <div class="flex flex-col gap-3 border-t border-white/8 pt-5 sm:flex-row">
                        <button type="button" @click="step = 'info'" class="h-11 rounded-xl bg-slate-800 px-5 text-xs font-black uppercase tracking-[0.14em] text-white hover:bg-slate-700">Назад</button>
                        <button type="submit" class="h-11 rounded-xl bg-emerald-400 px-5 text-xs font-black uppercase tracking-[0.14em] text-slate-950 hover:bg-emerald-300">
                            {{ isset($technology) ? 'Сохранить изменения' : 'Сохранить проект' }}
                        </button>
                    </div>
                </div>
            </form>

            <aside class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20 lg:col-span-4">
                <div class="text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">Текущая оценка</div>
                <div class="mt-5 rounded-2xl border border-white/8 bg-slate-950/50 p-6 text-center">
                    <div class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">TRL</div>
                    <div class="mt-2 text-7xl font-black text-emerald-300" x-text="currentTrl">1</div>
                    <h3 class="mt-4 text-lg font-black text-white" x-text="getTrlTitle()">Базовые принципы</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-500" x-text="getTrlDescription()"></p>
                </div>
                <div class="mt-5 space-y-2">
                    @for($i = 1; $i <= 9; $i++)
                        <div class="flex items-center gap-3">
                            <div class="w-10 text-[10px] font-black text-slate-600">TRL {{ $i }}</div>
                            <div class="h-2 flex-1 rounded-full bg-slate-800">
                                <div class="h-2 rounded-full bg-emerald-400" x-show="currentTrl >= {{ $i }}"></div>
                            </div>
                        </div>
                    @endfor
                </div>
            </aside>
        </div>
    </div>

    <script>
        function trlWizard(initialLevel) {
            return {
                step: 'info',
                currentTrl: initialLevel || 1,
                answers: {},
                toggleAnswer(id, level) {
                    if (this.answers[id]) {
                        delete this.answers[id];
                    } else {
                        this.answers[id] = level;
                    }

                    const levels = [...new Set(Object.values(this.answers).map(Number))].sort((a, b) => a - b);
                    let current = 0;

                    for (const level of levels) {
                        if (level === current + 1) {
                            current = level;
                        }
                    }

                    this.currentTrl = Math.max(1, current);
                },
                getTrlTitle() {
                    if (this.currentTrl <= 1) return 'Базовые принципы';
                    if (this.currentTrl === 2) return 'Концепция технологии';
                    if (this.currentTrl === 3) return 'Экспериментальное подтверждение';
                    if (this.currentTrl <= 6) return 'Прототип и испытания';
                    if (this.currentTrl <= 8) return 'Готовность к рынку';
                    return 'Коммерческий продукт';
                },
                getTrlDescription() {
                    if (this.currentTrl <= 3) return 'Проект находится на научной стадии. Нужны доказательства применимости, патентная логика и первичные эксперименты.';
                    if (this.currentTrl <= 6) return 'Проект имеет прототип. Следующий шаг: пилот, подтверждение экономического эффекта и партнёр для внедрения.';
                    return 'Технология близка к рынку. Важно оформить сделку, лицензию, сертификацию и план масштабирования.';
                }
            }
        }
    </script>
</x-app-layout>
