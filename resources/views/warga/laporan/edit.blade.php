<x-warga-layout title="Ubah Laporan Kerusakan">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="border-b border-slate-200 pb-4">
            <h1 class="text-2xl font-bold text-[#1F3A5F] tracking-tight">Ubah Laporan: {{ $laporan->nomor_tiket }}</h1>
            <p class="text-sm text-slate-500 mt-1">Perbarui data laporan kerusakan Anda selama status masih menunggu verifikasi.</p>
        </div>

        <!-- Form Card -->
        <x-card class="p-6 sm:p-8">
            <form method="POST" action="{{ route('warga.laporan.update', $laporan->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Informasi Utama -->
                <div class="space-y-4">
                    <h2 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2">1. Rincian Masalah & Kategori</h2>

                    <div>
                        <label for="judul" class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Laporan Singkat <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="judul"
                            id="judul"
                            value="{{ old('judul', $laporan->judul) }}"
                            required
                            class="w-full px-4 py-2.5 border rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent @error('judul') border-rose-300 bg-rose-50/30 @else border-slate-300 @enderror"
                        >
                        @error('judul')
                            <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kategori_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori Infrastruktur <span class="text-rose-500">*</span></label>
                            <select
                                name="kategori_id"
                                id="kategori_id"
                                required
                                class="w-full px-4 py-2.5 border rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent @error('kategori_id') border-rose-300 bg-rose-50/30 @else border-slate-300 @enderror"
                            >
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $laporan->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }} (Prioritas {{ $kategori->prioritas_label }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="foto_bukti_sebelum" class="block text-sm font-semibold text-slate-700 mb-1.5">Ganti Foto Bukti (Opsional)</label>
                            <input
                                type="file"
                                name="foto_bukti_sebelum"
                                id="foto_bukti_sebelum"
                                accept="image/png,image/jpeg,image/jpg"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-[#1F3A5F] hover:file:bg-slate-200 cursor-pointer"
                            >
                            <p class="text-xs text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah foto sebelumnya.</p>
                            @error('foto_bukti_sebelum')
                                <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi_kondisi" class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Detail Kondisi Lapangan <span class="text-rose-500">*</span></label>
                        <textarea
                            name="deskripsi_kondisi"
                            id="deskripsi_kondisi"
                            rows="3"
                            required
                            class="w-full px-4 py-2.5 border rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent @error('deskripsi_kondisi') border-rose-300 bg-rose-50/30 @else border-slate-300 @enderror"
                        >{{ old('deskripsi_kondisi', $laporan->deskripsi_kondisi) }}</textarea>
                        @error('deskripsi_kondisi')
                            <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Lokasi Wilayah & Peta Geospasial -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h2 class="text-base font-bold text-slate-800">2. Titik Lokasi & Wilayah Administratif</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kecamatan_select" class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih Kecamatan <span class="text-rose-500">*</span></label>
                            <select
                                id="kecamatan_select"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent"
                            >
                                @foreach($kecamatanList as $kec)
                                    <option value="{{ $kec->id }}" {{ $laporan->kelurahan->kecamatan_id == $kec->id ? 'selected' : '' }}>
                                        {{ $kec->nama_kecamatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="kelurahan_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih Kelurahan <span class="text-rose-500">*</span></label>
                            <select
                                name="kelurahan_id"
                                id="kelurahan_id"
                                required
                                class="w-full px-4 py-2.5 border rounded-xl text-sm transition-all focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent @error('kelurahan_id') border-rose-300 bg-rose-50/30 @else border-slate-300 @enderror"
                            >
                                <option value="{{ $laporan->kelurahan_id }}" selected>{{ $laporan->kelurahan->nama_kelurahan }}</option>
                            </select>
                            @error('kelurahan_id')
                                <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Peta Leaflet Interaktif -->
                    <div>
                        <div id="leafletMap" class="w-full h-72 rounded-2xl border border-slate-300 overflow-hidden shadow-inner z-0"></div>
                        <p class="text-[11px] text-slate-400 mt-1.5">Klik pada peta atau seret marker untuk menyesuaikan titik lokasi kerusakan.</p>
                    </div>

                    <!-- Hidden Coordinate Inputs -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Latitude</label>
                            <input
                                type="text"
                                name="latitude"
                                id="latitude"
                                value="{{ old('latitude', $laporan->latitude) }}"
                                readonly
                                class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-mono text-slate-600"
                            >
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Longitude</label>
                            <input
                                type="text"
                                name="longitude"
                                id="longitude"
                                value="{{ old('longitude', $laporan->longitude) }}"
                                readonly
                                class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-mono text-slate-600"
                            >
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('warga.laporan.show', $laporan->id) }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit" dusk="submit-btn" class="px-6 py-2.5 bg-[#0E7C86] hover:bg-[#0b636b] text-white font-bold text-sm rounded-xl transition-all shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Leaflet JS Initialization -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        let map;
        let marker;
        const currentLat = parseFloat(document.getElementById('latitude').value);
        const currentLng = parseFloat(document.getElementById('longitude').value);

        document.addEventListener('DOMContentLoaded', function() {
            map = L.map('leafletMap').setView([currentLat, currentLng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors | INFRA-DAYA'
            }).addTo(map);

            marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                updateCoordinates(pos.lat, pos.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateCoordinates(e.latlng.lat, e.latlng.lng);
            });

            // Chained Dropdown Wilayah
            const kecSelect = document.getElementById('kecamatan_select');
            const kelSelect = document.getElementById('kelurahan_id');

            kecSelect.addEventListener('change', function() {
                const kecId = this.value;
                kelSelect.innerHTML = '<option value="">Memuat kelurahan...</option>';

                fetch(`/api/wilayah/kecamatan/${kecId}/kelurahan`)
                    .then(res => res.json())
                    .then(res => {
                        kelSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                        if (res.data && res.data.length > 0) {
                            res.data.forEach(kel => {
                                const opt = document.createElement('option');
                                opt.value = kel.id;
                                opt.textContent = kel.nama_kelurahan;
                                kelSelect.appendChild(opt);
                            });
                        }
                    });
            });
        });

        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);
        }
    </script>
</x-warga-layout>
