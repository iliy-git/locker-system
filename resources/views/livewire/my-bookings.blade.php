<div class="space-y-4" wire:poll.60s>
    @forelse($bookings as $booking)
        @php
            $now = \Carbon\Carbon::now('Europe/Moscow');
            $startTime = $booking->started_at->timezone('Europe/Moscow');
            $endTime = $booking->expires_at->timezone('Europe/Moscow'); // Предполагаем, что поле называется expires_at

            // Если текущее время больше времени окончания — пропускаем это бронирование
            if ($now->greaterThan($endTime)) {
                continue;
            }

            $isWaiting = $startTime->isFuture();
        @endphp

        <div class="relative overflow-hidden bg-[#1e293b]/50 border border-slate-800 rounded-[2rem] p-6 flex justify-between items-center shadow-2xl transition-all hover:border-slate-700">
            <!-- Градиентная полоска слева -->
            <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b {{ $isWaiting ? 'from-amber-500 to-orange-600' : 'from-indigo-500 to-purple-600' }}"></div>

            <div class="flex items-center gap-8 relative z-10">
                <!-- Номер ячейки -->
                <div class="flex flex-col items-center justify-center bg-slate-900/80 border border-slate-800 w-20 h-20 rounded-[1.5rem] shadow-inner">
                    <span class="text-xs text-slate-500 font-black uppercase tracking-tighter">Box</span>
                    <span class="text-3xl font-black text-white leading-none">{{ $booking->cell->cell_number }}</span>
                </div>

                <div>
                    <!-- Статус -->
                    <div class="flex items-center gap-2 mb-2">
                        @if($isWaiting)
                            <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            <h3 class="text-amber-500 font-black text-sm uppercase tracking-widest">В ожидании</h3>
                        @else
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <h3 class="text-white font-black text-sm uppercase tracking-tight">Активна</h3>
                        @endif
                    </div>

                    <!-- Детали времени -->
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i data-lucide="calendar" class="w-4 h-4 text-slate-500"></i>
                            <p class="text-sm">
                                {{ $isWaiting ? 'Заезд:' : 'Занята до:' }}
                                <span class="text-slate-200 font-medium">
                                    {{-- Если активна, лучше показывать время окончания --}}
                                    {{ $isWaiting ? $startTime->translatedFormat('d F, H:i') : $endTime->translatedFormat('d F, H:i') }}
                                </span>
                            </p>
                        </div>

                        <div class="flex items-center gap-2 text-slate-400">
                            @if($isWaiting)
                                <i data-lucide="timer" class="w-4 h-4 text-amber-500/50"></i>
                                <p class="text-sm italic text-slate-500">
                                    Начнется через {{ $now->diffForHumans($startTime, true) }}
                                </p>
                            @else
                                <i data-lucide="clock" class="w-4 h-4 text-indigo-400"></i>
                                <p class="text-sm">
                                    Осталось:
                                    <span class="text-indigo-400 font-bold">
                                        {{ $now->diffForHumans($endTime, true) }}
                                    </span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правая часть: Пин-код и Кнопка -->
            <div class="flex items-center gap-8">
                <div class="bg-slate-900/50 px-6 py-3 rounded-2xl border border-slate-800/50 text-center">
                    <p class="text-[10px] text-slate-500 uppercase font-black tracking-[0.2em] mb-1">Pincode</p>
                    <p class="text-2xl font-mono font-black text-white tracking-[0.3em] drop-shadow-[0_0_8px_rgba(255,255,255,0.3)]">
                        {{ $booking->pincode }}
                    </p>
                </div>

                <button
                    wire:click="release({{ $booking->id }})"
                    wire:confirm="Вы уверены? Дверь будет заблокирована, а аренда завершена."
                    class="group relative overflow-hidden h-16 px-8 bg-rose-500 hover:bg-rose-600 text-white rounded-[1.5rem] transition-all shadow-xl shadow-rose-500/20 active:scale-95"
                >
                    <span class="relative z-10 font-black uppercase tracking-widest text-sm">
                        {{ $isWaiting ? 'Отменить' : 'Завершить' }}
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </button>
            </div>
        </div>
    @empty
        <div class="text-center py-20 bg-[#1e293b]/30 border-2 border-dashed border-slate-800 rounded-[3rem]">
            <i data-lucide="key-round" class="w-12 h-12 text-slate-700 mx-auto mb-4"></i>
            <p class="text-slate-500 font-medium">У вас пока нет активных бронирований</p>
        </div>
    @endforelse
</div>
