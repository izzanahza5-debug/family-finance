<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛡️ Pengaturan Pagu Anggaran Bulanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            
            <div class="mb-6 bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Pilih Periode Anggaran</h3>
                    <p class="text-xs text-gray-400">Menampilkan daftar batasan belanja keluarga</p>
                </div>
                <input type="month" wire:model.live="month_year" class="rounded-xl border-gray-200 text-sm font-bold text-gray-700 focus:border-blue-500 focus:ring-blue-500 py-2.5 px-4">
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
                    <h3 class="text-base font-extrabold text-gray-900 mb-4">Buat / Atur Batasan</h3>
                    
                    @if (session()->has('message'))
                        <div class="mb-4 p-3 bg-blue-50 text-blue-700 text-xs font-semibold rounded-xl">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="saveBudget" class="space-y-4">
                        <div>
    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pos Pengeluaran</label>
    <div x-data="{ dropdownOpen: false }" class="relative mt-1">
        
        <button type="button" @click="dropdownOpen = !dropdownOpen" class="w-full flex justify-between items-center rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm text-left transition-colors">
            <div class="flex items-center gap-2">
                <span x-show="!$wire.category" class="text-gray-400 font-bold">-- Pilih Pos Pengeluaran --</span>
                <span x-show="$wire.category" class="font-extrabold text-gray-900" x-text="$wire.category"></span>
            </div>
            <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-200" :class="dropdownOpen ? 'rotate-180' : ''"></i>
        </button>

        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" style="display: none;"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
             class="absolute z-[60] mt-2 w-full rounded-2xl bg-white shadow-[0_15px_40px_rgb(0,0,0,0.12)] border border-slate-100 overflow-hidden">
            
            <div class="p-3 border-b border-slate-50 bg-slate-50/50">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                    </div>
                    <input type="text" wire:model.live="searchCategory" placeholder="Ketik nama pos anggaran..." class="w-full bg-white border border-slate-200 rounded-xl pl-9 pr-3 py-2.5 text-xs font-bold focus:ring-2 focus:ring-blue-500/20 text-slate-700 placeholder-slate-400">
                </div>
            </div>

            <div class="max-h-52 overflow-y-auto p-2 custom-scrollbar">
                @forelse($categories as $cat)
                    <button type="button" @click="$wire.set('category', '{{ $cat->name }}'); dropdownOpen = false" class="w-full text-left px-3 py-2.5 rounded-xl hover:bg-slate-50 transition flex items-center gap-3 group">
                        <div class="h-8 w-8 rounded-lg flex items-center justify-center font-bold text-sm shadow-sm" style="background-color: {{ $cat->color }}15; color: {{ $cat->color }}; border: 1px solid {{ $cat->color }}30">
                            {{ $cat->icon }}
                        </div>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-blue-600">{{ $cat->name }}</span>
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
    @error('category') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
</div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Batas Maksimal (Rp)</label>
                            <input type="number" wire:model="amount" placeholder="Misal: 3000000" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                            @error('amount') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl text-sm transition shadow-sm">
                            Terapkan Batasan
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-base font-extrabold text-gray-900 mb-4">Daftar Limit Bulan Ini ({{ date('F Y', strtotime($month_year)) }})</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 text-xs font-bold text-gray-400 uppercase bg-gray-50">
                                    <th class="py-3 px-4">Kategori</th>
                                    <th class="py-3 px-4">Batas Anggaran</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($budgets as $b)
                                    <tr class="text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <td class="py-3.5 px-4 font-semibold text-gray-900">{{ $b->category }}</td>
                                        <td class="py-3.5 px-4 font-bold text-blue-600">Rp {{ number_format($b->amount, 0, ',', '.') }}</td>
                                        <td class="py-3.5 px-4 text-center">
                                            <button onclick="confirm('Hapus batasan ini?') || event.stopImmediatePropagation()" wire:click="deleteBudget({{ $b->id }})" class="text-xs font-bold text-rose-600 hover:bg-rose-50 px-3 py-1.5 rounded-lg transition">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-8 text-sm text-gray-400">Belum ada batas anggaran yang diatur untuk bulan ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <livewire:add-transaction />
</div>