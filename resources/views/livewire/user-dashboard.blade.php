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
                @if($view === 'reserve')
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
                @if($view === 'reserve')
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
