<div class="font-['Plus_Jakarta_Sans'] relative">
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight flex items-center gap-2">
            <i class="fa-solid fa-users text-indigo-500"></i>
            Kelola Anggota & Hak Akses
        </h2>
    </x-slot>

    <div class="py-8">
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl flex items-center space-x-3 shadow-sm">
                <div class="h-8 w-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm font-bold rounded-2xl flex items-center space-x-3 shadow-sm">
                <div class="h-8 w-8 bg-rose-100 rounded-full flex items-center justify-center text-rose-600">
                    <i class="fa-solid fa-exclamation"></i>
                </div>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="bg-white p-7 rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-full opacity-70 pointer-events-none"></div>

                <div class="mb-6 relative z-10">
                    <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Tambah Anggota</h3>
                    <p class="text-sm text-slate-500 mt-1">Daftarkan akun baru untuk keluarga</p>
                </div>

                <form wire:submit.prevent="createUser" class="space-y-5 relative z-10">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                        <input type="text" wire:model="name" placeholder="Misal: Kakak Sasa" 
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3.5 px-4 outline-none transition-all">
                        @error('name') <span class="text-xs text-rose-500 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Alamat Email</label>
                        <input type="email" wire:model="email" placeholder="sasa@mail.com" 
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3.5 px-4 outline-none transition-all">
                        @error('email') <span class="text-xs text-rose-500 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Kata Sandi</label>
                        <input type="password" wire:model="password" placeholder="Minimal 6 karakter" 
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3.5 px-4 outline-none transition-all">
                        @error('password') <span class="text-xs text-rose-500 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Hak Akses (Role)</label>
                        <select wire:model="role" 
                                class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3.5 px-4 outline-none transition-all cursor-pointer">
                            <option value="parent">👨 Parent (Akses Standard)</option>
                            <option value="admin">🛡️ Admin (Akses Penuh)</option>
                        </select>
                        @error('role') <span class="text-xs text-rose-500 mt-1.5 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold py-4 px-4 rounded-xl text-sm transition-all duration-200 shadow-[0_8px_20px_rgb(99,102,241,0.3)] hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-2">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Simpan Anggota Baru</span>
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-white rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden pb-12">
                <div class="p-7 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Anggota Terdaftar</h3>
                        <p class="text-sm text-slate-500 mt-1">Daftar pengguna yang memiliki akses</p>
                    </div>
                    <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center font-bold">
                        {{ count($users) }}
                    </div>
                </div>

                <div class="overflow-x-visible">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="py-4 px-7 text-xs font-bold text-slate-500 uppercase tracking-widest">Pengguna</th>
                                <th class="py-4 px-7 text-xs font-bold text-slate-500 uppercase tracking-widest">Hak Akses</th>
                                <th class="py-4 px-7 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $u)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="py-5 px-7">
                                        <div class="flex items-center gap-4">
                                            <div class="h-11 w-11 rounded-xl flex items-center justify-center font-extrabold text-sm flex-shrink-0 transition-transform group-hover:scale-105
                                                {{ $u->role === 'admin' ? 'bg-gradient-to-br from-amber-100 to-orange-100 text-amber-700' : 'bg-gradient-to-br from-indigo-100 to-purple-100 text-indigo-700' }}">
                                                {{ substr($u->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="font-extrabold text-slate-900 text-sm">{{ $u->name }}</p>
                                                <p class="text-xs font-medium text-slate-500 mt-0.5">{{ $u->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 px-7">
                                        @if($u->role === 'admin')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60 tracking-wider uppercase">
                                                <i class="fa-solid fa-shield-halved"></i> Admin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60 tracking-wider uppercase">
                                                <i class="fa-solid fa-user"></i> Parent
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-5 px-7 text-center">
                                        <div x-data="{ menuOpen: false }" class="relative inline-block text-left" @click.away="menuOpen = false">
                                            <button @click="menuOpen = !menuOpen" class="h-8 w-8 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors flex items-center justify-center mx-auto">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>

                                            <div x-show="menuOpen" 
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100"
                                                 x-transition:leave-end="transform opacity-0 scale-95"
                                                 class="absolute right-8 top-0 z-[60] w-36 rounded-xl bg-white shadow-[0_10px_40px_rgb(0,0,0,0.1)] border border-slate-100 py-1.5 overflow-hidden" 
                                                 style="display: none;">
                                                
                                                <button wire:click="editUser({{ $u->id }})" @click="menuOpen = false" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 transition-colors text-left">
                                                    <i class="fa-solid fa-pen-to-square text-slate-400"></i> Edit Anggota
                                                </button>
                                                
                                                @if(Auth::user()->id !== $u->id)
                                                    <button onclick="confirm('Yakin ingin menghapus anggota ini?') || event.stopImmediatePropagation()" wire:click="deleteUser({{ $u->id }})" @click="menuOpen = false" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition-colors text-left">
                                                        <i class="fa-solid fa-trash-can text-rose-400"></i> Hapus Akun
                                                    </button>
                                                @else
                                                    <div class="w-full flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-slate-300 bg-slate-50 cursor-not-allowed">
                                                        <i class="fa-solid fa-ban"></i> Anda Sendiri
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($isEditModalOpen)
        <div class="fixed inset-0 z-[100] flex items-center justify-center">
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" wire:click="closeEditModal"></div>

            <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-md overflow-hidden relative z-10 transform transition-all p-7 border border-slate-100 mx-4">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Edit Anggota</h3>
                        <p class="text-xs text-slate-500 mt-1">Ubah identitas atau hak akses</p>
                    </div>
                    <button wire:click="closeEditModal" class="h-8 w-8 bg-slate-50 hover:bg-rose-50 hover:text-rose-600 text-slate-400 rounded-full flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark text-sm font-bold"></i>
                    </button>
                </div>

                <form wire:submit.prevent="updateUser" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                        <input type="text" wire:model="editName" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl focus:bg-white focus:border-indigo-500 py-3 px-4 outline-none">
                        @error('editName') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Alamat Email</label>
                        <input type="email" wire:model="editEmail" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium rounded-xl focus:bg-white focus:border-indigo-500 py-3 px-4 outline-none">
                        @error('editEmail') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Hak Akses</label>
                        <select wire:model="editRole" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-bold rounded-xl focus:bg-white focus:border-indigo-500 py-3 px-4 outline-none">
                            <option value="parent">👨 Parent</option>
                            <option value="admin">🛡️ Admin</option>
                        </select>
                        @error('editRole') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" wire:click="closeEditModal" class="flex-1 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold py-3.5 rounded-xl text-sm transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl text-sm transition-colors shadow-lg shadow-indigo-600/30">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <livewire:add-transaction />
</div>