<div class="overflow-hidden bg-[#1e293b]/50 border border-slate-800 rounded-2xl shadow-xl backdrop-blur-sm">
    <table class="w-full text-left border-collapse">
        <thead>
        <tr class="bg-slate-900/60 border-b border-slate-800">
            <th class="p-4 text-slate-500 font-bold text-xs uppercase tracking-widest">Ячейка</th>
            <th class="p-4 text-slate-500 font-bold text-xs uppercase tracking-widest">Дата</th>
            <th class="p-4 text-slate-500 font-bold text-xs uppercase tracking-widest">Период</th>
            <th class="p-4 text-slate-500 font-bold text-xs uppercase tracking-widest">Стоимость</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/50">
        @php
            $now = \Carbon\Carbon::now('Europe/Moscow');
        @endphp

        @forelse($history as $item)
            @php
                $endTime = $item->expires_at->timezone('Europe/Moscow');

                // Отображаем только если бронирование УЖЕ завершилось
                if ($endTime->isFuture()) {
                    continue;
                }
            @endphp

            <tr class="hover:bg-slate-800/40 transition-all duration-200 group">
                <td class="p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center">
                            <span class="font-black text-indigo-400 text-sm">{{ $item->cell->cell_number }}</span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">{{ $item->cell->type }}</span>
                    </div>
                </td>
                <td class="p-4 text-slate-300 font-medium">
                    {{ $item->started_at->translatedFormat('d M Y') }}
                </td>
                <td class="p-4">
                    <div class="flex items-center gap-2 text-slate-400 text-sm tabular-nums">
                        <span>{{ $item->started_at->format('H:i') }}</span>
                        <span class="text-slate-600">—</span>
                        <span class="text-slate-200">{{ $endTime->format('H:i') }}</span>
                    </div>
                </td>
                <td class="p-4">
                    <div class="flex flex-col">
                            <span class="text-emerald-400 font-black tracking-tight">
                                {{ number_format($item->calculateTotalCost(), 0, '.', ' ') }} ₽
                            </span>
                        <span class="text-[9px] text-slate-600 uppercase font-bold">Оплачено</span>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <i data-lucide="archive" class="w-10 h-10 text-slate-700"></i>
                        <p class="text-slate-500 font-medium italic">История бронирований пока пуста</p>
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
