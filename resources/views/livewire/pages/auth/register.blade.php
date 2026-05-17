<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('main', absolute: false), navigate: true);
    }
}; ?>

<div class="bg-[#1e293b] border border-slate-700/80 rounded-[2.5rem] p-10 shadow-2xl w-full">

    <div class="flex flex-col items-center text-center mb-6">
        <div class="w-12 h-12 bg-indigo-500 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
        <h1 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400 uppercase tracking-wide">SmartBox</h1>
        <p class="text-xs text-indigo-400 uppercase tracking-[0.2em] font-bold mt-1">Создание аккаунта</p>
    </div>

    <form wire:submit="register" class="space-y-4">

        <div>
            <label for="name" class="block text-[11px] uppercase tracking-wider font-bold text-slate-400 mb-1.5">Ваше имя</label>
            <input wire:model="name" id="name" type="text" required autofocus autocomplete="name"
                   class="block w-full px-4 py-3 bg-[#0f172a]/60 border border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl font-mono text-sm text-black placeholder-slate-500 transition-all outline-none"
                   placeholder="Александр" />
            @if($errors->has('name'))
                <p class="text-xs text-rose-400 mt-1.5 font-medium flex items-center gap-1">
                    <span>⚠</span> {{ $errors->first('name') }}
                </p>
            @endif
        </div>

        <div>
            <label for="email" class="block text-[11px] uppercase tracking-wider font-bold text-slate-400 mb-1.5">Электронная почта</label>
            <input wire:model="email" id="email" type="email" required autocomplete="username"
                   class="block w-full px-4 py-3 bg-[#0f172a]/60 border border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl font-mono text-sm text-black placeholder-slate-500 transition-all outline-none"
                   placeholder="example@domain.com" />
            @if($errors->has('email'))
                <p class="text-xs text-rose-400 mt-1.5 font-medium flex items-center gap-1">
                    <span>⚠</span> {{ $errors->first('email') }}
                </p>
            @endif
        </div>

        <div>
            <label for="password" class="block text-[11px] uppercase tracking-wider font-bold text-slate-400 mb-1.5">Пароль</label>
            <input wire:model="password" id="password" type="password" required autocomplete="new-password"
                   class="block w-full px-4 py-3 bg-[#0f172a]/60 border border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl font-mono text-sm text-black placeholder-slate-500 transition-all outline-none"
                   placeholder="••••••••" />
            @if($errors->has('password'))
                <p class="text-xs text-rose-400 mt-1.5 font-medium flex items-center gap-1">
                    <span>⚠</span> {{ $errors->first('password') }}
                </p>
            @endif
        </div>

        <div>
            <label for="password_confirmation" class="block text-[11px] uppercase tracking-wider font-bold text-slate-400 mb-1.5">Подтвердите пароль</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required autocomplete="new-password"
                   class="block w-full px-4 py-3 bg-[#0f172a]/60 border border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl font-mono text-sm text-black placeholder-slate-500 transition-all outline-none"
                   placeholder="••••••••" />
        </div>

        <div class="pt-3">
            <button type="submit"
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-200 hover:scale-[1.01] active:scale-[0.99]">
                Зарегистрироваться
            </button>
        </div>

    </form>

    <div class="mt-6 pt-5 border-t border-slate-700/60 text-center">
        <p class="text-xs text-slate-400">
            Уже есть аккаунт?
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-bold ml-1 transition-colors" wire:navigate>
                Войти в систему
            </a>
        </p>
    </div>

</div>
