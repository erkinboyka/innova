<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500 mb-2">ФИО / название аккаунта</label>
            <input id="name" class="block w-full rounded-xl border-slate-800 bg-slate-950/70 h-12 px-4 text-slate-100 focus:border-emerald-400 focus:ring-emerald-400" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div>
            <label class="block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500 mb-2">Email</label>
            <input id="email" class="block w-full rounded-xl border-slate-800 bg-slate-950/70 h-12 px-4 text-slate-100 focus:border-emerald-400 focus:ring-emerald-400" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500 mb-2">Роль</label>
                <select name="role" required class="block w-full rounded-xl border-slate-800 bg-slate-950/70 h-12 px-4 text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                    @foreach([
                        'scientist' => 'Учёный',
                        'business' => 'Бизнес',
                        'investor' => 'Инвестор',
                        'agency' => 'Агентство',
                    ] as $value => $label)
                        <option value="{{ $value }}" @selected(old('role', 'scientist') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-400 text-xs" />
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500 mb-2">Тип проверки</label>
                <select name="verification_type" class="block w-full rounded-xl border-slate-800 bg-slate-950/70 h-12 px-4 text-slate-100 focus:border-emerald-400 focus:ring-emerald-400">
                    <option value="admin_assigned" @selected(old('verification_type') === 'admin_assigned')>Привязка админом</option>
                    <option value="individual" @selected(old('verification_type') === 'individual')>Физическое лицо</option>
                    <option value="jm" @selected(old('verification_type') === 'jm')>ҶМ</option>
                    <option value="jdmm" @selected(old('verification_type') === 'jdmm')>ҶДММ</option>
                </select>
                <x-input-error :messages="$errors->get('verification_type')" class="mt-2 text-red-400 text-xs" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500 mb-2">Организация</label>
                <input class="block w-full rounded-xl border-slate-800 bg-slate-950/70 h-12 px-4 text-slate-100 focus:border-emerald-400 focus:ring-emerald-400" type="text" name="organization_name" value="{{ old('organization_name') }}" placeholder="для бизнеса или агентства">
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500 mb-2">Должность</label>
                <input class="block w-full rounded-xl border-slate-800 bg-slate-950/70 h-12 px-4 text-slate-100 focus:border-emerald-400 focus:ring-emerald-400" type="text" name="position" value="{{ old('position') }}">
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500 mb-2">Пароль</label>
            <input id="password" class="block w-full rounded-xl border-slate-800 bg-slate-950/70 h-12 px-4 text-slate-100 focus:border-emerald-400 focus:ring-emerald-400" type="password" name="password" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div>
            <label class="block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500 mb-2">Повторите пароль</label>
            <input id="password_confirmation" class="block w-full rounded-xl border-slate-800 bg-slate-950/70 h-12 px-4 text-slate-100 focus:border-emerald-400 focus:ring-emerald-400" type="password" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="flex items-center justify-between gap-4 pt-3">
            <a class="text-sm text-slate-500 hover:text-slate-100 transition" href="{{ route('login') }}">
                Уже есть аккаунт?
            </a>

            <button class="px-5 py-3 rounded-xl bg-emerald-400 text-slate-950 text-sm font-black uppercase tracking-[0.14em] hover:bg-emerald-300 transition">
                Зарегистрироваться
            </button>
        </div>
    </form>
</x-guest-layout>
