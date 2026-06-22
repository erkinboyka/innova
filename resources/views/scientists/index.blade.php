<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="text-xs uppercase tracking-widest text-green-400 font-black">Research network</div>
            <h2 class="font-black text-3xl text-white tracking-tight">Национальный каталог ученых</h2>
        </div>
    </x-slot>

    <div class="py-12 relative overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10 relative z-10">
            <div class="glass-card p-5 rounded-3xl grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" placeholder="Поиск экспертов" class="md:col-span-2 bg-white/5 border-white/10 focus:border-red-500 focus:ring-red-500 rounded-2xl text-white placeholder-gray-500 h-14 px-6">
                <select class="bg-white/5 border-white/10 focus:border-red-500 focus:ring-red-500 rounded-2xl text-white h-14 px-6">
                    <option>Все области науки</option>
                    <option>IT и AI</option>
                    <option>Сельское хозяйство</option>
                    <option>Медицина</option>
                    <option>Энергетика</option>
                </select>
                <button class="bg-red-600 px-8 h-14 rounded-2xl font-black uppercase tracking-widest hover:bg-red-500 transition-all shadow-lg shadow-red-600/20">Найти</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($scientists as $scientist)
                    <article class="glass-card p-6 rounded-[32px] hover:border-white/20 transition-all group relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-green-500/10 blur-3xl"></div>
                        <div class="relative mb-6">
                            <div class="w-full h-56 rounded-2xl overflow-hidden shadow-2xl border border-white/5">
                                <img src="{{ $scientist->avatar ?? '/scientist.png' }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0" alt="{{ $scientist->name }}">
                            </div>
                            <div class="absolute -bottom-3 left-4 glass px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest text-green-400 border-green-500/20">
                                {{ $scientist->position ?? 'Исследователь' }}
                            </div>
                        </div>

                        <h3 class="text-xl font-black text-white mb-1 group-hover:text-red-500 transition-colors">{{ $scientist->name }}</h3>
                        <p class="text-xs font-bold text-gray-500 mb-6 uppercase tracking-wider">{{ $scientist->organization_name ?? $scientist->organization?->name ?? 'Организация не указана' }}</p>

                        <div class="flex justify-between items-center border-t border-white/5 pt-4">
                            <div class="flex flex-col">
                                <span class="text-[9px] uppercase font-black text-gray-500 tracking-widest">Проекты</span>
                                <span class="text-lg font-black text-white">{{ $scientist->technologies_count ?? $scientist->technologies()->count() }}</span>
                            </div>
                            <a href="{{ route('scientists.show', $scientist) }}" class="p-3 glass rounded-2xl hover:bg-red-600 hover:text-white transition-all text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="glass-card p-8 rounded-[32px] md:col-span-3 lg:col-span-4 text-gray-400">
                        В каталоге пока нет пользователей с ролью ученого.
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $scientists->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
