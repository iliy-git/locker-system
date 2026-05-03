<div class="min-h-screen bg-[#0b0f19] text-slate-300 p-4 md:p-6 font-sans antialiased">

    <!-- HEADER WITH CONTROLS -->
    <div class="max-w-6xl mx-auto mb-6">
        <div
            class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-gradient-to-r from-[#1e293b] to-[#1a2332] border border-slate-700/50 rounded-2xl px-5 py-4 shadow-2xl shadow-black/40 backdrop-blur-sm">

            <!-- Date Navigation -->
            <div class="flex items-center space-x-2">
                <button wire:click="prevDay" wire:loading.attr="disabled"
                        class="group p-2.5 bg-slate-800/60 hover:bg-indigo-600/20 rounded-xl transition-all duration-200 text-slate-400 hover:text-indigo-300 hover:scale-105 active:scale-95 disabled:opacity-50">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <div class="relative px-4 py-2 bg-slate-900/60 rounded-xl border border-slate-700/50">
                    <h2 class="text-lg font-bold text-white tracking-tight">
                        {{ \Carbon\Carbon::parse($viewDate)->translatedFormat('d F Y') }}
                    </h2>
                    <span
                        class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></span>
                </div>

                <button wire:click="nextDay" wire:loading.attr="disabled"
                        class="group p-2.5 bg-slate-800/60 hover:bg-indigo-600/20 rounded-xl transition-all duration-200 text-slate-400 hover:text-indigo-300 hover:scale-105 active:scale-95 disabled:opacity-50">
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

            <!-- Today Button + Legend -->
            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-2 text-xs text-slate-400">
                    <span class="flex items-center gap-1"><span
                            class="w-2.5 h-2.5 rounded-full bg-blue-500 shadow-lg shadow-blue-500/30"></span>Активно</span>
                    <span class="flex items-center gap-1"><span
                            class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-lg shadow-green-500/30"></span>Завершено</span>
                    <span class="flex items-center gap-1"><span
                            class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-lg shadow-red-500/30"></span>Отменено</span>
                </div>
                <button wire:click="setToday"
                        class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                    Сегодня
                </button>
            </div>
        </div>
    </div>

    <!-- MAIN CARD -->
    <div class="max-w-full mx-auto bg-[#111827] border border-slate-800/60 rounded-2xl shadow-2xl overflow-hidden">

        <!-- TIME HEADER -->
        <div
            class="flex bg-gradient-to-r from-slate-900/80 to-slate-800/50 border-b border-slate-700/50 sticky top-0 z-30">
            <div
                class="w-24 flex-none px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-r border-slate-700/50 bg-slate-900/30">
                Ячейка
            </div>
            <div class="flex-1 relative h-12">
                <div class="absolute inset-0 grid grid-cols-24">
                    @foreach(range(0, 23) as $h)
                        <div class="relative border-l border-slate-700/30 first:border-l-0 group/hour">
                            <span
                                class="absolute left-1.5 top-1/2 -translate-y-1/2 text-[10px] font-semibold text-slate-500 group-hover/hour:text-indigo-400 transition-colors select-none">
                                {{ sprintf('%02d', $h) }}
                            </span>
                            <!-- Hour hover highlight -->
                            <div
                                class="absolute inset-0 bg-indigo-500/5 opacity-0 group-hover/hour:opacity-100 transition-opacity pointer-events-none"></div>
                        </div>
                    @endforeach
                </div>
                <!-- Current time indicator -->
                @php
                    $now = \Carbon\Carbon::now('Europe/Moscow');
                    $isToday = $now->isSameDay(\Carbon\Carbon::parse($viewDate, 'Europe/Moscow'));
                    $currentTimePercent = $isToday ? ($now->hour * 3600 + $now->minute * 60 + $now->second) / 86400 * 100 : null;
                @endphp
                @if($isToday && $currentTimePercent >= 0 && $currentTimePercent <= 100)
                    <div
                        class="absolute top-0 bottom-0 w-0.5 bg-gradient-to-b from-red-500 to-red-600 shadow-[0_0_8px_rgba(239,68,68,0.6)] z-20"
                        style="left: {{ $currentTimePercent }}%">
                        <div
                            class="absolute -top-1.5 -translate-x-1/2 w-3 h-3 bg-red-500 rounded-full border-2 border-[#1e293b] shadow-lg animate-pulse"></div>
                    </div>
                @endif
            </div>
        </div>

        <!-- ROWS -->
        <div class="divide-y divide-slate-700/30 max-h-[calc(100vh-280px)] overflow-y-auto custom-scrollbar">
            @php
                $dayStart = \Carbon\Carbon::parse($viewDate, 'Europe/Moscow')->startOfDay();
                $dayEnd   = $dayStart->copy()->endOfDay();
            @endphp

            @forelse($cells as $cell)
                <div class="flex group/row hover:bg-slate-800/30 transition-all duration-200">

                    <!-- CELL NAME -->
                    <div
                        class="w-24 flex-none px-4 py-4 flex items-center justify-center border-r border-slate-700/50 bg-gradient-to-b from-slate-900/50 to-transparent">
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600/20 to-purple-600/20 border border-indigo-500/30 text-white font-bold text-sm shadow-inner">
                            {{ $cell->cell_number ?? '#'.$cell->id }}
                        </span>
                    </div>

                    <!-- TIMELINE -->
                    <div class="flex-1 relative h-16 flex items-center py-3">
                        <!-- GRID LINES -->
                        <div class="absolute inset-0 grid grid-cols-24 pointer-events-none">
                            @foreach(range(0,23) as $h)
                                <div
                                    class="border-l border-slate-700/20 first:border-l-0 {{ $h % 6 === 0 ? 'border-slate-600/40' : '' }}"></div>
                            @endforeach
                        </div>

                        <!-- TRACK -->
                        <div
                            class="relative w-full h-10 bg-slate-900/40 rounded-xl overflow-hidden px-1.5 border border-slate-700/30 shadow-inner">
                            @foreach($cell->bookings as $booking)
                                @php
                                    $start = \Carbon\Carbon::parse($booking->started_at)->setTimezone('Europe/Moscow');
                                    $end   = \Carbon\Carbon::parse($booking->expires_at)->setTimezone('Europe/Moscow');

                                    if ($start->gt($dayEnd) || $end->lt($dayStart)) continue;

                                    $drawStart = $start->lt($dayStart) ? $dayStart : $start;
                                    $drawEnd   = $end->gt($dayEnd) ? $dayEnd : $end;

                                    $total = 86400;
                                    $left  = max(0, ($dayStart->diffInSeconds($drawStart) / $total) * 100);
                                    $width = max(0.6, ($drawStart->diffInSeconds($drawEnd) / $total) * 100);

                                    $statusStyles = match($booking->status) {
                                        'active'    => ['bg' => 'from-blue-500/90 to-blue-600/90', 'border' => 'border-blue-400/50', 'glow' => 'shadow-blue-500/30', 'text' => 'text-blue-50'],
                                        'completed' => ['bg' => 'from-emerald-500/90 to-green-600/90', 'border' => 'border-emerald-400/50', 'glow' => 'shadow-emerald-500/30', 'text' => 'text-emerald-50'],
                                        'cancelled' => ['bg' => 'from-rose-500/90 to-red-600/90', 'border' => 'border-rose-400/50', 'glow' => 'shadow-rose-500/30', 'text' => 'text-rose-50'],
                                        default     => ['bg' => 'from-slate-500/80 to-slate-600/80', 'border' => 'border-slate-400/40', 'glow' => 'shadow-slate-500/20', 'text' => 'text-slate-100'],
                                    };

                                    $rounded = match(true) {
                                        $start->lt($dayStart) && $end->gt($dayEnd) => 'rounded-none',
                                        $start->lt($dayStart) => 'rounded-r-xl',
                                        $end->gt($dayEnd) => 'rounded-l-xl',
                                        default => 'rounded-xl',
                                    };

                                    $isLong = $width > 5;
                                    $isVeryLong = $width > 12;
                                @endphp

                                <div
                                    class="absolute top-1 h-8 {{ $rounded }} bg-gradient-to-r {{ $statusStyles['bg'] }} border {{ $statusStyles['border'] }} shadow-lg {{ $statusStyles['glow'] }} hover:brightness-110 hover:scale-[1.02] hover:z-10 hover:shadow-xl transition-all duration-200 cursor-pointer flex items-center overflow-hidden group/bar"
                                    style="left: {{ $left }}%; width: {{ $width }}%; min-width: 3px;"
                                    title="{{ $booking->title ?? 'Бронирование' }}"
                                >
                                    <!-- Status dot for short bookings -->
                                    @if(!$isLong)
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-1.5 h-1.5 rounded-full bg-white/90 shadow-sm"></div>
                                        </div>
                                    @endif

                                    <!-- Time label -->
                                    @if($isLong)
                                        <span
                                            class="text-[10px] font-bold {{ $statusStyles['text'] }} whitespace-nowrap px-2 pointer-events-none select-none drop-shadow-sm">
                                            {{ $start->format('H:i') }}
                                            @if($isVeryLong)
                                                <span class="opacity-70">–</span> {{ $end->format('H:i') }}
                                            @endif
                                        </span>
                                    @endif

                                    <!-- Subtle pattern overlay -->
                                    <div
                                        class="absolute inset-0 bg-[linear-gradient(90deg,transparent_0%,rgba(255,255,255,0.08)_50%,transparent_100%)] bg-[length:20px_100%] pointer-events-none"></div>

                                    <!-- TOOLTIP: Time + User (появляется СНизу бара) -->
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 mt-2
            opacity-0 group-hover/bar:opacity-100
            transition-opacity duration-150 ease-out
            z-50 pointer-events-none whitespace-nowrap">

                                        <div class="bg-slate-900/95 text-white text-xs px-3 py-2
                rounded-lg shadow-xl border border-slate-700/80
                flex items-center gap-3 backdrop-blur-sm">

                                            <!-- Время -->
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="font-mono font-semibold tabular-nums">
                {{ $start->format('H:i') }}–{{ $end->format('H:i') }}
            </span>
                                            </div>

                                            <!-- Разделитель -->
                                            <span class="text-slate-600">|</span>

                                            <!-- Пользователь -->
                                            <div class="flex items-center gap-1.5 min-w-0">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                <span class="font-medium truncate max-w-[180px]" title="{{ $booking->user->name ?? 'Не указан' }}">
                {{ $booking->user->name ?? 'Гость' }}
            </span>
                                            </div>
                                        </div>

                                        <!-- Стрелочка ВВЕРХ (теперь тултип снизу) -->
                                        <div class="absolute -top-2 left-1/2 -translate-x-1/2">
                                            <div class="border-4 border-transparent border-b-slate-900/95"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center text-slate-500">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-lg font-medium">Нет записей на эту дату</p>
                    <p class="text-sm mt-1">Добавьте новое бронирование, чтобы увидеть его здесь</p>
                </div>
            @endforelse
        </div>
    </div>


    <!-- Custom Scrollbar Styles -->
    <style>
        .grid-cols-24 {
            display: grid;
            grid-template-columns: repeat(24, minmax(0, 1fr));
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 4px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
            background-clip: content-box;
        }

        /* Smooth hover for booking bars */
        .group\/bar {
            transform-origin: center;
        }

        /* Subtle entrance animation for new bookings */
        @keyframes fadeInSlide {
            from {
                opacity: 0;
                transform: translateY(4px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .group\/bar {
            animation: fadeInSlide 0.2s ease-out forwards;
        }
    </style>
</div>
