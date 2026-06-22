<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-white tracking-tight">Профиль ученого</h2>
    </x-slot>

    <div class="py-12 relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10 relative z-10">
            <section class="glass-card rounded-[32px] p-8 lg:p-10 flex flex-col md:flex-row gap-10 items-center overflow-hidden relative">
                <div class="absolute right-0 top-0 w-80 h-80 bg-red-600/10 blur-[100px]"></div>

                <div class="w-44 h-44 rounded-[32px] overflow-hidden border-2 border-white/10 glass shadow-2xl relative group shrink-0">
                    <img src="{{ $scientist->avatar ?? '/scientist.png' }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500" alt="{{ $scientist->name }}">
                </div>

                <div class="flex-grow text-center md:text-left relative z-10">
                    <h3 class="text-4xl font-black mb-2 text-glow">{{ $scientist->name }}</h3>
                    <p class="text-red-500 font-bold uppercase tracking-widest text-xs mb-6">{{ $scientist->position ?? 'Исследователь' }}</p>

                    <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                        <div class="px-6 py-3 glass rounded-2xl border-white/5">
                            <span class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1">Организация</span>
                            <span class="text-white font-bold opacity-80">{{ $scientist->organization_name ?? $scientist->organization?->name ?? 'Не указана' }}</span>
                        </div>
                        <div class="px-6 py-3 glass rounded-2xl border-white/5">
                            <span class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1">Разработок</span>
                            <span class="text-white font-black text-lg">{{ $scientist->technologies->count() }}</span>
                        </div>
                        <div class="px-6 py-3 glass rounded-2xl border-white/5">
                            <span class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1">Роль</span>
                            <span class="text-white font-black text-lg">Ученый</span>
                        </div>
                    </div>
                </div>

                <div class="shrink-0 relative z-10">
                    <button class="px-10 py-4 bg-white text-black rounded-2xl font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all shadow-xl">
                        Написать
                    </button>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-2 space-y-10">
                    <div class="glass-card p-8 lg:p-10 rounded-[32px]">
                        <div class="text-xs font-black text-gray-500 uppercase tracking-widest mb-6">Компетенции</div>
                        <p class="text-lg text-gray-400 leading-relaxed">
                            Профиль используется как научный LinkedIn: разработки, патенты, публикации, компетенции и контакты автора доступны инвесторам, университетам и бизнесу.
                        </p>
                    </div>

                    <div class="space-y-6">
                        <h4 class="text-xl font-black px-4">Научные проекты и разработки</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($scientist->technologies as $tech)
                                <a href="{{ route('technologies.show', $tech) }}" class="glass-card p-6 rounded-3xl hover:border-red-500/30 transition-all group">
                                    <h5 class="text-lg font-black text-white mb-2 group-hover:text-red-500 transition-colors">{{ $tech->title }}</h5>
                                    <div class="flex justify-between items-center text-xs font-bold text-gray-500">
                                        <span>TRL {{ $tech->trl }}</span>
                                        <span class="uppercase tracking-widest">{{ $tech->status_label }}</span>
                                    </div>
                                </a>
                            @empty
                                <div class="glass-card p-6 rounded-3xl md:col-span-2 text-gray-400">
                                    У этого ученого пока нет опубликованных разработок.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <aside class="space-y-8">
                    <div class="glass-card p-8 rounded-[32px]">
                        <div class="text-xs font-black text-gray-500 uppercase tracking-widest mb-6">Для инвестора</div>
                        <div class="space-y-5 text-sm text-gray-400">
                            <div class="flex justify-between gap-4">
                                <span>Готовых к рынку</span>
                                <span class="font-black text-white">{{ $scientist->technologies->where('trl', '>=', 7)->count() }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span>Ищут инвестиции</span>
                                <span class="font-black text-white">{{ $scientist->technologies->where('status', 'investor_searching')->count() }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span>Лицензируются</span>
                                <span class="font-black text-white">{{ $scientist->technologies->where('status', 'licensing')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </aside>
            </section>
        </div>
    </div>
</x-app-layout>
