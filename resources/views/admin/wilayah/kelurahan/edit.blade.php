<x-admin-layout title="Ubah Kelurahan {{ $kelurahan->nama_kelurahan }}" header="Ubah Data Kelurahan">
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('admin.kecamatan.index') }}" class="hover:text-brand-navy">Wilayah</a>
            <span>&rarr;</span>
            <a href="{{ route('admin.kelurahan.index') }}" class="hover:text-brand-navy">Kelurahan</a>
            <span>&rarr;</span>
            <span class="font-bold text-slate-700">Ubah Data</span>
        </div>

        <x-card title="Ubah Data Kelurahan" subtitle="Perbarui kecamatan induk, kode, atau nama kelurahan">
            <form action="{{ route('admin.kelurahan.update', $kelurahan->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Kecamatan Dropdown -->
                <div class="space-y-1.5">
                    <label for="kecamatan_id" class="block text-sm font-semibold text-brand-navy">
                        Kecamatan Induk <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="kecamatan_id"
                        id="kecamatan_id"
                        required
                        class="w-full rounded-xl border-slate-300 py-2.5 text-sm text-slate-800 focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20 @error('kecamatan_id') border-rose-400 @enderror"
                    >
                        @foreach ($kecamatanList as $kec)
                            <option value="{{ $kec->id }}" {{ (string)old('kecamatan_id', $kelurahan->kecamatan_id) === (string)$kec->id ? 'selected' : '' }}>
                                {{ $kec->nama_kecamatan }} ({{ $kec->kode_kecamatan }})
                            </option>
                        @endforeach
                    </select>
                    @error('kecamatan_id')
                        <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <x-form-input
                    name="kode_kelurahan"
                    label="Kode Kelurahan"
                    placeholder="Contoh: 32.73.01.1001"
                    :value="old('kode_kelurahan', $kelurahan->kode_kelurahan)"
                    required
                />

                <x-form-input
                    name="nama_kelurahan"
                    label="Nama Kelurahan"
                    placeholder="Contoh: Campaka"
                    :value="old('nama_kelurahan', $kelurahan->nama_kelurahan)"
                    required
                />

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <x-button variant="secondary" :href="route('admin.kelurahan.index')">
                        Batal
                    </x-button>
                    <x-button variant="primary" type="submit" dusk="submit-btn">
                        Simpan Perubahan
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-admin-layout>
