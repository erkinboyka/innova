<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="text-xs uppercase tracking-widest text-slate-500 font-black">Global Search</div>
            <h2 class="font-black text-3xl text-white tracking-tight">Результаты поиска по запросу: "{{ $q }}"</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <!-- Technologies -->
            <section>
                <h3 class="text-xl font-black text-white mb-6 px-4 flex items-center gap-3">
                    <span class="w-2 h-8 bg-red-600 rounded-full"></span>
                    Разработки ({{ $technologies->count() }})
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($technologies as $tech)
                        <article class="glass-card p-6 rounded-3xl hover:border-red-500/30 transition-all">
                            <h4 class="text-lg font-black text-white mb-2">{{ $tech->title }}</h4>
                            <p class="text-xs text-gray-500 line-clamp-2 mb-4">{{ $tech->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black uppercase text-red-500">TRL {{ $tech->trl }}</span>
                                <a href="{{ route('technologies.show', $tech) }}" class="text-xs font-bold text-white hover:text-red-500 transition">Открыть</a>
                            </div>
                        </article>
                    @empty
                        <p class="px-4 text-gray-500">Ничего не найдено в разработках.</p>
                    @endforelse
                </div>
            </section>

            <!-- Scientists -->
            <section>
                <h3 class="text-xl font-black text-white mb-6 px-4 flex items-center gap-3">
                    <span class="w-2 h-8 bg-green-500 rounded-full"></span>
                    Ученые ({{ $scientists->count() }})
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($scientists as $scientist)
                        <article class="glass-card p-4 rounded-3xl flex items-center gap-4">
                            <img src="{{ $scientist->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($scientist->name) }}" class="w-12 h-12 rounded-xl object-cover">
                            <div>
                                <h4 class="text-sm font-black text-white">{{ $scientist->name }}</h4>
                                <a href="{{ route('scientists.show', $scientist) }}" class="text-[10px] font-bold text-green-500 uppercase">Профиль</a>
                            </div>
                        </article>
                    @empty
                        <p class="px-4 text-gray-500">Ничего не найдено среди ученых.</p>
                    @endforelse
                </div>
            </section>

            <!-- Organizations -->
            <section>
                <h3 class="text-xl font-black text-white mb-6 px-4 flex items-center gap-3">
                    <span class="w-2 h-8 bg-blue-500 rounded-full"></span>
                    Организации ({{ $organizations->count() }})
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($organizations as $org)
                        <article class="glass-card p-6 rounded-3xl">
                            <h4 class="text-lg font-black text-white">{{ $org->name }}</h4>
                            <p class="text-xs text-gray-500 uppercase mt-1">{{ $org->type }} · {{ $org->region }}</p>
                        </article>
                    @empty
                        <p class="px-4 text-gray-500">Ничего не найдено среди организаций.</p>
                    @endforelse
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
