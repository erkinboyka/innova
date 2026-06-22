<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="text-xs uppercase tracking-widest text-red-500 font-black">Latest Updates</div>
            <h2 class="font-black text-3xl text-white tracking-tight">Новости науки и инноваций</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($news as $article)
                    <article class="glass-card rounded-[32px] overflow-hidden group">
                        @if($article->image)
                            <img src="{{ $article->image }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-red-600/20 to-black flex items-center justify-center">
                                <span class="text-white font-black text-4xl opacity-20">NEWS</span>
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-[10px] font-black uppercase text-red-500">{{ $article->category ?? 'Наука' }}</span>
                                <span class="text-[10px] font-bold text-gray-500">{{ $article->created_at->format('d.m.Y') }}</span>
                            </div>
                            <h3 class="text-xl font-black text-white mb-4 leading-tight group-hover:text-red-500 transition-colors">{{ $article->title }}</h3>
                            <p class="text-sm text-gray-400 line-clamp-3 mb-6">{{ $article->content }}</p>
                            <a href="#" class="text-xs font-black uppercase tracking-widest text-white border-b-2 border-red-600 pb-1">Читать далее</a>
                        </div>
                    </article>
                @empty
                    <div class="glass-card p-12 text-center text-gray-500 md:col-span-3">
                        Новости появятся в ближайшее время.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
