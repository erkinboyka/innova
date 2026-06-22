<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div x-data="{ method: 'email' }" class="space-y-8">
        <div class="flex p-1 bg-white/5 rounded-2xl border border-white/5">
            <button @click="method = 'email'" :class="method === 'email' ? 'bg-red-600 shadow-lg' : 'text-gray-500'" class="flex-1 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all duration-300">
                Email
            </button>
            <button @click="method = 'phone'" :class="method === 'phone' ? 'bg-red-600 shadow-lg' : 'text-gray-500'" class="flex-1 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all duration-300">
                Телефон
            </button>
        </div>

        <form method="POST" action="{{ route('login') }}" x-show="method === 'email'">
            @csrf
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase text-gray-500 tracking-widest">Email</label>
                    <input id="email" class="block w-full bg-white/5 border-white/10 rounded-2xl h-14 px-6 text-white focus:border-red-500 focus:ring-red-500 transition-all font-medium" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="example@mail.tj">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase text-gray-500 tracking-widest">Пароль</label>
                    <input id="password" class="block w-full bg-white/5 border-white/10 rounded-2xl h-14 px-6 text-white focus:border-red-500 focus:ring-red-500 transition-all font-medium" type="password" name="password" required placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-white/10 bg-white/5 text-red-600 focus:ring-red-500" name="remember">
                    <span class="ms-2 text-xs font-bold text-gray-500">Запомнить меня</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-red-500 hover:text-red-400 transition-colors" href="{{ route('password.request') }}">
                        Забыли пароль?
                    </a>
                @endif
            </div>

            <button class="w-full mt-8 py-5 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-red-600/30 hover:bg-red-500 transform hover:-translate-y-1 transition-all">
                Войти в систему
            </button>
        </form>

        <form method="POST" action="{{ route('login') }}" x-show="method === 'phone'" x-cloak>
            @csrf
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase text-gray-500 tracking-widest">Номер телефона</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold">+992</span>
                        <input id="phone" class="block w-full bg-white/5 border-white/10 rounded-2xl h-14 pl-20 pr-6 text-white focus:border-red-500 focus:ring-red-500 transition-all font-black text-lg tracking-widest" type="text" name="phone" placeholder="00 000 00 00" x-mask="99 999 99 99">
                    </div>
                </div>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest text-center">Мы отправим вам SMS с кодом подтверждения</p>
            </div>

            <button type="button" class="w-full mt-8 py-5 bg-white text-black rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-white/10 hover:bg-gray-200 transform hover:-translate-y-1 transition-all">
                Получить код
            </button>
        </form>

        <div class="relative py-4">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/5"></div></div>
            <div class="relative flex justify-center text-[9px] uppercase font-black text-gray-600 tracking-widest"><span class="bg-[#050a14] px-4">быстрый вход</span></div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <a href="{{ route('google.redirect') }}" class="flex items-center justify-center gap-3 py-4 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 transition-all group">
                <svg class="h-5 w-5 group-hover:rotate-12 transition-transform" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12.48 10.92V14.28H18.96C18.6 16.08 17.04 18.24 12.48 18.24C8.52 18.24 5.28 14.88 5.28 10.92C5.28 6.95998 8.52 3.59998 12.48 3.59998C14.76 3.59998 16.32 4.55998 17.16 5.39998L19.8 2.76C18.12 1.2 15.6 0.24 12.48 0.24C6.48 0.24 1.56 5.16 1.56 11.16C1.56 17.16 6.48 22.08 12.48 22.08C18.72 22.08 22.92 17.64 22.92 11.4C22.92 10.68 22.8 9.84 22.68 9.12H12.48V10.92Z" />
                </svg>
                <span class="text-xs font-black uppercase tracking-[0.2em]">Продолжить с Google</span>
            </a>
        </div>
    </div>
</x-guest-layout>
