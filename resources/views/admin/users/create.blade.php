<x-admin-layout title="Tambah Pengguna Baru">
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
            <div>
                <h1 class="text-2xl font-bold text-[#1F3A5F] tracking-tight">Tambah Pengguna Baru</h1>
                <p class="text-sm text-slate-500 mt-1">Daftarkan akun admin, petugas, pimpinan, atau warga ke dalam sistem.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                Kembali
            </a>
        </div>

        <!-- Form Card -->
        <x-card class="p-6">
            <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full px-3.5 py-2.5 border rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent @error('name') border-rose-300 bg-rose-50/30 @else border-slate-300 @enderror"
                        placeholder="Contoh: Budi Santoso"
                    >
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-3.5 py-2.5 border rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent @error('email') border-rose-300 bg-rose-50/30 @else border-slate-300 @enderror"
                        placeholder="Contoh: budi@dsdabm.bandung.go.id"
                    >
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor Telepon / WhatsApp</label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            value="{{ old('phone') }}"
                            class="w-full px-3.5 py-2.5 border rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent @error('phone') border-rose-300 bg-rose-50/30 @else border-slate-300 @enderror"
                            placeholder="Contoh: 081234567890"
                        >
                        @error('phone')
                            <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">Peran (Role) <span class="text-rose-500">*</span></label>
                        <select
                            name="role"
                            id="role"
                            required
                            class="w-full px-3.5 py-2.5 border rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent @error('role') border-rose-300 bg-rose-50/30 @else border-slate-300 @enderror"
                        >
                            <option value="">Pilih Peran Akun</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin DSDABM</option>
                            <option value="petugas" {{ old('role') === 'petugas' ? 'selected' : '' }}>Petugas Lapangan</option>
                            <option value="pimpinan" {{ old('role') === 'pimpinan' ? 'selected' : '' }}>Pimpinan Eksekutif</option>
                            <option value="warga" {{ old('role') === 'warga' ? 'selected' : '' }}>Warga</option>
                        </select>
                        @error('role')
                            <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password <span class="text-rose-500">*</span></label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full px-3.5 py-2.5 border rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent @error('password') border-rose-300 bg-rose-50/30 @else border-slate-300 @enderror"
                            placeholder="Minimal 8 karakter"
                        >
                        @error('password')
                            <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password <span class="text-rose-500">*</span></label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent"
                            placeholder="Ulangi password"
                        >
                    </div>
                </div>

                <div>
                    <label for="avatar" class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Profil / Avatar</label>
                    <input
                        type="file"
                        name="avatar"
                        id="avatar"
                        accept="image/png,image/jpeg,image/jpg"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-[#1F3A5F] hover:file:bg-slate-200 cursor-pointer"
                    >
                    <p class="text-xs text-slate-400 mt-1">Maksimal 5MB. Format yang didukung: JPG, JPEG, PNG.</p>
                    @error('avatar')
                        <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit" dusk="submit-btn" class="px-5 py-2.5 bg-[#0E7C86] hover:bg-[#0b636b] text-white font-medium text-sm rounded-xl transition-all shadow-sm">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </x-card>
    </div>
</x-admin-layout>
