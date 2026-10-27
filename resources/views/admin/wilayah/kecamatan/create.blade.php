<x-admin-layout title="Tambah Kecamatan Baru" header="Tambah Data Kecamatan">
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('admin.kecamatan.index') }}" class="hover:text-brand-navy">Wilayah</a>
            <span>&rarr;</span>
            <a href="{{ route('admin.kecamatan.index') }}" class="hover:text-brand-navy">Kecamatan</a>
            <span>&rarr;</span>
            <span class="font-bold text-slate-700">Tambah Baru</span>
        </div>

        <x-card title="Formulir Tambah Kecamatan" subtitle="Masukkan kode dan nama kecamatan resmi di Kota Bandung">
            <form action="{{ route('admin.kecamatan.store') }}" method="POST" class="space-y-5">
                @csrf

                <x-form-input
                    name="kode_kecamatan"
                    label="Kode Kecamatan"
                    placeholder="Contoh: 32.73.01"
                    :value="old('kode_kecamatan')"
                    required
                    help="Format standar wilayah administrasi pemerintahan (misal: 32.73.xx)"
                />

                <x-form-input
                    name="nama_kecamatan"
                    label="Nama Kecamatan"
                    placeholder="Contoh: Andir"
                    :value="old('nama_kecamatan')"
                    required
                    help="Nama resmi kecamatan tanpa singkatan"
                />

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <x-button variant="secondary" :href="route('admin.kecamatan.index')">
                        Batal
                    </x-button>
                    <x-button variant="primary" type="submit" dusk="submit-btn">
                        Simpan Kecamatan
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-admin-layout>
