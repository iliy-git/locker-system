<div class="flex min-h-screen bg-[#0f172a] text-slate-200">
    <aside class="w-72 bg-[#1e293b] border-r border-slate-700 flex flex-col shadow-2xl">
        <div class="p-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">SmartBox</h1>
                    <span class="text-[10px] text-indigo-400 uppercase tracking-[0.2em] font-bold">Control Panel</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-2 mt-4">
            <button wire:click="setView('reserve')"
                    class="w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ $view === 'reserve' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-slate-400 hover:bg-slate-800' }}">
                <span class="font-medium">Забронировать</span>
            </button>

            <button wire:click="setView('my-cells')"
                    class="w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ $view === 'my-cells' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-slate-400 hover:bg-slate-800' }}">
                <span class="font-medium">Мои ячейки</span>
            </button>

            <button wire:click="setView('history')"
                    class="w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ $view === 'history' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-slate-400 hover:bg-slate-800' }}">
                <span class="font-medium">История</span>
            </button>
        </nav>

        <div class="p-6 border-t border-slate-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors">
                    <span>Выйти</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto p-10 bg-gradient-to-br from-[#0f172a] to-[#1e293b]">
        <div class="max-w-6xl mx-auto">
            @if($view === 'reserve')
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-white">Выбор ячейки</h2>
                        <p class="text-slate-400 mt-1">Выберите подходящий размер и забронируйте бокс</p>
                    </div>
                </div>
                @livewire('locker-display')

            @elseif($view === 'my-cells')
                <h2 class="text-3xl font-bold text-white mb-8">Активные боксы</h2>
                @livewire('my-bookings')

            @elseif($view === 'history')
                <h2 class="text-3xl font-bold text-white mb-8">История операций</h2>
                @livewire('booking-history')
            @endif
        </div>
    </main>
</div>
