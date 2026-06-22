<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-black tracking-tight text-white">Админ-панель агентства</h2>
                <p class="mt-1 text-sm text-slate-500">Организации, верификация участников, гранты, программы и конкурсная инфраструктура.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex h-10 items-center rounded-xl bg-slate-800 px-4 text-xs font-black uppercase tracking-[0.14em] text-white hover:bg-slate-700">
                Dashboard
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-[1480px] space-y-5 px-4 py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="rounded-xl border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm font-semibold text-emerald-200">{{ session('success') }}</div>
        @endif

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach([
                ['label' => 'Организации', 'value' => $stats['organizations'], 'hint' => 'НИИ, университеты, лаборатории'],
                ['label' => 'Подтверждены', 'value' => $stats['verified_organizations'], 'hint' => 'верифицированные учреждения'],
                ['label' => 'Очередь', 'value' => $stats['pending_users'], 'hint' => 'пользователи на проверке'],
                ['label' => 'Разработки', 'value' => $stats['technologies'], 'hint' => 'в реестре платформы'],
            ] as $stat)
                <article class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20">
                    <div class="text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">{{ $stat['label'] }}</div>
                    <div class="mt-4 text-4xl font-black text-white">{{ number_format($stat['value']) }}</div>
                    <div class="mt-1 text-xs text-slate-500">{{ $stat['hint'] }}</div>
                </article>
            @endforeach
        </section>

        <section class="grid grid-cols-1 gap-5 xl:grid-cols-12">
            <form method="POST" action="{{ route('admin.organizations.store') }}" class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20 xl:col-span-5">
                @csrf
                <h3 class="text-base font-black text-white">Добавить НИИ / университет</h3>
                <p class="mt-1 text-sm text-slate-500">Организация сразу создаётся как подтверждённая агентством.</p>
                <div class="mt-5 space-y-3">
                    <input name="name" value="{{ old('name') }}" required placeholder="Название организации" class="h-11 w-full rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400">
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <select name="type" required class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                            <option value="nii">НИИ</option>
                            <option value="university">Университет</option>
                            <option value="lab">Лаборатория</option>
                            <option value="tech-park">Технопарк</option>
                            <option value="incubator">Инкубатор</option>
                        </select>
                        <input name="region" value="{{ old('region') }}" placeholder="Регион" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400">
                    </div>
                    <input name="website" value="{{ old('website') }}" placeholder="https://example.tj" class="h-11 w-full rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400">
                    <textarea name="description" rows="3" placeholder="Описание профиля, лабораторий, направлений" class="w-full rounded-xl border-slate-800 bg-slate-950/70 p-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400">{{ old('description') }}</textarea>
                    <button class="h-11 w-full rounded-xl bg-emerald-400 px-5 text-xs font-black uppercase tracking-[0.14em] text-slate-950 hover:bg-emerald-300">Добавить организацию</button>
                </div>
            </form>

            <form method="POST" action="{{ route('admin.grants.store') }}" class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20 xl:col-span-7">
                @csrf
                <h3 class="text-base font-black text-white">Добавить грант, программу или хакатон</h3>
                <p class="mt-1 text-sm text-slate-500">Появится в каталоге финансирования для учёных и организаций.</p>
                <div class="mt-5 grid grid-cols-1 gap-3 md:grid-cols-2">
                    <input name="title" value="{{ old('title') }}" required placeholder="Название программы" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400 md:col-span-2">
                    <input name="provider" value="{{ old('provider') }}" placeholder="Провайдер / министерство / фонд" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400">
                    <input name="budget" value="{{ old('budget') }}" type="number" min="0" step="100" placeholder="Бюджет" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400">
                    <input name="deadline" value="{{ old('deadline') }}" type="date" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                    <input name="link" value="{{ old('link') }}" placeholder="Ссылка на условия" class="h-11 rounded-xl border-slate-800 bg-slate-950/70 px-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400">
                    <textarea name="description" rows="3" required placeholder="Краткое описание условий, кто может участвовать, что финансируется" class="rounded-xl border-slate-800 bg-slate-950/70 p-4 text-sm text-slate-100 placeholder:text-slate-600 focus:border-emerald-400 focus:ring-emerald-400 md:col-span-2">{{ old('description') }}</textarea>
                    <button class="h-11 rounded-xl bg-emerald-400 px-5 text-xs font-black uppercase tracking-[0.14em] text-slate-950 hover:bg-emerald-300 md:col-span-2">Добавить программу</button>
                </div>
            </form>
        </section>

        <section class="grid grid-cols-1 gap-5 xl:grid-cols-12">
            <article class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20 xl:col-span-7">
                <h3 class="text-base font-black text-white">Очередь верификации</h3>
                <div class="mt-4 overflow-hidden rounded-xl border border-white/8">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-950/70 text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Пользователь</th>
                                <th class="px-4 py-3">Роль</th>
                                <th class="px-4 py-3">Проверка</th>
                                <th class="px-4 py-3 text-right">Действия</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/6">
                            @forelse($pendingUsers as $user)
                                <tr class="hover:bg-white/[0.03]">
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-slate-400">{{ $user->role }}</td>
                                    <td class="px-4 py-3 text-slate-400">{{ $user->verification_type ?? 'не указан' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            @if($user->role === 'scientist')
                                                <form method="POST" action="{{ route('admin.users.assign-scientist', $user) }}" class="flex gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="organization_id" class="h-9 w-44 rounded-lg border-slate-800 bg-slate-950 text-xs text-slate-100">
                                                        @foreach($organizations as $organization)
                                                            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button class="rounded-lg bg-emerald-400 px-3 text-xs font-black uppercase text-slate-950">Привязать</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.verify', $user) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="rounded-lg bg-emerald-400 px-3 py-2 text-xs font-black uppercase text-slate-950">Принять</button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="rounded-lg bg-rose-400/10 px-3 py-2 text-xs font-black uppercase text-rose-300">Отклонить</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">Очередь верификации пуста.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20 xl:col-span-5">
                <h3 class="text-base font-black text-white">Организации</h3>
                <div class="mt-4 space-y-3">
                    @forelse($organizations as $organization)
                        <div class="rounded-xl border border-white/8 bg-slate-950/50 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-bold text-white">{{ $organization->name }}</div>
                                    <div class="mt-1 text-xs text-slate-500">{{ $organization->type }} · {{ $organization->region ?? 'регион не указан' }}</div>
                                </div>
                                <span class="rounded-lg bg-emerald-400/10 px-2 py-1 text-xs font-bold text-emerald-300">{{ $organization->verification_status }}</span>
                            </div>
                            <div class="mt-3 grid grid-cols-2 gap-3 text-xs text-slate-500">
                                <div>Учёные: <span class="font-bold text-slate-200">{{ $organization->members_count }}</span></div>
                                <div>Проекты: <span class="font-bold text-slate-200">{{ $organization->technologies_count }}</span></div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-white/8 bg-slate-950/50 p-6 text-center text-sm text-slate-500">Организации пока не добавлены.</div>
                    @endforelse
                </div>
            </article>
        </section>

        <section class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-black text-white">Последние программы</h3>
                <a href="{{ route('grants.index') }}" class="text-xs font-black uppercase tracking-[0.14em] text-emerald-300">Каталог</a>
            </div>
            <div class="mt-4 grid grid-cols-1 gap-3 lg:grid-cols-4">
                @forelse($grants as $grant)
                    <div class="rounded-xl border border-white/8 bg-slate-950/50 p-4">
                        <div class="text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">{{ $grant->provider ?? 'Провайдер' }}</div>
                        <div class="mt-2 font-bold text-white">{{ $grant->title }}</div>
                        <div class="mt-2 text-xs text-slate-500">до {{ $grant->deadline?->format('d.m.Y') ?? 'без срока' }}</div>
                    </div>
                @empty
                    <div class="rounded-xl border border-white/8 bg-slate-950/50 p-6 text-center text-sm text-slate-500 lg:col-span-4">Программы ещё не добавлены.</div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
