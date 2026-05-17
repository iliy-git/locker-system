<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full max-w-md mx-auto bg-[#1e293b] border border-slate-700/80 rounded-[2.5rem] p-10 shadow-2xl block">

    <div class="flex flex-col items-center text-center mb-8">
        <div class="w-12 h-12 bg-indigo-500 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
            </svg>
        </div>
        <h1 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400 uppercase tracking-wide">SmartBox</h1>
        <p class="text-xs text-indigo-400 uppercase tracking-[0.2em] font-bold mt-1 ">Авторизация в системе</p>
    </div>

    @if (session('status'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-medium">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login" class="space-y-5">

        <div>
            <label for="email" class="block text-[11px] uppercase tracking-wider font-bold text-slate-400 mb-2">Электронная почта</label>
            <input wire:model="form.email" id="email"
                   class="block w-full px-4 py-3.5 bg-[#0f172a]/60 border border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl font-mono text-sm text-black placeholder-slate-500 transition-all outline-none"
                   type="email" name="email" placeholder="example@domain.com" required autofocus autocomplete="username" />
            @if($errors->has('form.email'))
                <p class="text-xs text-rose-400 mt-2 font-medium flex items-center gap-1">
                    <span>⚠</span> {{ $errors->first('form.email') }}
                </p>
            @endif
        </div>

        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-[11px] uppercase tracking-wider font-bold text-slate-400">Пароль</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-slate-500 hover:text-indigo-400 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                        Забыли пароль?
                    </a>
                @endif
            </div>
            <input wire:model="form.password" id="password"
                   class="block w-full px-4 py-3.5 bg-[#0f172a]/60 border border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl font-mono text-sm text-black placeholder-slate-500 transition-all outline-none"
                   type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
            @if($errors->has('form.password'))
                <p class="text-xs text-rose-400 mt-2 font-medium flex items-center gap-1">
                    <span>⚠</span> {{ $errors->first('form.password') }}
                </p>
            @endif
        </div>

        <div class="flex items-center justify-between pt-1">
            <label for="remember" class="inline-flex items-center cursor-pointer select-none">
                <input wire:model="form.remember" id="remember" type="checkbox"
                       class="rounded-md border-slate-700 bg-[#0f172a] text-indigo-600 focus:ring-0 focus:ring-offset-0 w-4 h-4 cursor-pointer" name="remember">
                <span class="ms-2.5 text-xs font-medium text-slate-400 hover:text-slate-300 transition-colors">Запомнить меня</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-200">
                Войти в систему
            </button>
        </div>
    </form>

    <div class="mt-8 pt-6 border-t border-slate-700/60 text-center">
        <p class="text-xs text-slate-400">
            Ещё нет аккаунта?
            <a href="/register" class="text-indigo-400 hover:text-indigo-300 font-bold ml-1 transition-colors" wire:navigate>
                Создать профиль
            </a>
        </p>
    </div>

</div>
