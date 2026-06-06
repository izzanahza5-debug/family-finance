<div x-data="{ open: false }">
    <button @click="open = true" class="fixed bottom-11 right-11 z-50 bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-5 rounded-full shadow-2xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-4 focus:ring-blue-300 flex items-center justify-center group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover:rotate-90 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
        <span class="max-w-0 overflow-hidden group-hover:max-w-xs group-hover:ml-2 transition-all duration-300 ease-out text-sm font-bold whitespace-nowrap">Catat Keuangan</span>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-end sm:items-center justify-center p-4" style="display: none;">
        
        <div @click.away="open = false" x-show="open"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-8 sm:scale-95"
             class="bg-white w-full max-w-lg rounded-t-3xl sm:rounded-2xl p-6 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto custom-scrollbar">
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                <div>
                    <h3 class="text-xl font-extrabold text-gray-900">Catat Keuangan</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Isi detail transaksi Anda di bawah ini</p>
                </div>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-xl hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            @if (session()->has('message'))
                <div x-init="setTimeout(() => open = false, 1500)" class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-xl flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.297a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    <span>{{ session('message') }}</span>
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-5 relative">
                
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Gunakan Dompet</label>
                    <div class="grid grid-cols-2 gap-2 bg-gray-100 p-1 rounded-xl">
                        <label class="cursor-pointer">
                            <input type="radio" wire:model.live="wallet_type" value="family" class="sr-only peer">
                            <div class="py-2.5 text-center text-sm font-bold rounded-lg text-gray-600 transition peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow-sm">🏠 Keluarga</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model.live="wallet_type" value="personal" class="sr-only peer">
                            <div class="py-2.5 text-center text-sm font-bold rounded-lg text-gray-600 transition peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:shadow-sm">👤 Pribadi</div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nominal</label>
                    <div class="relative mt-1 rounded-xl shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <span class="text-xl font-extrabold text-gray-400">Rp</span>
                        </div>
                        <input type="number" wire:model="amount" placeholder="0" class="block w-full rounded-xl border-gray-200 pl-12 text-xl font-extrabold text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-300 py-3">
                    </div>
                    @error('amount') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kategori & Tipe</label>
                    <div x-data="{ dropdownOpen: false }" class="relative mt-1">
                        <button type="button" @click="dropdownOpen = !dropdownOpen" class="w-full flex justify-between items-center rounded-xl border-gray-200 bg-white px-4 py-3.5 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm border text-left transition-colors">
                            <div class="flex items-center gap-2">
                                <span x-show="!$wire.category" class="text-gray-400 font-bold">-- Pilih Jenis & Kategori --</span>
                                <span x-show="$wire.category" class="font-extrabold text-gray-900" x-text="$wire.category"></span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-200" :class="dropdownOpen ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" style="display: none;"
                             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute z-[60] mt-2 w-full rounded-2xl bg-white shadow-[0_15px_40px_rgb(0,0,0,0.12)] border border-slate-100 overflow-hidden">
                            
                            <div class="p-3 bg-slate-50 border-b border-slate-100">
                                <div class="grid grid-cols-2 gap-2 bg-slate-200/60 p-1 rounded-xl">
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model.live="type" value="expense" class="sr-only peer">
                                        <div class="py-2 text-center text-xs font-bold rounded-lg text-slate-500 transition peer-checked:bg-white peer-checked:text-rose-600 peer-checked:shadow-sm">🔴 Pengeluaran</div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model.live="type" value="income" class="sr-only peer">
                                        <div class="py-2 text-center text-xs font-bold rounded-lg text-slate-500 transition peer-checked:bg-white peer-checked:text-emerald-600 peer-checked:shadow-sm">🟢 Pemasukan</div>
                                    </label>
                                </div>
                            </div>

                            <div class="p-3 border-b border-slate-50">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                                    </div>
                                    <input type="text" wire:model.live="searchCategory" placeholder="Cari nama kategori..." class="w-full bg-slate-50 border-none rounded-xl pl-9 pr-3 py-2.5 text-xs font-bold focus:ring-2 focus:ring-indigo-500/20 text-slate-700 placeholder-slate-400">
                                </div>
                            </div>

                            <div class="max-h-52 overflow-y-auto p-2 custom-scrollbar">
                                @forelse($categories as $cat)
                                    <button type="button" @click="$wire.set('category', '{{ $cat->name }}'); dropdownOpen = false" class="w-full text-left px-3 py-2.5 rounded-xl hover:bg-slate-50 transition flex items-center gap-3 group">
                                        <div class="h-8 w-8 rounded-lg flex items-center justify-center font-bold text-sm shadow-sm" style="background-color: {{ $cat->color }}15; color: {{ $cat->color }}; border: 1px solid {{ $cat->color }}30">
                                            {{ $cat->icon }}
                                        </div>
                                        <span class="text-sm font-bold text-slate-700 group-hover:text-indigo-600">{{ $cat->name }}</span>
                                    </button>
                                @empty
                                    <div class="text-center py-6">
                                        <i class="fa-solid fa-folder-open text-slate-300 text-2xl mb-2"></i>
                                        <p class="text-xs font-bold text-slate-400">Kategori tidak ditemukan</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @error('category') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                    @error('type') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal</label>
                        <input type="date" wire:model="date" class="w-full rounded-xl border-gray-200 text-sm font-bold text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 py-3">
                        @error('date') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Keterangan Tambahan</label>
                        <input type="text" wire:model="note" placeholder="Misal: Sarapan Pagi" class="w-full rounded-xl border-gray-200 text-sm font-medium focus:border-indigo-500 focus:ring-indigo-500 py-3">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-900 hover:to-black text-white font-bold py-4 px-4 rounded-xl text-sm transition shadow-lg flex items-center justify-center space-x-2">
                        <span>Simpan Catatan Mutasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>