<div class="font-['Plus_Jakarta_Sans'] relative">
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight flex items-center gap-2">
            <i class="fa-solid fa-tags text-indigo-500"></i>
            Kelola Kategori Keuangan
        </h2>
    </x-slot>

    <div class="py-8">
        <!-- Notifikasi Status -->
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl flex items-center space-x-3 shadow-sm animate-fade-in">
                <div class="h-8 w-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- KOLOM KIRI: FORM TAMBAH KATEGORI (MODERN & CERAH) -->
            <div class="bg-white p-7 rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-indigo-50 to-emerald-50 rounded-full opacity-60 pointer-events-none"></div>

                <div class="mb-6 relative z-10">
                    <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Kategori Baru</h3>
                    <p class="text-sm text-slate-500 mt-1">Buat pembagi pos keuangan</p>
                </div>

                <form wire:submit.prevent="createCategory" class="space-y-5 relative z-10">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Kategori</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Belanja Sayur" 
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3.5 px-4 outline-none transition-all">
                        @error('name') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Tipe Kategori</label>
                        <div class="grid grid-cols-2 gap-2 bg-slate-100 p-1 rounded-xl">
                            <label class="cursor-pointer">
                                <input type="radio" wire:model.live="type" value="expense" class="sr-only peer">
                                <div class="py-2 text-center text-xs font-bold rounded-lg text-slate-600 transition peer-checked:bg-white peer-checked:text-rose-600 peer-checked:shadow-sm">
                                    🔴 Pengeluaran
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" wire:model.live="type" value="income" class="sr-only peer">
                                <div class="py-2 text-center text-xs font-bold rounded-lg text-slate-600 transition peer-checked:bg-white peer-checked:text-emerald-600 peer-checked:shadow-sm">
                                    🟢 Pemasukan
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Ikon (Opsional)</label>
                            <select wire:model="icon" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl focus:bg-white focus:border-indigo-500 py-3 px-4 outline-none transition-all cursor-pointer">
                                <option value="">Auto Icon</option>
                                @foreach($defaultIcons as $ico)
                                    <option value="{{ $ico }}">{{ $ico }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Warna (Opsional)</label>
                            <div class="flex items-center gap-2">
                                <input type="color" wire:model="color" class="h-11 w-11 rounded-xl border border-slate-200 cursor-pointer bg-slate-50 p-1">
                                <span class="text-xs font-bold text-slate-500 uppercase">{{ $color ?: '#Auto' }}</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold py-4 px-4 rounded-xl text-sm transition-all duration-200 shadow-[0_8px_20px_rgb(99,102,241,0.3)] hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-2">
                        <i class="fa-solid fa-plus"></i>
                        <span>Simpan Kategori</span>
                    </button>
                </form>
            </div>

            <!-- KOLOM KANAN: TAB LAYOUT & DAFTAR KATEGORI AKTIF -->
            <div class="lg:col-span-2 bg-white rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden p-6">
                <!-- Nav Tabs Kontrol -->
                <div class="flex border-b border-slate-100 pb-4 justify-between items-center flex-wrap gap-4">
                    <div class="flex gap-2 bg-slate-100 p-1 rounded-xl">
                        <button wire:click="setTab('expense')" class="px-4 py-2 text-xs font-bold rounded-lg transition-all {{ $activeTab === 'expense' ? 'bg-white text-rose-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                            🔴 Pengeluaran
                        </button>
                        <button wire:click="setTab('income')" class="px-4 py-2 text-xs font-bold rounded-lg transition-all {{ $activeTab === 'income' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                            🟢 Pemasukan
                        </button>
                    </div>
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-xl">
                        Total: {{ count($filteredCategories) }} Pos
                    </span>
                </div>

                <!-- Grid Item Kategori -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                    @forelse($filteredCategories as $cat)
                        <div class="bg-slate-50/50 border border-slate-100 p-4 rounded-2xl flex items-center justify-between group hover:shadow-md hover:bg-white transition-all duration-200">
                            <div class="flex items-center gap-3">
                                <!-- Box Icon Bulat dengan Warna Sesuai Kategori -->
                                <div class="h-11 w-11 rounded-xl flex items-center justify-center font-bold text-lg shadow-inner" 
                                     style="background-color: {{ $cat->color }}20; border: 1px solid {{ $cat->color }}40;">
                                    <span>{{ $cat->icon }}</span>
                                </div>
                                <div>
                                    <p class="font-extrabold text-slate-800 text-sm">{{ $cat->name }}</p>
                                    <p class="text-[10px] font-bold uppercase tracking-wider mt-0.5" style="color: {{ $cat->color }}">
                                        {{ $cat->type }}
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Dropdown Tindakan -->
                            <div x-data="{ openMenu: false }" class="relative inline-block text-left" @click.away="openMenu = false">
                                <button @click="openMenu = !openMenu" class="h-8 w-8 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 flex items-center justify-center transition-all">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>

                                <div x-show="openMenu" 
                                     x-transition:enter="transition duration-100 ease-out"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition duration-75 ease-in"
                                     class="absolute right-0 top-8 z-50 w-32 rounded-xl bg-white shadow-[0_10px_30px_rgba(0,0,0,0.08)] border border-slate-100 py-1" 
                                     style="display: none;">
                                    
                                    <button wire:click="editCategory({{ $cat->id }})" @click="openMenu = false" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-bold text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 text-left transition-colors">
                                        <i class="fa-solid fa-pen-to-square text-slate-400"></i> Edit Pos
                                    </button>
                                    <button onclick="confirm('Hapus kategori ini? Transaksi yang terkait akan kehilangan kategorinya.') || event.stopImmediatePropagation()" wire:click="deleteCategory({{ $cat->id }})" @click="openMenu = false" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-bold text-rose-600 hover:text-rose-700 hover:bg-rose-50 text-left transition-colors">
                                        <i class="fa-solid fa-trash-can text-rose-400"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="sm:col-span-2 text-center py-12">
                            <p class="text-sm font-bold text-slate-400">Belum ada kategori untuk tipe ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8 ff-pagination">
                    {{ $filteredCategories->links() }}
                </div>

            </div>
            
        </div>
    </div>

    <!-- MODAL EDIT KATEGORI OVERLAY -->
    @if($isEditModalOpen)
        <div class="fixed inset-0 z-[100] flex items-center justify-center">
            <!-- Background Backdrop -->
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" wire:click="closeEditModal"></div>

            <!-- Modal Content -->
            <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-md overflow-hidden relative z-10 p-7 border border-slate-100 mx-4 animate-scale-up">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Ubah Pos Kategori</h3>
                        <p class="text-xs text-slate-500 mt-1">Sesuaikan nama, tipe, dan visualisasi pos</p>
                    </div>
                    <button wire:click="closeEditModal" class="h-8 w-8 bg-slate-50 hover:bg-rose-50 hover:text-rose-600 text-slate-400 rounded-full flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark text-sm font-bold"></i>
                    </button>
                </div>

                <form wire:submit.prevent="updateCategory" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Nama Kategori</label>
                        <input type="text" wire:model="editName" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl focus:bg-white focus:border-indigo-500 py-3 px-4 outline-none">
                        @error('editName') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Tipe Kategori</label>
                        <select wire:model="editType" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl focus:bg-white focus:border-indigo-500 py-3 px-4 outline-none">
                            <option value="expense">🔴 Pengeluaran</option>
                            <option value="income">🟢 Pemasukan</option>
                        </select>
                        @error('editType') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Ikon</label>
                            <select wire:model="editIcon" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl focus:bg-white focus:border-indigo-500 py-3 px-4 outline-none">
                                @foreach($defaultIcons as $ico)
                                    <option value="{{ $ico }}">{{ $ico }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Warna</label>
                            <div class="flex items-center gap-2">
                                <input type="color" wire:model="editColor" class="h-11 w-11 rounded-xl border border-slate-200 cursor-pointer bg-slate-50 p-1">
                                <span class="text-xs font-bold text-slate-500 uppercase">{{ $editColor }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" wire:click="closeEditModal" class="flex-1 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold py-3.5 rounded-xl text-sm transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl text-sm transition-colors shadow-lg shadow-indigo-600/30">
                            Terapkan Edit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <livewire:add-transaction />
</div>