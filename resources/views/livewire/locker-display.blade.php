<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Стили для тёмной темы Flatpickr + белый текст -->
    <style>
        .flatpickr-calendar {
            background: #1e293b !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        }
        .flatpickr-day { color: #e2e8f0 !important; }
        .flatpickr-day:hover, .flatpickr-day.prevMonthDay:hover, .flatpickr-day.nextMonthDay:hover {
            background: #334155 !important; border-color: #334155 !important;
        }
        .flatpickr-day.today { border-color: #6366f1 !important; color: #fff !important; }
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
            background: #6366f1 !important; color: #fff !important; border-color: #6366f1 !important;
        }
        .flatpickr-months .flatpickr-prev-month svg, .flatpickr-months .flatpickr-next-month svg {
            fill: #94a3b8 !important;
        }
        .flatpickr-months .flatpickr-prev-month:hover svg, .flatpickr-months .flatpickr-next-month:hover svg {
            fill: #fff !important;
        }
        .flatpickr-month { color: #fff !important; }
        .flatpickr-current-month .numInputWrapper span.arrowUp:after { border-bottom-color: #fff !important; }
        .flatpickr-current-month .numInputWrapper span.arrowDown:after { border-top-color: #fff !important; }
        .flatpickr-time input, .flatpickr-time .flatpickr-time-separator {
            background: #0f172a !important; color: #fff !important;
        }
        .flatpickr-time .numInputWrapper span.arrowUp:after { border-bottom-color: #fff !important; }
        .flatpickr-time .numInputWrapper span.arrowDown:after { border-top-color: #fff !important; }
    </style>

    <!-- Индикатор шагов -->
    <div class="flex items-center justify-center mb-12 gap-4">
        @foreach(['ВРЕМЯ', 'РАЗМЕР', 'ФИНАЛ'] as $index => $label)
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold transition-all
                    {{ $step >= ($index + 1) ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-500' }}">
                    {{ $index + 1 }}
                </div>
                <span class="text-[10px] tracking-widest font-black {{ $step == ($index + 1) ? 'text-white' : 'text-slate-500' }}">
                    {{ $label }}
                </span>
            </div>
            @if($index < 2) <div class="w-12 h-px bg-slate-800"></div> @endif
        @endforeach
    </div>

    @if(session('error'))
        <div class="max-w-lg mx-auto mb-6 p-4 bg-rose-500/10 border border-rose-500/30 rounded-2xl text-rose-400 text-sm font-bold text-center">
            {{ session('error') }}
        </div>
    @endif

    <!-- STEP 1: ВРЕМЯ -->
    @if($step == 1)
        <div class="bg-[#1e293b] border border-slate-800 p-10 rounded-[2.5rem] shadow-2xl max-w-lg mx-auto"
             x-data="{
                initPicker() {
                    const now = new Date();
                    const cfg = {
                        enableTime: true,
                        dateFormat: 'Y-m-d H:i',
                        time_24hr: true,
                        minDate: now,
                        onChange: (dates, str, inst) => {
                            if (inst.element === this.$refs.start) {
                                @this.set('startTime', str);
                                const minEnd = new Date(dates[0].getTime() + 60 * 60000);
                                if (this.$refs.end._flatpickr) {
                                    this.$refs.end._flatpickr.set('minDate', minEnd);
                                    if (this.$refs.end.value && new Date(this.$refs.end.value) < minEnd) {
                                        this.$refs.end._flatpickr.setDate(minEnd, true);
                                    }
                                }
                            } else {
                                @this.set('endTime', str);
                            }
                        }
                    };
                    // Предзаполнение: сейчас и +1 час
                    const defaultStart = '{{ $startTime ?? now()->format("Y-m-d H:i") }}';
                    const defaultEnd = '{{ $endTime ?? now()->addHour()->format("Y-m-d H:i") }}';

                    flatpickr(this.$refs.start, { ...cfg, defaultDate: defaultStart });
                    flatpickr(this.$refs.end, { ...cfg, minDate: new Date(now.getTime() + 60*60000), defaultDate: defaultEnd });

                    // Инициализация иконок после рендера пикеров
                    setTimeout(() => typeof lucide !== 'undefined' && lucide.createIcons(), 100);
                }
             }"
             x-init="initPicker()"
             wire:ignore.self>

            <h3 class="text-2xl font-black text-white mb-8 text-center uppercase">Когда придете?</h3>

            <div class="space-y-6">
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase ml-1">Заезд</label>
                    <!-- text-white + placeholder-white для белого текста -->
                    <input x-ref="start" readonly placeholder="ДД.ММ.ГГГГ ЧЧ:ММ"
                           class="w-full mt-2 bg-slate-900 border border-slate-700 rounded-2xl text-white placeholder-white/50 px-6 py-4 cursor-pointer font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase ml-1">Выезд</label>
                    <input x-ref="end" readonly placeholder="ДД.ММ.ГГГГ ЧЧ:ММ"
                           class="w-full mt-2 bg-slate-900 border border-slate-700 rounded-2xl text-white placeholder-white/50 px-6 py-4 cursor-pointer font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                </div>
                <button wire:click="goToSize" wire:loading.attr="disabled"
                        class="w-full py-5 bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white rounded-2xl font-black transition-all">
                    ВЫБРАТЬ РАЗМЕР →
                </button>
            </div>
        </div>
    @endif

    <!-- STEP 2: РАЗМЕР -->
    @if($step == 2)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6"
             x-init="$nextTick(() => typeof lucide !== 'undefined' && lucide.createIcons())">

            @foreach(['small'=>['title'=>'Малая','icon'=>'tablet'], 'medium'=>['title'=>'Средняя','icon'=>'package'], 'large'=>['title'=>'Большая','icon'=>'archive']] as $key=>$data)
                @php
                    $available = $this->isTypeAvailable($key, $startTime, $endTime);
                    $dims = $this->getCellDimensions($key); // 📐 Динамические размеры из БД
                @endphp
                <button wire:click="selectType('{{ $key }}')" @disabled(!$available)
                class="group bg-[#1e293b] p-6 md:p-8 rounded-[2rem] border {{ $available ? 'border-slate-800 hover:border-indigo-500' : 'opacity-50 cursor-not-allowed' }} transition-all text-center relative">

                    @if(!$available)
                        <span class="absolute top-4 right-4 bg-rose-500 text-[9px] font-black px-2 py-1 rounded text-white uppercase">Занято</span>
                    @endif

                    <!-- Иконка -->
                    <div class="w-16 h-16 mx-auto mb-4 rounded-xl bg-slate-900 flex items-center justify-center text-indigo-400">
                        <i data-lucide="{{ $data['icon'] }}" class="w-8 h-8"></i>
                    </div>

                    <!-- Название -->
                    <h4 class="text-xl font-bold text-white">{{ $data['title'] }}</h4>

                    <!-- 📐 Габариты (адаптивно: точно или диапазон) -->
                    <div class="mt-3">
                    <span class="inline-flex items-center gap-1 text-[11px] font-mono text-slate-300 px-3 py-1.5 bg-slate-900 rounded-lg border border-slate-800">
                        @if($dims['isUniform'])
                            <!-- Одинаковый размер: 30 × 20 × 50 см -->
                            <span>{{ $dims['min']['w'] }}</span>
                            <span class="text-slate-600">×</span>
                            <span>{{ $dims['min']['h'] }}</span>
                            <span class="text-slate-600">×</span>
                            <span>{{ $dims['min']['d'] }}</span>
                            <span class="text-slate-500 ml-1">см</span>
                        @else
                            <!-- Диапазон: от 30×20×50 до 40×30×60 см -->
                            <span>от {{ $dims['min']['w'] }}×{{ $dims['min']['h'] }}×{{ $dims['min']['d'] }}</span>
                            <span class="text-slate-600">—</span>
                            <span>{{ $dims['max']['w'] }}×{{ $dims['max']['h'] }}×{{ $dims['max']['d'] }}</span>
                            <span class="text-slate-500 ml-1">см</span>
                        @endif
                    </span>

                        <!-- Объём (опционально) -->
                        @if($dims['min']['w'])
                            <p class="text-[10px] text-slate-500 mt-1.5">
                                @if($dims['isUniform'])
                                    ~{{ round($dims['volume_min']) }} л
                                @else
                                    {{ round($dims['volume_min']) }}–{{ round($dims['volume_max']) }} л
                                @endif
                            </p>
                        @endif
                    </div>

                    <!-- Статус доступности -->
                    <p class="text-xs mt-4 text-slate-500 {{ $available ? 'group-hover:text-slate-400' : '' }} transition-colors">
                        {{ $available ? 'Доступна' : 'Нет мест' }}
                    </p>
                </button>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <button wire:click="$set('step', 1)" class="text-slate-500 hover:text-white text-xs font-bold uppercase">← Назад</button>
        </div>
    @endif

    <!-- STEP 3: ФИНАЛ -->
    @if($step == 3)
        <div class="bg-[#1e293b] border border-slate-800 p-10 rounded-[2.5rem] shadow-2xl max-w-lg mx-auto text-center"
             x-init="$nextTick(() => typeof lucide !== 'undefined' && lucide.createIcons())">
            <div class="w-20 h-20 bg-emerald-500/10 text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-8">
                <i data-lucide="shield-check" class="w-10 h-10"></i>
            </div>
            <h3 class="text-2xl font-black text-white mb-8 uppercase">Подтвердить?</h3>

            <div class="bg-slate-900/50 border border-slate-800 rounded-2xl p-6 mb-8 text-left space-y-3">
                <div class="flex justify-between">
                    <span class="text-slate-500 text-[10px] font-bold uppercase">Размер</span>
                    <span class="text-white font-black">{{ strtoupper($selectedType ?? '—') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 text-[10px] font-bold uppercase">Период</span>
                    <span class="text-indigo-400 font-mono text-sm">
                        {{ $startTime ? \Carbon\Carbon::parse($startTime)->format('H:i') : '--:--' }} —
                        {{ $endTime ? \Carbon\Carbon::parse($endTime)->format('H:i') : '--:--' }}
                    </span>
                </div>
                <div class="flex justify-between pt-3 border-t border-slate-800">
                    <span class="text-slate-500 text-[10px] font-bold uppercase">Длительность</span>
                    <span class="text-white font-mono">{{ $this->hoursCount() }} ч.</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 text-[10px] font-bold uppercase">Итого</span>
                    <span class="text-emerald-400 font-black text-lg">{{ number_format($this->totalPrice(), 0, '.', ' ') }} ₽</span>
                </div>
            </div>

            <button wire:click="confirmBooking" wire:loading.attr="disabled"
                    class="w-full py-5 bg-emerald-600 hover:bg-emerald-500 disabled:opacity-50 text-white rounded-2xl font-black transition-all">
                ПОДТВЕРДИТЬ
            </button>
            <button wire:click="$set('step', 2)" class="mt-6 text-slate-500 hover:text-white text-xs font-bold uppercase">← Назад</button>
        </div>
    @endif
</div>

<!-- Глобальная инициализация иконок при обновлениях Livewire -->
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.hook('morph.updated', ({ el }) => {
            setTimeout(() => typeof lucide !== 'undefined' && lucide.createIcons(), 50);
        });
    });
    // Также на случай прямой загрузки без Livewire
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => typeof lucide !== 'undefined' && lucide.createIcons(), 100);
    });
</script>
