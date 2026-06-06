<div>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-slate-800 leading-tight">
            📊 Laporan Transaksi Komprehensif
        </h2>
    </x-slot>

    <div class="py-6 space-y-6">
        
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center">
                    <i class="fa-solid fa-filter mr-2 text-indigo-500"></i> Penyaringan Data Laporan
                </h3>
                <button wire:click="resetFilters" class="text-xs font-bold text-rose-600 hover:underline">
                    Reset Filter
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Dari Tanggal</label>
                    <input type="date" wire:model.live="startDate" class="w-full rounded-2xl border-slate-200 text-xs font-bold text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-3">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Sampai Tanggal</label>
                    <input type="date" wire:model.live="endDate" class="w-full rounded-2xl border-slate-200 text-xs font-bold text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-3">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Jenis Dompet</label>
                    <select wire:model.live="walletType" class="w-full rounded-2xl border-slate-200 text-xs font-bold text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-3">
                        <option value="">-- Semua Dompet --</option>
                        <option value="family">🏠 Dompet Keluarga</option>
                        <option value="personal">👤 Dompet Pribadi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Kategori</label>
                    <select wire:model.live="category" class="w-full rounded-2xl border-slate-200 text-xs font-bold text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-3">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($distinctCategories as $catName)
                            <option value="{{ $catName }}">{{ $catName }}</option>
                        @endforeach
                    </select>
                </div>

                @if(Auth::user()->role === 'admin')
                    <div class="sm:col-span-2 md:col-span-4 lg:col-span-1">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">🛡️ Anggota (Admin Only)</label>
                        <select wire:model.live="userId" class="w-full rounded-2xl border-indigo-200 bg-indigo-50/30 text-xs font-bold text-indigo-900 focus:border-indigo-500 focus:ring-indigo-500 py-3">
                            <option value="">👁️ Semua Anggota Keluarga</option>
                            @foreach($allUsers as $u)
                                <option value="{{ $u->id }}">👤 {{ $u->name }} ({{ ucfirst($u->role) }})</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 bg-slate-50/40">
                <h3 class="text-base font-black text-slate-900">Lembar Catatan Transaksi</h3>
                <p class="text-xs text-slate-400 mt-0.5">Memuat rangkuman catatan mutasi keluar masuk dana</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-bold text-slate-400 uppercase bg-slate-50/70 border-b border-slate-100">
                            <th class="py-4 px-6">Tanggal</th>
                            <th class="py-4 px-6">Kategori / Keterangan</th>
                            <th class="py-4 px-6">Pencatat</th>
                            <th class="py-4 px-6">Dompet</th>
                            <th class="py-4 px-6 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-sm text-slate-700">
                        @forelse($transactions as $t)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 whitespace-nowrap text-xs font-bold text-slate-400">
                                    {{ date('d M Y', strtotime($t->date)) }}
                                </td>
                                <td class="py-4 px-6">
                                    <p class="font-bold text-slate-900">{{ $t->category }}</p>
                                    @if($t->note)
                                        <p class="text-xs text-slate-400 font-normal mt-0.5">📝 {{ $t->note }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-block bg-slate-100 text-slate-700 px-2.5 py-1 rounded-xl text-xs font-bold">
                                        {{ $t->user->name }}
                                    </span>
                                </td>
                                <td class="py-4 px-6流 whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-1 rounded-xl text-xs font-bold {{ $t->wallet_type == 'family' ? 'bg-blue-50 text-blue-600' : 'bg-emerald-50 text-emerald-600' }}">
                                        {{ $t->wallet_type == 'family' ? 'Keluarga' : 'Pribadi' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <span class="font-extrabold text-sm md:text-base {{ $t->type == 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $t->type == 'income' ? '+' : '-' }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16 text-sm font-bold text-slate-400">
                                    Tidak ditemukan catatan transaksi yang cocok dengan kriteria pencarian Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="p-6 border-t border-slate-50 bg-slate-50/20 shadow-inner">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>

    </div>
    <livewire:add-transaction />
</div>