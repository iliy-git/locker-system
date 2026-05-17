<div class="flex min-h-screen bg-[#0f172a] text-slate-200">
    <aside class="w-72 bg-[#1e293b] border-r border-slate-800 flex flex-col shadow-2xl transition-all duration-300">
        <div class="p-8">
            <div class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-black bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">SmartBox</h1>
                    <p class="text-[10px] text-indigo-400 uppercase tracking-[0.2em] font-bold leading-none mt-1">Control Center</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-2 mt-4">
            <button wire:click="setView('main')"
                    class="group w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ $view === 'main' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="font-medium">Главная</span>
            </button>

            <button wire:click="setView('reserve')"
                    class="group w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ $view === 'reserve' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="font-medium">Забронировать</span>
            </button>

            <button wire:click="setView('my-cells')"
                    class="group w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ $view === 'my-cells' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span class="font-medium">Мои ячейки</span>
            </button>

            <button wire:click="setView('history')"
                    class="group w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ $view === 'history' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">История</span>
            </button>

            <button wire:click="setView('statistic')"
                    class="group w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ $view === 'statistic' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">Статистика</span>
            </button>
        </nav>

        <div class="p-6 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm text-rose-400 hover:bg-rose-500/10 rounded-xl transition-all duration-200 group border border-transparent hover:border-rose-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Выйти из системы</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-gradient-to-br from-[#0f172a] to-[#1e293b]">
        <div class="max-w-6xl mx-auto px-10 py-12">

            <header class="mb-10">
                @if($view === 'main')

                    <section class="text-center py-8 md:py-24">
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
                        <button wire:click="setView('reserve')"
                                class="inline-flex items-center gap-2 p-8 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-xl shadow-indigo-600/25 transition-all hover:scale-[1.02]">
                            Забронировать ячейку
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </button>
                    </section>
                @elseif($view === 'reserve')
                    <h2 class="text-4xl font-extrabold text-white tracking-tight">Забронировать ячейку</h2>
                    <p class="text-slate-400 mt-2 text-lg">Доступные боксы для хранения ваших вещей в реальном времени.</p>
                @elseif($view === 'my-cells')
                    <h2 class="text-4xl font-extrabold text-white tracking-tight">Мои активные ячейки</h2>
                    <p class="text-slate-400 mt-2 text-lg">Управление вашими текущими бронированиями и доступ к ПИН-кодам.</p>
                @elseif($view === 'history')
                    <h2 class="text-4xl font-extrabold text-white tracking-tight">История операций</h2>
                    <p class="text-slate-400 mt-2 text-lg">Полный список ваших прошлых посещений и оплат.</p>
                @endif
            </header>

            <div class="relative min-h-[400px]">
                @if($view === 'main')
                    <!-- 🔹 Карточки тарифов -->

                    <!-- 🔹 Тарифы -->
                    <section class="mb-6">
                        <h2 class="text-2xl md:text-3xl font-bold text-white text-center mb-10">Выберите подходящий формат</h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                            <!-- S -->
                            <div class="group bg-[#1e293b] border border-slate-800 rounded-3xl p-8 hover:border-indigo-500/40 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/5">
                                <div class="w-14 h-14 bg-slate-800 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-7 h-7 text-slate-400 group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3">Компактная</h3>
                                <p class="text-slate-400 text-sm mb-6 leading-relaxed">Идеальна для документов, гаджетов и ценных мелочей. Оптимальный выбор для краткосрочного хранения.</p>
                                <ul class="space-y-2 mb-8">
                                    <li class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Мгновенный доступ
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Почасовая оплата
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Страховка включена
                                    </li>
                                </ul>
                                <button wire:click="setView('reserve')" class="w-full py-3 text-sm font-semibold text-slate-300 bg-slate-800 hover:bg-indigo-600 hover:text-white border border-slate-700 hover:border-indigo-500 rounded-xl transition-all">
                                    Выбрать
                                </button>
                            </div>

                            <!-- M (выделена) -->
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
                                <ul class="space-y-2 mb-8">
                                    <li class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Всё из тарифа «Компактная»
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Увеличенный объём
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Приоритетная поддержка
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-indigo-300 font-medium">
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        Выгодная цена
                                    </li>
                                </ul>
                                <button wire:click="setView('reserve')" class="w-full py-3 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-cyan-600 hover:from-indigo-500 hover:to-cyan-500 rounded-xl transition-all shadow-lg shadow-indigo-600/25">
                                    Забронировать
                                </button>
                            </div>

                            <!-- L -->
                            <div class="group bg-[#1e293b] border border-slate-800 rounded-3xl p-8 hover:border-indigo-500/40 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/5">
                                <div class="w-14 h-14 bg-slate-800 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-7 h-7 text-slate-400 group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3">Просторная</h3>
                                <p class="text-slate-400 text-sm mb-6 leading-relaxed">Для чемоданов, оборудования и крупных вещей. Максимальный комфорт для долгосрочного хранения.</p>
                                <ul class="space-y-2 mb-8">
                                    <li class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Всё из тарифа «Универсальная»
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Максимальный объём
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        VIP-поддержка 24/7
                                    </li>
                                </ul>
                                <button wire:click="setView('reserve')" class="w-full py-3 text-sm font-semibold text-slate-300 bg-slate-800 hover:bg-indigo-600 hover:text-white border border-slate-700 hover:border-indigo-500 rounded-xl transition-all">
                                    Выбрать
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- 🔹 Преимущества -->
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

                    <!-- 🔹 CTA -->
                    <section class="text-center py-12 bg-gradient-to-r from-indigo-600/10 to-cyan-600/10 border border-indigo-500/20 rounded-3xl">
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Готовы начать?</h2>
                        <p class="text-slate-400 mb-8 max-w-xl mx-auto">Присоединяйтесь к тысячам довольных клиентов. Выберите ячейку и получите доступ прямо сейчас.</p>
                        <button wire:click="setView('reserve')"
                                class="inline-flex items-center gap-2 px-10 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-xl shadow-indigo-600/30 transition-all hover:scale-[1.02]">
                            Забронировать сейчас
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </button>
                    </section>

                @elseif($view === 'reserve')
                    @livewire('locker-display')
                @elseif($view === 'my-cells')
                    @livewire('my-bookings')
                @elseif($view === 'history')
                    @livewire('booking-history')
                @elseif($view === 'statistic')
                    @livewire('admin-cell-monitor')
                @endif
            </div>

        </div>
    </main>
</div>
