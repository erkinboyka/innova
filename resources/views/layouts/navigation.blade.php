@php
    $navItems = [
        ['label' => 'Панель', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard')],
        ['label' => 'Разработки', 'route' => 'technologies.index', 'active' => request()->routeIs('technologies.*')],
        ['label' => 'Маркетплейс', 'route' => 'marketplace.index', 'active' => request()->routeIs('marketplace.*')],
        ['label' => 'Запросы', 'route' => 'requests.index', 'active' => request()->routeIs('requests.*')],
        ['label' => 'Гранты', 'route' => 'grants.index', 'active' => request()->routeIs('grants.*')],
        ['label' => 'Учёные', 'route' => 'scientists.index', 'active' => request()->routeIs('scientists.*')],
        ['label' => 'Новости', 'route' => 'news.index', 'active' => request()->routeIs('news.*')],
    ];

    if (auth()->user()?->role === 'agency') {
        $navItems[] = ['label' => 'Админ', 'route' => 'admin.index', 'active' => request()->routeIs('admin.*')];
    }
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-white/8 bg-[#080d12]/95 backdrop-blur">
    <div class="mx-auto max-w-[1480px] px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-400 text-xs font-black text-slate-950">NTS</div>
                    <span class="text-sm font-black uppercase tracking-[0.18em] text-white">Innovation TJ</span>
                </a>

                <div class="hidden items-center gap-1 md:flex">
                    @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}" class="rounded-lg px-3 py-2 text-sm font-semibold transition {{ $item['active'] ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden items-center gap-3 md:flex">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 rounded-xl border border-white/8 bg-slate-950/70 px-3 py-2 text-xs font-bold text-slate-300 uppercase">
                        {{ App::getLocale() }}
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-24 rounded-xl border border-white/8 bg-slate-900 p-1 shadow-2xl">
                        <a href="{{ route('lang.switch', 'ru') }}" class="block px-3 py-2 text-xs font-bold text-slate-300 hover:text-white hover:bg-white/5 rounded-lg">RU</a>
                        <a href="{{ route('lang.switch', 'tj') }}" class="block px-3 py-2 text-xs font-bold text-slate-300 hover:text-white hover:bg-white/5 rounded-lg">TJ</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="block px-3 py-2 text-xs font-bold text-slate-300 hover:text-white hover:bg-white/5 rounded-lg">EN</a>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-xl border border-white/8 bg-slate-950/70 px-3 py-2 text-sm font-semibold text-slate-300 hover:text-white">
                    <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=111827&color=e2e8f0' }}" class="h-6 w-6 rounded-full" alt="">
                    <span>{{ Auth::user()->name }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-xl bg-slate-800 px-3 py-2 text-sm font-bold text-slate-300 hover:bg-slate-700 hover:text-white">Выйти</button>
                </form>
            </div>

            <button @click="open = ! open" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 hover:bg-slate-900 hover:text-white md:hidden">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-white/8 md:hidden">
        <div class="space-y-1 px-4 py-3">
            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}" class="block rounded-lg px-3 py-2 text-sm font-semibold {{ $item['active'] ? 'bg-slate-800 text-white' : 'text-slate-400' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <div class="border-t border-white/8 pt-3">
                <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-slate-300">Профиль</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="block w-full rounded-lg px-3 py-2 text-left text-sm font-semibold text-slate-300">Выйти</button>
                </form>
            </div>
        </div>
    </div>
</nav>
