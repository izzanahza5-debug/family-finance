<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-br from-indigo-600 to-blue-700 text-white rounded-3xl p-6 shadow-xl relative overflow-hidden transition-transform duration-300 hover:scale-[1.01]">
            <div class="absolute right-0 bottom-0 opacity-10 translate-x-4 translate-y-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-40 w-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <p class="text-xs font-bold opacity-75 uppercase tracking-wider">🏠 Dompet Bersama Keluarga</p>
            <h3 class="text-3xl font-black mt-2 tracking-tight">Rp {{ number_format($familyBalance, 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center text-[11px] font-bold opacity-90 bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-xl w-fit">
                <i class="fa-solid fa-users mr-1.5"></i>
                <span>Dapat diakses oleh semua anggota</span>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white rounded-3xl p-6 shadow-xl relative overflow-hidden transition-transform duration-300 hover:scale-[1.01]">
            <div class="absolute right-0 bottom-0 opacity-10 translate-x-4 translate-y-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-40 w-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <p class="text-xs font-bold opacity-75 uppercase tracking-wider">👤 Dompet Pribadi Saya ({{ Auth::user()->name }})</p>
            <h3 class="text-3xl font-black mt-2 tracking-tight">Rp {{ number_format($personalBalance, 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center text-[11px] font-bold opacity-90 bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-xl w-fit">
                <i class="fa-solid fa-lock mr-1.5"></i>
                <span>Hanya Anda yang bisa melihat rahasia ini</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm p-6 border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h4 class="text-base font-black text-slate-900">Aktivitas Transaksi Terakhir</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Menampilkan hingga 10 riwayat catatan terbaru</p>
                </div>
                <a href="{{ route('transaction-reports') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-4 py-2.5 rounded-xl transition duration-200">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentTransactions as $tx)
                    <div class="py-4 flex justify-between items-center group transition">
                        <div class="flex items-center space-x-3.5">
                            <div class="p-3 rounded-2xl font-bold transition flex items-center justify-center {{ $tx->type == 'income' ? 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100' : 'bg-rose-50 text-rose-600 group-hover:bg-rose-100' }}">
                                @if($tx->type == 'income')
                                    <i class="fa-solid fa-arrow-trend-up text-sm"></i>
                                @else
                                    <i class="fa-solid fa-arrow-trend-down text-sm"></i>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm md:text-base leading-tight">{{ $tx->category }}</p>
                                <p class="text-xs text-slate-400 mt-1 flex flex-wrap gap-1 items-center">
                                    <span class="font-semibold text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded-md">Oleh: {{ $tx->user->name }}</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="px-1.5 py-0.5 rounded-md {{ $tx->wallet_type == 'family' ? 'bg-blue-50 text-blue-600 font-bold' : 'bg-emerald-50 text-emerald-600 font-bold' }}">
                                        {{ $tx->wallet_type == 'family' ? 'Dompet Keluarga' : 'Dompet Pribadi' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-extrabold text-sm md:text-base {{ $tx->type == 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $tx->type == 'income' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </p>
                            <p class="text-xs font-semibold text-slate-400 mt-1">{{ date('d M Y', strtotime($tx->date)) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-sm font-bold text-slate-400">Belum ada transaksi yang dicatat bulan ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-1 bg-white rounded-3xl shadow-sm p-6 border border-slate-100">
            <div class="mb-5">
                <div class="flex flex-wrap items-center gap-2">
                    <h4 class="text-base font-black text-slate-900">⚠️ Kontrol Anggaran</h4>
                    <span class="text-[9px] font-extrabold bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-md uppercase tracking-wider border border-indigo-100">
                        Bulan Ini
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-0.5">Monitoring kuota pengeluaran bersama keluarga</p>
            </div>
            
            @if(count($budgetStatuses) > 0)
                <div class="space-y-5">
                    @foreach($budgetStatuses as $status)
                        <div class="space-y-1.5 bg-slate-50/50 p-3.5 rounded-2xl border border-slate-100/60">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-800">{{ $status['category'] }}</span>
                                <span class="font-bold text-slate-500">{{ number_format($status['real_percentage'], 1, ',', '.') }}%</span>
                            </div>
                            
                            <div class="w-full bg-slate-200/70 h-2.5 rounded-full overflow-hidden relative shadow-inner">
                                <div class="h-full transition-all duration-500 rounded-full" 
                                     style="width: {{ min($status['percentage'], 100) }}%; 
                                            background-color: {{ $status['real_percentage'] >= 100 ? '#E11D48' : ($status['real_percentage'] >= 85 ? '#F59E0B' : '#6366F1') }};">
                                </div>
                            </div>

                            <div class="flex justify-between items-center text-[11px] pt-1">
                                <span class="font-bold tracking-tight {{ $status['real_percentage'] >= 100 ? 'text-rose-600' : ($status['real_percentage'] >= 85 ? 'text-amber-600' : 'text-indigo-600') }}">
                                    @if($status['real_percentage'] >= 100)
                                        🚨 Overbudget!
                                    @elseif($status['real_percentage'] >= 85)
                                        ⚠️ Kuota Sekarat!
                                    @else
                                        ✅ Anggaran Aman
                                    @endif
                                </span>
                                <span class="text-[10px] font-medium text-slate-400">
                                    Rp {{ number_format($status['spent'], 0, ',', '.') }} / {{ number_format($status['limit'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-xs font-bold text-slate-400">Belum ada anggaran belanja yang diatur.</p>
                </div>
            @endif
        </div>

    </div>
</div>