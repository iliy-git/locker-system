<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartBox') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Точечная неоновая сетка */
        .grid-bg {
            background-image: radial-gradient(#334155 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="font-sans text-slate-200 antialiased bg-[#0f172a] min-h-screen grid-bg relative overflow-x-hidden">

<div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#0f172a]/90 pointer-events-none"></div>

<div class="relative z-10 min-h-screen flex flex-col justify-between">

    <header class="w-full max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-black bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">SmartBox</h1>
                <p class="text-[10px] text-indigo-400 uppercase tracking-[0.2em] font-bold leading-none mt-1">Control Center</p>
            </div>
        </a>

        @if(!request()->routeIs('login') && !request()->routeIs('register'))
            <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-indigo-400 bg-indigo-500/15 border border-indigo-500/30 hover:border-indigo-500 rounded-xl transition-all">
                Войти
            </a>
        @else
            <a href="/" class="px-5 py-2.5 text-sm font-semibold text-slate-400 bg-slate-800/50 border border-slate-700 hover:border-slate-500 rounded-xl transition-all">
                На главную
            </a>
        @endif
    </header>

    <main class="flex-1 max-w-6xl w-full mx-auto px-6 pt-6 pb-16 flex flex-col justify-center">

        @if(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.request'))

            <div class="w-full flex flex-col items-center justify-center">
                <div class="w-full sm:max-w-md  bg-[#1e293b] border border-slate-800 rounded-[2.5rem] shadow-2xl relative z-10">
                    {{ $slot }}
                </div>
            </div>

        @else

            <section class="text-center py-12 md:py-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-500/10 border border-indigo-500/20 rounded-full text-indigo-400 text-xs font-semibold mb-6">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                    Умное хранение нового поколения
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
                    Ваши вещи под надёжной защитой<br>
                </h1>
                <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
                    Арендуйте персональную ячейку хранения за 30 секунд.
                    Без очередей, без ключей — только быстрый доступ 24/7
                </p>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 p-6 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-xl shadow-indigo-600/25 transition-all hover:scale-[1.02]">
                    Забронировать ячейку
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </section>

            <section class="mb-20">
                <h2 class="text-2xl md:text-3xl font-bold text-white text-center mb-10">Выберите подходящий формат</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group bg-[#1e293b]/60 backdrop-blur-sm border border-slate-800 rounded-3xl p-8 hover:border-indigo-500/40 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/5">
                        <div class="w-14 h-14 bg-slate-800 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-500/20 transition-colors">
                            <svg class="w-7 h-7 text-slate-400 group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Компактная</h3>
                        <p class="text-slate-400 text-sm mb-6 leading-relaxed">Идеальна для документов, гаджетов и ценных мелочей. Оптимальный выбор для краткосрочного хранения.</p>
                        <a href="{{ route('login') }}" class="w-full block text-center py-3 text-sm font-semibold text-slate-300 bg-slate-800 hover:bg-indigo-600 hover:text-white border border-slate-700 hover:border-indigo-500 rounded-xl transition-all">
                            Выбрать
                        </a>
                    </div>

                    <div class="group relative bg-[#1e293b] border-2 border-indigo-500/50 rounded-3xl p-8 shadow-xl shadow-indigo-500/10">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 bg-gradient-to-r from-indigo-600 to-cyan-600 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-lg">
                            Популярный выбор
                        </div>
                        <div class="w-14 h-14 bg-indigo-500/20 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Универсальная</h3>
                        <p class="text-slate-400 text-sm mb-6 leading-relaxed">Для рюкзаков, одежды и спортинвентаря. Самый востребованный формат для повседневных задач.</p>
                        <a href="{{ route('login') }}" class="w-full block text-center py-3 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-cyan-600 hover:from-indigo-500 hover:to-cyan-500 rounded-xl transition-all shadow-lg shadow-indigo-600/25">
                            Забронировать
                        </a>
                    </div>

                    <div class="group bg-[#1e293b]/60 backdrop-blur-sm border border-slate-800 rounded-3xl p-8 hover:border-indigo-500/40 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/5">
                        <div class="w-14 h-14 bg-slate-800 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-500/20 transition-colors">
                            <svg class="w-7 h-7 text-slate-400 group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Просторная</h3>
                        <p class="text-slate-400 text-sm mb-6 leading-relaxed">Для чемоданов, оборудования и крупных вещей. Максимальный комфорт для долгосрочного хранения.</p>
                        <a href="{{ route('login') }}" class="w-full block text-center py-3 text-sm font-semibold text-slate-300 bg-slate-800 hover:bg-indigo-600 hover:text-white border border-slate-700 hover:border-indigo-500 rounded-xl transition-all">
                            Выбрать
                        </a>
                    </div>
                </div>
            </section>

            <section class="mb-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Безопасность</h3>
                        <p class="text-slate-400 text-sm">Видеонаблюдение и страховка каждой ячейки</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-cyan-500/10 border border-cyan-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Доступ 24/7</h3>
                        <p class="text-slate-400 text-sm">Забирайте вещи в любое время дня и ночи</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-violet-500/10 border border-violet-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Мгновенно</h3>
                        <p class="text-slate-400 text-sm">Бронирование за 30 секунд без очередей</p>
                    </div>
                </div>
            </section>

            <section class="text-center py-12 bg-gradient-to-r from-indigo-600/10 to-cyan-600/10 border border-indigo-500/20 rounded-3xl">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Готовы начать?</h2>
                <p class="text-slate-400 mb-8 max-w-xl mx-auto">Присоединяйтесь к тысячам довольных клиентов. Выберите ячейку и получите доступ прямо сейчас.</p>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 px-10 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-xl shadow-indigo-600/30 transition-all hover:scale-[1.02]">
                    Забронировать сейчас
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </section>

        @endif

    </main>

    <footer class="w-full text-center py-6 text-xs text-slate-500 border-t border-slate-900/40 bg-[#0f172a]/20">
        &copy; {{ date('Y') }} SmartBox. Все права защищены.
    </footer>
</div>

</body>
</html>
