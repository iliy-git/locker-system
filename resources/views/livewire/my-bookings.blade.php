<div class="space-y-4" wire:poll.30s x-init="$nextTick(() => typeof lucide !== 'undefined' && lucide.createIcons())">

    <!-- 📊 Мини-статистика -->
    @if($stats['active_count'] > 0 || $stats['pending_count'] > 0)
        <div class="flex gap-3 mb-2">
            @if($stats['active_count'] > 0)
                <span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold rounded-full">
                    ● {{ $stats['active_count'] }} активн.
                </span>
            @endif
            @if($stats['pending_count'] > 0)
                <span class="px-3 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-bold rounded-full">
                    ◐ {{ $stats['pending_count'] }} ожидает
                </span>
            @endif
            @if($stats['total_spent'] > 0)
                <span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 text-xs font-bold rounded-full ml-auto">
                    💰 {{ number_format($stats['total_spent'], 0, '.', ' ') }} ₽
                </span>
            @endif
        </div>
    @endif

    @forelse($bookings as $booking)
        @php
            $now = now('Europe/Moscow');
            $start = $booking->started_at->timezone('Europe/Moscow');
            $end = $booking->expires_at->timezone('Europe/Moscow');

            $isCancelled = $booking->status === 'cancelled';
            // Завершённая: явный статус completed ИЛИ активная, но время вышло
            $isCompleted = $booking->status === 'completed' ||
                           ($booking->status === 'active' && $end->isPast());
            $isWaiting = $start->isFuture() && !$isCancelled && !$isCompleted;
            $isActive = $start->isPast() && $end->isFuture() && !$isCancelled && !$isCompleted;

            $displayPrice = $booking->total_price > 0 ? $booking->total_price : 0;

            $confirmPrice = 0;
            if ($isActive) {
                $usedMinutes = $start->diffInMinutes($now, false);
                $hours = (int) ceil($usedMinutes / 60);
                $confirmPrice = $hours * $booking->cell->cost;
            }
        @endphp

        <div class="relative overflow-hidden bg-[#1e293b]/50 border border-slate-800 rounded-[2rem] p-6 flex justify-between items-center shadow-2xl transition-all hover:border-slate-700"
             x-init="$nextTick(() => typeof lucide !== 'undefined' && lucide.createIcons())">

            <!-- Цветная полоска слева -->
            <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b
                {{ $isWaiting ? 'from-amber-500 to-orange-600' : '' }}
                {{ $isActive ? 'from-emerald-500 to-green-600' : '' }}
                {{ $isCompleted ? 'from-slate-500 to-slate-600' : '' }}
                {{ $isCancelled ? 'from-rose-500 to-red-600' : '' }}">
            </div>

            <div class="flex items-center gap-6 relative z-10">
                <!-- Номер ячейки -->
                <div class="flex flex-col items-center justify-center bg-slate-900/80 border border-slate-800 w-16 h-16 rounded-[1.25rem]">
                    <span class="text-[10px] text-slate-500 font-black uppercase">Box</span>
                    <span class="text-2xl font-black text-white">{{ $booking->cell->cell_number }}</span>
                </div>

                <div>
                    <!-- Статус -->
                    <div class="flex items-center gap-2 mb-1">
                        @if($isWaiting)
                            <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            <span class="text-amber-400 font-black text-[10px] uppercase tracking-wider">В ожидании</span>
                        @elseif($isActive)
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-emerald-400 font-black text-[10px] uppercase tracking-wider">Активна</span>
                        @elseif($isCompleted)
                            <div class="w-2 h-2 rounded-full bg-slate-500"></div>
                            <span class="text-slate-400 font-black text-[10px] uppercase tracking-wider">Завершена</span>
                        @elseif($isCancelled)
                            <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                            <span class="text-rose-400 font-black text-[10px] uppercase tracking-wider">Отменена</span>
                        @endif
                    </div>

                    <!-- Время и цена -->
                    <div class="flex items-center gap-4 text-sm">
                        @if($isWaiting)
                            <span class="text-slate-400">
                                Старт: <span class="text-white font-medium">{{ $start->format('H:i') }}</span>
                            </span>
                            <span class="text-amber-400 font-mono text-xs">
                                через {{ $now->diffForHumans($start, true) }}
                            </span>
                        @elseif($isActive)
                            <span class="text-slate-400">
                                До: <span class="text-white font-medium">{{ $end->format('H:i') }}</span>
                            </span>
                            <span class="text-indigo-400 font-mono text-xs">
                                {{ $now->diffForHumans($end, true) }} осталось
                            </span>
                        @else
                            <span class="text-slate-400">
                                {{ $start->format('H:i') }} — {{ $end->format('H:i') }}
                            </span>
                        @endif

                            @if($displayPrice > 0)
                                <span class="text-emerald-400 font-bold text-sm">
                                    {{ number_format($displayPrice, 0, '.', ' ') }} ₽
                                </span>
                            @endif
                    </div>
                </div>
            </div>

            <!-- Кнопки действий -->
            <div class="flex items-center gap-3">
                @if($isWaiting && !$isCancelled)
                    <button wire:click="cancel({{ $booking->id }})"
                            wire:confirm="Отменить бронь?"
                            class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider bg-slate-700 hover:bg-slate-600 text-white rounded-xl transition-all">
                        Отменить
                    </button>
                @endif

                    @if($isActive)
                        <button wire:click="release({{ $booking->id }})"
                                wire:confirm="Завершить аренду? Стоимость: {{ $confirmPrice }} ₽"
                                class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider bg-rose-500 hover:bg-rose-600 text-white rounded-xl transition-all shadow-lg shadow-rose-500/20">
                            Завершить
                        </button>
                    @endif

                @if($isCompleted)
                    <span class="px-4 py-2 text-xs font-bold text-slate-500 uppercase bg-slate-800/50 rounded-xl flex items-center gap-2">
                        <i data-lucide="check" class="w-3 h-3"></i> Завершено
                    </span>
                @endif

                @if($isCancelled)
                    <span class="px-4 py-2 text-xs font-bold text-rose-400 uppercase bg-rose-500/10 border border-rose-500/30 rounded-xl flex items-center gap-2">
                        <i data-lucide="x" class="w-3 h-3"></i> Отменено
                    </span>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-20 bg-[#1e293b]/30 border-2 border-dashed border-slate-800 rounded-[3rem]"
             x-init="$nextTick(() => typeof lucide !== 'undefined' && lucide.createIcons())">
            <i data-lucide="key-round" class="w-12 h-12 text-slate-700 mx-auto mb-4"></i>
            <p class="text-slate-500 font-medium">Нет бронирований</p>
        </div>
    @endforelse
</div>

<!-- Toast уведомления -->
@push('scripts')
    <script>
        // Глобальная перерисовка иконок после обновлений Livewire
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', ({ el }) => {
                setTimeout(() => typeof lucide !== 'undefined' && lucide.createIcons(), 50);
            });
        });
    </script>
@endpush
