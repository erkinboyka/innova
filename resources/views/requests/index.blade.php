<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-white">Биржа технологических запросов</h2>
            <p class="mt-1 text-sm text-slate-500">Бизнес формулирует задачу, учёные предлагают разработку или пилот.</p>
        </div>
    </x-slot>

    <div class="mx-auto grid max-w-[1480px] grid-cols-1 gap-5 px-4 py-6 sm:px-6 lg:grid-cols-12 lg:px-8">
        <section class="space-y-5 lg:col-span-8">
            @if(session('success'))
                <div class="rounded-xl border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm font-semibold text-emerald-200">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('requests.index') }}" class="grid grid-cols-1 gap-3 rounded-2xl border border-white/8 bg-[#101820] p-4 shadow-xl shadow-black/20 md:grid-cols-4">
                <input name="q" value="{{ request('q') }}" type="search" placeholder="Поиск запроса" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400 md:col-span-2">
                <select name="status" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                    <option value="">Любой статус</option>
                    <option value="open" @selected(request('status') === 'open')>Открыт</option>
                    <option value="in-progress" @selected(request('status') === 'in-progress')>В работе</option>
                    <option value="closed" @selected(request('status') === 'closed')>Закрыт</option>
                </select>
                <button class="h-11 rounded-xl bg-slate-800 px-5 text-xs font-black uppercase tracking-[0.14em] text-white hover:bg-slate-700">Найти</button>
            </form>

            <div class="space-y-3">
                @forelse($requests as $request)
                    <article class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <div class="text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">{{ $request->company->name ?? 'Компания' }}</div>
                                <h3 class="mt-1 text-lg font-black text-white">{{ $request->title }}</h3>
                            </div>
                            <span class="w-fit rounded-lg bg-emerald-400/10 px-2 py-1 text-xs font-bold text-emerald-300">{{ $request->status_label }}</span>
                        </div>
                        <p class="mt-4 line-clamp-3 text-sm leading-6 text-slate-500">{{ $request->description }}</p>
                        <div class="mt-4 grid grid-cols-2 gap-3 border-t border-white/6 pt-4 text-sm">
                            <div><span class="text-slate-500">Бюджет:</span> <span class="font-bold text-white">{{ $request->budget ? number_format($request->budget, 0, '.', ' ').' сомони' : 'открыт' }}</span></div>
                            <div class="text-right"><span class="text-slate-500">Срок:</span> <span class="font-bold text-white">{{ $request->deadline?->format('d.m.Y') ?? 'не указан' }}</span></div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-white/8 bg-[#101820] px-5 py-12 text-center text-slate-500">Запросы не найдены.</div>
                @endforelse
            </div>

            {{ $requests->links() }}
        </section>

        <aside class="lg:col-span-4">
            <form method="POST" action="{{ route('requests.store') }}" class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20">
                @csrf
                <h3 class="text-base font-black text-white">Опубликовать запрос</h3>
                <p class="mt-1 text-sm text-slate-500">Для бизнеса, инвесторов и агентства после проверки аккаунта.</p>
                <div class="mt-5 space-y-3">
                    <input name="title" value="{{ old('title') }}" required placeholder="Нужна технология..." class="h-11 w-full rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400">
                    <textarea name="description" rows="4" required placeholder="Описание задачи" class="w-full rounded-xl border-slate-800 bg-slate-950/70 p-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400"></textarea>
                    <div class="grid grid-cols-2 gap-3">
                        <input name="budget" value="{{ old('budget') }}" type="number" min="0" step="100" placeholder="Бюджет" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400">
                        <input name="deadline" value="{{ old('deadline') }}" type="date" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                    </div>
                    <button class="h-11 w-full rounded-xl bg-emerald-400 px-5 text-xs font-black uppercase tracking-[0.14em] text-slate-950 hover:bg-emerald-300">Разместить</button>
                </div>
            </form>
        </aside>
    </div>
</x-app-layout>
