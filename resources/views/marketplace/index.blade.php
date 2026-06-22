<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-black tracking-tight text-white">Маркетплейс технологий</h2>
                <p class="mt-1 text-sm text-slate-500">Лоты для лицензирования, покупки патента, пилота или инвестирования.</p>
            </div>
            <a href="{{ route('technologies.create') }}" class="inline-flex h-10 items-center rounded-xl bg-emerald-400 px-4 text-xs font-black uppercase tracking-[0.14em] text-slate-950 hover:bg-emerald-300">
                Разместить лот
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-[1480px] px-4 py-6 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('marketplace.index') }}" class="grid grid-cols-1 gap-3 rounded-2xl border border-white/8 bg-[#101820] p-4 shadow-xl shadow-black/20 md:grid-cols-4">
            <input name="q" value="{{ request('q') }}" type="search" placeholder="Поиск технологии" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400 md:col-span-2">
            <select name="trl_min" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                <option value="">Любая готовность</option>
                @foreach([3, 5, 7, 9] as $level)
                    <option value="{{ $level }}" @selected((string) request('trl_min') === (string) $level)>TRL от {{ $level }}</option>
                @endforeach
            </select>
            <button class="h-11 rounded-xl bg-slate-800 px-5 text-xs font-black uppercase tracking-[0.14em] text-white hover:bg-slate-700">Фильтр</button>
        </form>

        <section class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
            @forelse($technologies as $tech)
                <article class="group relative overflow-hidden rounded-[32px] border border-white/10 bg-slate-950 p-6 transition-all hover:border-red-500/50 hover:shadow-2xl hover:shadow-red-500/10">
                    <div class="mb-6 flex items-start justify-between">
                        <div class="flex flex-col gap-2">
                            <span class="w-fit rounded-full bg-red-600/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-red-500">
                                {{ $tech->category ?? 'Технология' }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-500">{{ $tech->organization->name ?? 'Таджикистан' }}</span>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-2xl font-black text-white">TRL {{ $tech->trl }}</span>
                            <span class="text-[10px] font-bold text-slate-600 uppercase tracking-tighter">Уровень готовности</span>
                        </div>
                    </div>

                    <h3 class="min-h-[3.5rem] text-xl font-black leading-tight text-white group-hover:text-red-500 transition-colors">
                        {{ $tech->title }}
                    </h3>
                    <p class="mt-4 line-clamp-3 min-h-[4.5rem] text-sm leading-relaxed text-slate-400">
                        {{ $tech->description }}
                    </p>

                    <div class="mt-8 flex items-end justify-between">
                        <div>
                            @if($tech->cost)
                                <div class="text-[10px] font-black uppercase tracking-widest text-slate-500">Инвестиции</div>
                                <div class="text-lg font-black text-white">{{ number_format($tech->cost, 0, '.', ' ') }} <span class="text-slate-500">{{ $tech->currency }}</span></div>
                            @else
                                <div class="text-[10px] font-black uppercase tracking-widest text-slate-500">Статус</div>
                                <div class="text-sm font-black text-emerald-400">Переговоры</div>
                            @endif
                        </div>
                        <a href="{{ route('technologies.show', $tech) }}" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/5 text-white transition-all group-hover:bg-red-600 group-hover:scale-110">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-white/8 bg-[#101820] px-5 py-12 text-center text-slate-500 lg:col-span-3">
                    В маркетплейсе пока нет технологий со статусом продажи, лицензирования или поиска инвестиций.
                </div>
            @endforelse
        </section>

        <div class="mt-5">{{ $technologies->links() }}</div>
    </div>
</x-app-layout>
