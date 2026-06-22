<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-black tracking-tight text-white">Реестр научных разработок</h2>
                <p class="mt-1 text-sm text-slate-500">Проекты НИИ, университетов и учёных для оценки TRL и коммерциализации.</p>
            </div>
            <a href="{{ route('technologies.create') }}" class="inline-flex h-10 items-center rounded-xl bg-emerald-400 px-4 text-xs font-black uppercase tracking-[0.14em] text-slate-950 hover:bg-emerald-300">
                Добавить проект
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-[1480px] px-4 py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-5 rounded-xl border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm font-semibold text-emerald-200">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('technologies.index') }}" class="grid grid-cols-1 gap-3 rounded-2xl border border-white/8 bg-[#101820] p-4 shadow-xl shadow-black/20 md:grid-cols-4">
            <input name="q" value="{{ request('q') }}" type="search" placeholder="Поиск по названию или описанию" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400 md:col-span-2">
            <select name="trl" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                <option value="">Любой TRL</option>
                @for($i = 1; $i <= 9; $i++)
                    <option value="{{ $i }}" @selected((string) request('trl') === (string) $i)>TRL {{ $i }}</option>
                @endfor
            </select>
            <button class="h-11 rounded-xl bg-slate-800 px-5 text-xs font-black uppercase tracking-[0.14em] text-white hover:bg-slate-700">Найти</button>
        </form>

        <section class="mt-5 overflow-hidden rounded-2xl border border-white/8 bg-[#101820] shadow-xl shadow-black/20">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-950/70 text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Разработка</th>
                        <th class="px-5 py-3">Организация</th>
                        <th class="px-5 py-3">Автор</th>
                        <th class="px-5 py-3">TRL</th>
                        <th class="px-5 py-3">Статус</th>
                        <th class="px-5 py-3 text-right">Действие</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/6">
                    @forelse($technologies as $tech)
                        <tr class="hover:bg-white/[0.03]">
                            <td class="max-w-md px-5 py-4">
                                <div class="font-bold text-white">{{ $tech->title }}</div>
                                <p class="mt-1 line-clamp-2 text-xs leading-5 text-slate-500">{{ $tech->description }}</p>
                            </td>
                            <td class="px-5 py-4 text-slate-400">{{ $tech->organization->name ?? 'Не привязана' }}</td>
                            <td class="px-5 py-4 text-slate-400">{{ $tech->owner?->name ?? 'Автор не указан' }}</td>
                            <td class="px-5 py-4"><span class="rounded-lg bg-amber-400/10 px-2 py-1 text-xs font-black text-amber-300">TRL {{ $tech->trl }}</span></td>
                            <td class="px-5 py-4"><span class="rounded-lg bg-emerald-400/10 px-2 py-1 text-xs font-bold text-emerald-300">{{ $tech->status_label }}</span></td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('technologies.show', $tech) }}" class="text-xs font-black uppercase tracking-[0.14em] text-emerald-300 hover:text-emerald-200">Открыть</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-500">Разработки не найдены. Создайте первую карточку технологии для реестра.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <div class="mt-5">{{ $technologies->links() }}</div>
    </div>
</x-app-layout>
