<div class="max-w-4xl mx-auto px-4 py-8">

    <!-- STEPS INDICATOR -->
    <div class="flex items-center justify-center mb-12 gap-4">
        @foreach(['ВРЕМЯ', 'РАЗМЕР', 'ФИНАЛ'] as $index => $label)
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold transition-all
                    {{ $step >= ($index + 1) ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-800 text-slate-500' }}">
                    {{ $index + 1 }}
                </div>
                <span class="text-[10px] tracking-widest font-black {{ $step == ($index + 1) ? 'text-white' : 'text-slate-500' }}">
                    {{ $label }}
                </span>
            </div>
            @if($index < 2) <div class="w-12 h-px bg-slate-800"></div> @endif
        @endforeach
    </div>

    <!-- STEP 1: ВЫБОР ВРЕМЕНИ -->
    @if($step == 1)
        <div class="bg-[#1e293b] border border-slate-800 p-10 rounded-[2.5rem] shadow-2xl max-w-lg mx-auto"
             x-data="{
                initPicker() {
                    const fpConfig = {
                        enableTime: true,
                        dateFormat: 'Y-m-d H:i',
                        time_24hr: true,
                        locale: 'ru',
                        minDate: 'today'
                    };
                    flatpickr($refs.start, { ...fpConfig, onChange: (d, str) => @this.set('startTime', str) });
                    flatpickr($refs.end, { ...fpConfig, onChange: (d, str) => @this.set('endTime', str) });
                }
             }" x-init="initPicker()">

            <h3 class="text-2xl font-black text-white mb-8 text-center uppercase tracking-tight">Когда придете?</h3>

            <div class="space-y-6">
                <div class="relative group">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Дата и время заезда</label>
                    <input x-ref="start" value="{{ $startTime }}" readonly
                           class="w-full mt-2 bg-slate-900 border-slate-700 rounded-2xl text-indigo-400 px-6 py-4 cursor-pointer focus:border-indigo-500 transition-all font-mono">
                </div>

                <div class="relative group">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Дата и время выезда</label>
                    <input x-ref="end" value="{{ $endTime }}" readonly
                           class="w-full mt-2 bg-slate-900 border-slate-700 rounded-2xl text-indigo-400 px-6 py-4 cursor-pointer focus:border-indigo-500 transition-all font-mono">
                </div>

                <button wire:click="goToSize" class="w-full py-5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-black shadow-xl transition-all active:scale-95 mt-4">
                    ВЫБРАТЬ РАЗМЕР →
                </button>
            </div>
        </div>
    @endif

    <!-- STEP 2: ВЫБОР РАЗМЕРА -->
    @if($step == 2)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-in fade-in slide-in-from-bottom-4">
            @foreach(['small' => ['title' => 'Малая', 'icon' => 'tablet'],
                      'medium' => ['title' => 'Средняя', 'icon' => 'package'],
                      'large' => ['title' => 'Большая', 'icon' => 'archive']] as $key => $data)

                @php $isAvailable = $this->isTypeAvailable($key, $startTime, $endTime); @endphp

                <button wire:click="selectType('{{ $key }}')" @disabled(!$isAvailable)
                class="group relative bg-[#1e293b] p-8 rounded-[2rem] border transition-all text-center
                    {{ $isAvailable ? 'border-slate-800 hover:border-indigo-500' : 'opacity-50 cursor-not-allowed border-rose-900/20' }}">

                    @if(!$isAvailable)
                        <div class="absolute top-4 right-4 bg-rose-500 text-[9px] font-black px-2 py-1 rounded text-white uppercase">Занято</div>
                    @endif

                    <div class="w-16 h-16 mx-auto mb-6 rounded-xl bg-slate-900 flex items-center justify-center text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                        <i data-lucide="{{ $data['icon'] }}" class="w-8 h-8"></i>
                    </div>

                    <h4 class="text-xl font-bold {{ $isAvailable ? 'text-white' : 'text-slate-600' }}">{{ $data['title'] }}</h4>
                    <p class="text-xs mt-2 {{ $isAvailable ? 'text-slate-500' : 'text-rose-400/50' }}">
                        {{ $isAvailable ? 'Доступна для брони' : 'Нет мест на это время' }}
                    </p>
                </button>
            @endforeach
        </div>
        <div class="mt-8 text-center">
            <button wire:click="$set('step', 1)" class="text-slate-500 hover:text-white text-xs font-bold uppercase tracking-widest">
                ← Изменить время
            </button>
        </div>
    @endif

    <!-- STEP 3: ПОДТВЕРЖДЕНИЕ -->
    @if($step == 3)
        <div class="bg-[#1e293b] border border-slate-800 p-10 rounded-[2.5rem] shadow-2xl max-w-lg mx-auto text-center">
            <div class="w-20 h-20 bg-emerald-500/10 text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-8">
                <i data-lucide="shield-check" class="w-10 h-10"></i>
            </div>
            <h3 class="text-2xl font-black text-white mb-8 uppercase tracking-tighter">Все верно?</h3>

            <div class="bg-slate-900/50 border border-slate-800 rounded-2xl p-6 mb-8 text-left space-y-4">
                <div class="flex justify-between border-b border-slate-800 pb-3">
                    <span class="text-slate-500 text-[10px] font-bold uppercase">Размер</span>
                    <span class="text-white font-black">{{ strtoupper($selectedType) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 text-[10px] font-bold uppercase">Период</span>
                    <span class="text-indigo-400 font-mono text-sm">
                        {{ Carbon\Carbon::parse($startTime)->format('H:i') }} — {{ Carbon\Carbon::parse($endTime)->format('H:i') }}
                    </span>
                </div>
            </div>

            <button wire:click="confirmBooking" class="w-full py-5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-2xl font-black text-lg shadow-lg transition-all active:scale-95">
                ПОДТВЕРДИТЬ БРОНЬ
            </button>
            <button wire:click="$set('step', 2)" class="mt-6 text-slate-500 hover:text-white text-xs font-bold uppercase tracking-widest block w-full text-center">
                Назад к выбору размера
            </button>
        </div>
    @endif

</div>
