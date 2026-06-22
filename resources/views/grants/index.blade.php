<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-white">Гранты, программы и конкурсы</h2>
            <p class="mt-1 text-sm text-slate-500">Финансирование, хакатоны и конкурсные программы для научных команд.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-[1480px] px-4 py-6 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('grants.index') }}" class="flex flex-col gap-3 rounded-2xl border border-white/8 bg-[#101820] p-4 shadow-xl shadow-black/20 sm:flex-row">
            <input name="q" value="{{ request('q') }}" type="search" placeholder="Поиск гранта, конкурса или провайдера" class="h-11 min-w-0 flex-1 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400">
            <button class="h-11 rounded-xl bg-slate-800 px-5 text-xs font-black uppercase tracking-[0.14em] text-white hover:bg-slate-700">Найти</button>
        </form>

        <section class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-3">
            @forelse($grants as $grant)
                <article class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20">
                    <div class="flex items-start justify-between gap-4">
                        <div class="text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">{{ $grant->provider ?? 'Грантодатель' }}</div>
                        <span class="rounded-lg bg-amber-400/10 px-2 py-1 text-xs font-bold text-amber-300">{{ $grant->deadline?->format('d.m.Y') ?? 'без срока' }}</span>
                    </div>
                    <h3 class="mt-4 text-lg font-black leading-tight text-white">{{ $grant->title }}</h3>
                    <p class="mt-3 line-clamp-4 text-sm leading-6 text-slate-500">{{ $grant->description }}</p>
                    <div class="mt-5 flex items-center justify-between border-t border-white/6 pt-4">
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">Бюджет</div>
                            <div class="mt-1 font-black text-white">{{ $grant->budget ? number_format($grant->budget, 0, '.', ' ').' сомони' : 'не указан' }}</div>
                        </div>
                        @if($grant->link)
                            <a href="{{ $grant->link }}" target="_blank" class="rounded-xl bg-emerald-400 px-4 py-2 text-xs font-black uppercase tracking-[0.14em] text-slate-950 hover:bg-emerald-300">Открыть</a>
                        @else
                            <span class="rounded-xl bg-slate-800 px-4 py-2 text-xs font-black uppercase tracking-[0.14em] text-slate-400">Заявка</span>
                        @endif
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-white/8 bg-[#101820] px-5 py-12 text-center text-slate-500 lg:col-span-3">
                    Гранты не найдены. Каталог можно заполнить через сидер или админ-панель.
                </div>
            @endforelse
        </section>

        <div class="mt-5">{{ $grants->links() }}</div>
    </div>
</x-app-layout>
