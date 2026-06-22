<x-app-layout>
    <div class="min-h-screen bg-[#080d12] text-slate-100">
        <div class="mx-auto flex w-full max-w-[1480px] gap-5 px-4 py-5 sm:px-6 lg:px-8">
            <aside class="hidden w-64 shrink-0 rounded-2xl border border-white/8 bg-[#0c131a]/95 p-4 shadow-2xl shadow-black/30 lg:block">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-2 py-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-400 text-sm font-black text-slate-950">NTS</div>
                    <div>
                        <div class="text-sm font-black uppercase tracking-[0.16em]">Tajikistan</div>
                        <div class="text-[10px] font-bold uppercase tracking-[0.24em] text-slate-500">Innovation Office</div>
                    </div>
                </a>

                <nav class="mt-8 space-y-1 text-sm font-semibold text-slate-400">
                    @foreach([
                        ['label' => 'Home', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard')],
                        ['label' => 'Projects', 'route' => 'technologies.index', 'active' => request()->routeIs('technologies.*')],
                        ['label' => 'TRL Tools', 'route' => 'technologies.create', 'active' => request()->routeIs('technologies.create')],
                        ['label' => 'Marketplace', 'route' => 'marketplace.index', 'active' => request()->routeIs('marketplace.*')],
                        ['label' => 'Business Requests', 'route' => 'requests.index', 'active' => request()->routeIs('requests.*')],
                        ['label' => 'Grants & Programs', 'route' => 'grants.index', 'active' => request()->routeIs('grants.*')],
                        ['label' => 'Scientists', 'route' => 'scientists.index', 'active' => request()->routeIs('scientists.*')],
                    ] as $item)
                        <a href="{{ route($item['route']) }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 transition {{ $item['active'] ? 'bg-slate-800 text-white shadow-inner shadow-white/5' : 'hover:bg-slate-900 hover:text-slate-100' }}">
                            <span>{{ $item['label'] }}</span>
                            @if($item['active'])
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                            @endif
                        </a>
                    @endforeach
                </nav>

                <div class="mt-8 rounded-2xl border border-emerald-400/20 bg-emerald-400/8 p-4">
                    <div class="text-[10px] font-black uppercase tracking-[0.18em] text-emerald-300">Verification</div>
                    <div class="mt-3 grid grid-cols-2 gap-3">
                        <div>
                            <div class="text-2xl font-black">{{ $pendingScientistsCount }}</div>
                            <div class="text-[11px] text-slate-500">scientists</div>
                        </div>
                        <div>
                            <div class="text-2xl font-black">{{ $pendingBusinessCount }}</div>
                            <div class="text-[11px] text-slate-500">business</div>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="min-w-0 flex-1 space-y-5">
                <header class="flex flex-col gap-4 rounded-2xl border border-white/8 bg-[#0c131a]/95 px-6 py-6 shadow-2xl shadow-black/25 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-black tracking-tight text-white sm:text-3xl">👋 Добро пожаловать, {{ $user->name }}!</h1>
                        <p class="mt-1 text-sm text-slate-500">
                            @if($user->role === 'scientist')
                                Управляйте вашими научными разработками, патентами и статьями в одном месте.
                            @elseif($user->role === 'investor')
                                Анализируйте ваш инвестиционный портфель и находите прорывные стартапы.
                            @elseif($user->role === 'admin' || $user->role === 'agency')
                                Панель управления национальной инновационной экосистемой.
                            @else
                                Исследуйте мир инноваций Таджикистана, гранты и научные достижения.
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <form method="GET" action="{{ route('search') }}" class="relative">
                            <input name="q" type="search" placeholder="Глобальный поиск..." class="h-12 w-full rounded-2xl border-slate-800 bg-slate-950/70 pl-5 pr-5 text-sm text-slate-200 placeholder:text-slate-600 focus:border-red-500 focus:ring-red-500 sm:w-80">
                        </form>
                        @if(in_array($user->role, ['scientist', 'university', 'nii', 'admin', 'agency']))
                            <a href="{{ route('technologies.create') }}" class="inline-flex h-12 items-center justify-center rounded-2xl bg-red-600 px-6 text-xs font-black uppercase tracking-[0.14em] text-white hover:bg-red-500 shadow-lg shadow-red-600/20">
                                Создать разработку
                            </a>
                        @endif
                    </div>
                </header>

                @if(session('success'))
                    <div class="rounded-xl border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm font-semibold text-emerald-200">{{ session('success') }}</div>
                @endif

                <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach($stats as $stat)
                        @php($tone = ['emerald' => 'text-emerald-300 bg-emerald-400/10', 'sky' => 'text-sky-300 bg-sky-400/10', 'amber' => 'text-amber-300 bg-amber-400/10', 'rose' => 'text-rose-300 bg-rose-400/10'][$stat['tone']] ?? 'text-slate-300 bg-slate-400/10')
                        <article class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20">
                            <div class="flex items-start justify-between gap-3">
                                <div class="rounded-xl {{ $tone }} px-3 py-2 text-xs font-black uppercase tracking-[0.14em]">{{ $stat['label'] }}</div>
                                <div class="text-xs font-black text-emerald-300">{{ $stat['delta'] }}</div>
                            </div>
                            <div class="mt-5 text-4xl font-black tracking-tight">{{ number_format($stat['value']) }}</div>
                            <div class="mt-1 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ $stat['hint'] }}</div>
                        </article>
                    @endforeach
                </section>

                <section class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                    <article class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20 xl:col-span-7">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-base font-black">Technology Transfer Activity</h2>
                                <p class="mt-1 text-xs text-slate-500">Проекты, заявки и вывод в marketplace</p>
                            </div>
                            <div class="rounded-lg border border-white/8 px-3 py-1 text-xs font-bold text-slate-400">2026</div>
                        </div>
                        <div class="mt-6 h-64 rounded-xl border border-white/6 bg-slate-950/40 p-4">
                            <div class="grid h-full grid-cols-12 items-end gap-2">
                                @foreach([32, 48, 76, 88, 54, 112, 95, 120, 104, 132, 118, 150] as $index => $height)
                                    <div class="flex h-full flex-col justify-end gap-2">
                                        <div class="rounded-t-md bg-emerald-400/80 shadow-[0_0_24px_rgba(52,211,153,0.28)]" style="height: {{ $height }}px"></div>
                                        <div class="h-px bg-white/5"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <article class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20 xl:col-span-5">
                        @php($totalTrl = max(1, array_sum($trlDistribution)))
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-base font-black">TRL Distribution</h2>
                                <p class="mt-1 text-xs text-slate-500">Готовность разработок</p>
                            </div>
                            <div class="rounded-lg border border-white/8 px-3 py-1 text-xs font-bold text-slate-400">Status</div>
                        </div>
                        <div class="mt-6 grid h-64 grid-cols-3 items-end gap-4 rounded-xl border border-white/6 bg-slate-950/40 p-5">
                            @foreach([
                                ['label' => 'TRL 1-3', 'value' => $trlDistribution['early'], 'color' => 'bg-emerald-400'],
                                ['label' => 'TRL 4-6', 'value' => $trlDistribution['prototype'], 'color' => 'bg-amber-400'],
                                ['label' => 'TRL 7-9', 'value' => $trlDistribution['market'], 'color' => 'bg-rose-400'],
                            ] as $bar)
                                <div class="flex h-full flex-col items-center justify-end gap-3">
                                    <div class="text-sm font-black">{{ $bar['value'] }}</div>
                                    <div class="w-full rounded-t-xl {{ $bar['color'] }}" style="height: {{ max(20, round($bar['value'] / $totalTrl * 190)) }}px"></div>
                                    <div class="text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">{{ $bar['label'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </article>
                </section>

                <section class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                    <article class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20 xl:col-span-5">
                        <h2 class="text-base font-black">Key TRL Assessment Indicators</h2>
                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            <div class="flex items-center justify-center">
                                <div class="relative flex h-44 w-44 items-center justify-center rounded-full border-[14px] border-slate-800">
                                    <div class="absolute inset-[-14px] rounded-full border-[14px] border-emerald-400 border-r-amber-400 border-b-slate-800"></div>
                                    <div class="text-center">
                                        <div class="text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">avg TRL</div>
                                        <div class="text-4xl font-black">{{ number_format(($trlDistribution['early'] * 2 + $trlDistribution['prototype'] * 5 + $trlDistribution['market'] * 8) / $totalTrl, 1) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-5">
                                <div>
                                    <div class="flex justify-between text-sm font-bold">
                                        <span>Completed</span>
                                        <span>{{ $totalTrl }}</span>
                                    </div>
                                    <div class="mt-2 h-2 rounded-full bg-slate-800"><div class="h-2 w-4/5 rounded-full bg-emerald-400"></div></div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm font-bold">
                                        <span>In verification</span>
                                        <span>{{ $pendingScientistsCount + $pendingBusinessCount }}</span>
                                    </div>
                                    <div class="mt-2 h-2 rounded-full bg-slate-800"><div class="h-2 w-2/5 rounded-full bg-amber-400"></div></div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm font-bold">
                                        <span>Investment pool</span>
                                        <span>{{ number_format($investmentTotal, 0, '.', ' ') }} с.</span>
                                    </div>
                                    <div class="mt-2 h-2 rounded-full bg-slate-800"><div class="h-2 w-3/5 rounded-full bg-sky-400"></div></div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-2xl border border-white/8 bg-[#101820] p-5 shadow-xl shadow-black/20 xl:col-span-7">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-black">Scientific Projects</h2>
                            <a href="{{ route('technologies.index') }}" class="text-xs font-black uppercase tracking-[0.16em] text-emerald-300">All projects</a>
                        </div>
                        <div class="mt-4 overflow-hidden rounded-xl border border-white/8">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-slate-950/70 text-[10px] font-black uppercase tracking-[0.16em] text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3">Project title</th>
                                        <th class="px-4 py-3">Organization</th>
                                        <th class="px-4 py-3">TRL</th>
                                        <th class="px-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/6">
                                    @forelse($latestTechnologies as $technology)
                                        <tr class="hover:bg-white/[0.03]">
                                            <td class="px-4 py-3">
                                                <a href="{{ route('technologies.show', $technology) }}" class="font-bold text-slate-100 hover:text-emerald-300">{{ $technology->title }}</a>
                                                <div class="mt-0.5 text-xs text-slate-500">{{ $technology->owner->name ?? 'Автор не указан' }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-slate-400">{{ $technology->organization->name ?? 'Не привязана' }}</td>
                                            <td class="px-4 py-3"><span class="rounded-lg bg-amber-400/10 px-2 py-1 text-xs font-black text-amber-300">TRL {{ $technology->trl }}</span></td>
                                            <td class="px-4 py-3"><span class="rounded-lg bg-emerald-400/10 px-2 py-1 text-xs font-bold text-emerald-300">{{ $technology->status_label }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-slate-500">Пока нет опубликованных разработок.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </article>
                </section>

                <section class="grid grid-cols-1 gap-5 xl:grid-cols-3">
                    <article class="rounded-2xl border border-white/8 bg-[#101820] p-5">
                        <h2 class="text-base font-black">Verification Queue</h2>
                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex items-center justify-between rounded-xl bg-slate-950/50 px-4 py-3">
                                <span class="text-slate-400">Учёные без проверки</span>
                                <span class="font-black text-amber-300">{{ $pendingScientistsCount }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-slate-950/50 px-4 py-3">
                                <span class="text-slate-400">Бизнес / инвесторы / агентства</span>
                                <span class="font-black text-amber-300">{{ $pendingBusinessCount }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-slate-950/50 px-4 py-3">
                                <span class="text-slate-400">Проверенные организации</span>
                                <span class="font-black text-emerald-300">{{ $verifiedOrganizationsCount }} / {{ $organizationsCount }}</span>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-2xl border border-white/8 bg-[#101820] p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-black">Programs & Grants</h2>
                            <a href="{{ route('grants.index') }}" class="text-xs font-black text-emerald-300">Catalog</a>
                        </div>
                        <div class="mt-4 space-y-3">
                            @forelse($grants as $grant)
                                <div class="rounded-xl bg-slate-950/50 px-4 py-3">
                                    <div class="font-bold">{{ $grant->title }}</div>
                                    <div class="mt-1 text-xs text-slate-500">{{ $grant->provider ?? 'Провайдер не указан' }} · до {{ $grant->deadline?->format('d.m.Y') ?? 'без срока' }}</div>
                                </div>
                            @empty
                                <div class="rounded-xl bg-slate-950/50 px-4 py-6 text-sm text-slate-500">Каталог грантов ожидает заполнения.</div>
                            @endforelse
                        </div>
                    </article>

                    <article class="rounded-2xl border border-white/8 bg-[#101820] p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-black">Business Requests</h2>
                            <a href="{{ route('requests.index') }}" class="text-xs font-black text-emerald-300">Exchange</a>
                        </div>
                        <div class="mt-4 space-y-3">
                            @forelse($requests as $request)
                                <div class="rounded-xl bg-slate-950/50 px-4 py-3">
                                    <div class="font-bold">{{ $request->title }}</div>
                                    <div class="mt-1 text-xs text-slate-500">{{ $request->company->name ?? 'Компания' }} · {{ $request->status_label }}</div>
                                </div>
                            @empty
                                <div class="rounded-xl bg-slate-950/50 px-4 py-6 text-sm text-slate-500">Биржа запросов пока пуста.</div>
                            @endforelse
                        </div>
                    </article>
                </section>
            </main>
        </div>
    </div>
</x-app-layout>
