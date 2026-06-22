<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-xs uppercase tracking-widest text-gray-500 font-black">{{ $technology->status_label }}</div>
                <h2 class="font-black text-3xl text-white tracking-tight">{{ $technology->title }}</h2>
            </div>
            <div class="flex items-center gap-3">
                @if($technology->owner_id === auth()->id() || auth()->user()?->role === 'agency')
                    <a href="{{ route('technologies.edit', $technology) }}" class="px-4 py-2 glass rounded-xl text-xs font-black uppercase tracking-widest hover:bg-white/10 transition">Редактировать</a>
                @endif
                <div class="px-4 py-2 glass rounded-xl text-xs font-black uppercase text-red-500 border-red-500/20">
                    TRL {{ $technology->trl }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-2 space-y-10">
                    <section class="glass-card p-8 lg:p-10 rounded-[32px]">
                        <div class="text-xs font-black text-gray-500 uppercase tracking-widest mb-4">Описание проекта</div>
                        <p class="text-xl text-gray-300 leading-relaxed">{{ $technology->description }}</p>
                    </section>

                    <section class="glass-card p-8 lg:p-10 rounded-[32px] relative overflow-hidden border-indigo-500/10">
                        <div class="absolute right-0 top-0 w-72 h-72 bg-indigo-600/10 blur-[90px]"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between gap-4 mb-8">
                                <div>
                                    <div class="text-xs font-black text-indigo-400 uppercase tracking-widest">AI-модуль</div>
                                    <h3 class="text-2xl font-black mt-2">Анализ коммерческого потенциала</h3>
                                </div>
                                <div id="aiScore" class="px-4 py-3 rounded-2xl glass text-xl font-black text-indigo-300">--</div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="aiResult">
                                <div class="p-6 glass rounded-2xl border-white/5">
                                    <div class="text-[9px] uppercase font-black text-gray-500 mb-2">Сильные стороны</div>
                                    <div class="text-white font-bold opacity-80">Будут рассчитаны после AI-анализа.</div>
                                </div>
                                <div class="p-6 glass rounded-2xl border-white/5">
                                    <div class="text-[9px] uppercase font-black text-gray-500 mb-2">Риски</div>
                                    <div class="text-white font-bold opacity-80">Нажмите кнопку анализа, чтобы получить оценку.</div>
                                </div>
                            </div>

                            <button id="analyzeBtn" class="mt-8 w-full py-4 glass border-indigo-500/30 text-indigo-400 rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-lg">
                                Запустить AI-анализ
                            </button>
                        </div>
                    </section>

                    <section class="glass-card p-8 lg:p-10 rounded-[32px]">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black">Патенты и инвестиции</h3>
                            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">{{ $technology->patents->count() }} патентов</div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="rounded-2xl bg-white/[0.03] border border-white/5 p-6">
                                <div class="text-xs uppercase tracking-widest text-gray-500 font-black mb-4">Патенты</div>
                                @forelse($technology->patents as $patent)
                                    <div class="mb-4 last:mb-0">
                                        <div class="font-black">{{ $patent->number }}</div>
                                        <div class="text-xs text-gray-500">{{ $patent->country }} · {{ $patent->filing_date?->format('d.m.Y') ?? 'дата не указана' }}</div>
                                    </div>
                                @empty
                                    <div class="text-sm text-gray-400">Патенты пока не прикреплены.</div>
                                @endforelse
                            </div>
                            <div class="rounded-2xl bg-white/[0.03] border border-white/5 p-6">
                                <div class="text-xs uppercase tracking-widest text-gray-500 font-black mb-4">Инвестиции</div>
                                @forelse($technology->investments as $investment)
                                    <div class="mb-4 last:mb-0">
                                        <div class="font-black">{{ number_format($investment->amount, 0, '.', ' ') }} сомони</div>
                                        <div class="text-xs text-gray-500">{{ $investment->investor->name ?? 'Инвестор' }} · {{ $investment->status }}</div>
                                    </div>
                                @empty
                                    <div class="text-sm text-gray-400">Инвестиции пока не зарегистрированы.</div>
                                @endforelse
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="space-y-8">
                    <section class="glass-card p-8 rounded-[32px]">
                        <div class="text-xs font-black text-gray-500 uppercase tracking-widest mb-6">Автор и организация</div>
                        <div class="flex items-center space-x-4 mb-8">
                            <img src="{{ $technology->owner?->avatar ?? '/scientist.png' }}" class="w-16 h-16 rounded-3xl border border-white/10 object-cover">
                            <div>
                                <div class="text-white font-black text-lg">{{ $technology->owner?->name ?? 'Автор не указан' }}</div>
                                <div class="text-gray-500 text-xs font-bold uppercase">{{ $technology->organization->name ?? 'Организация не указана' }}</div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <button class="w-full py-4 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-red-600/20 hover:bg-red-500 transition-all">
                                Связаться с автором
                            </button>
                            @if(in_array($technology->status, ['selling', 'licensing', 'ready', 'investor_searching'], true))
                                <button class="w-full py-4 glass text-green-400 border-green-500/20 rounded-2xl font-black uppercase tracking-widest hover:bg-green-600 hover:text-white transition-all">
                                    Запросить сделку
                                </button>
                            @endif
                        </div>
                    </section>

                    <section class="glass-card p-8 rounded-[32px]">
                        <div class="text-xs font-black text-gray-500 uppercase tracking-widest mb-2">TRL: {{ $technology->trl_title }}</div>
                        <h4 class="text-xl font-black mb-6">Дорожная карта готовности</h4>
                        <div class="space-y-3">
                            @for($i = 1; $i <= 9; $i++)
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 text-[10px] font-black text-gray-600">TRL {{ $i }}</div>
                                    <div class="flex-grow h-2 rounded-full {{ $i <= $technology->trl ? 'bg-red-500 glow-red' : 'bg-white/5' }}"></div>
                                    @if($i === $technology->trl)
                                        <div class="w-2 h-2 rounded-full bg-white shadow-[0_0_10px_#fff]"></div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('analyzeBtn')?.addEventListener('click', async function () {
            const btn = this;
            const result = document.getElementById('aiResult');
            const score = document.getElementById('aiScore');

            btn.disabled = true;
            btn.textContent = 'Анализируем...';

            try {
                const response = await fetch('{{ route('ai.analyze') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ text: @js($technology->title . "\n" . $technology->description) }),
                });
                const data = await response.json();
                score.textContent = data.score + '/100';
                result.innerHTML = `
                    <div class="p-6 glass rounded-2xl border-white/5 md:col-span-2">
                        <div class="text-[9px] uppercase font-black text-gray-500 mb-2">Краткий вывод</div>
                        <div class="text-white font-bold opacity-80">${data.summary}</div>
                    </div>
                    <div class="p-6 glass rounded-2xl border-white/5">
                        <div class="text-[9px] uppercase font-black text-gray-500 mb-2">Сильные стороны</div>
                        <ul class="space-y-2 text-sm text-gray-300">${data.strengths.map(item => `<li>${item}</li>`).join('')}</ul>
                    </div>
                    <div class="p-6 glass rounded-2xl border-white/5">
                        <div class="text-[9px] uppercase font-black text-gray-500 mb-2">Риски</div>
                        <ul class="space-y-2 text-sm text-gray-300">${data.risks.map(item => `<li>${item}</li>`).join('')}</ul>
                    </div>
                    <div class="p-6 glass rounded-2xl border-white/5 md:col-span-2">
                        <div class="text-[9px] uppercase font-black text-gray-500 mb-2">Бизнес-модель</div>
                        <div class="text-white font-bold opacity-80">${data.business_model}</div>
                    </div>
                `;
            } finally {
                btn.disabled = false;
                btn.textContent = 'Пересчитать AI-анализ';
            }
        });
    </script>
</x-app-layout>
