<x-admin-layout title="Detail & Verifikasi Laporan">
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Back Button & Header -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.verifikasi.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 font-medium transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Antrean
                </a>
                <span class="text-slate-300">|</span>
                <span class="font-mono text-sm font-bold text-[#1F3A5F]">{{ $laporan->nomor_tiket }}</span>
            </div>
            <x-badge-status :status="$laporan->status" />
        </div>

        <!-- Flash -->
        <x-flash />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Detail Laporan -->
            <div class="lg:col-span-2 space-y-5">

                <!-- Kartu Detail Laporan -->
                <x-card class="p-6 space-y-5">
                    <h2 class="text-lg font-bold text-[#1F3A5F]">{{ $laporan->judul }}</h2>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-0.5">Pelapor</p>
                            <p class="font-semibold text-slate-800">{{ $laporan->warga->name ?? '-' }}</p>
                            <p class="text-slate-500 text-xs">{{ $laporan->warga->email ?? '' }}</p>
                            <p class="text-slate-500 text-xs">{{ $laporan->warga->phone ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-0.5">Tanggal Laporan</p>
                            <p class="font-semibold text-slate-800">{{ $laporan->created_at->format('d F Y') }}</p>
                            <p class="text-slate-500 text-xs">Pukul {{ $laporan->created_at->format('H:i') }} WIB</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-0.5">Kategori Infrastruktur</p>
                            <p class="font-semibold text-slate-800">{{ $laporan->kategori->nama_kategori ?? '-' }}</p>
                            <p class="text-xs text-slate-500">Prioritas Default: {{ ucfirst($laporan->kategori->prioritas_label ?? '') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-0.5">Lokasi Wilayah</p>
                            <p class="font-semibold text-slate-800">Kel. {{ $laporan->kelurahan->nama_kelurahan ?? '-' }}</p>
                            <p class="text-xs text-slate-500">Kec. {{ $laporan->kelurahan->kecamatan->nama_kecamatan ?? '' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">Deskripsi Kondisi Lapangan</p>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $laporan->deskripsi_kondisi }}</div>
                    </div>

                    <!-- Koordinat -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Latitude</p>
                            <p class="font-mono text-sm text-slate-700">{{ number_format($laporan->latitude, 8) }}</p>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Longitude</p>
                            <p class="font-mono text-sm text-slate-700">{{ number_format($laporan->longitude, 8) }}</p>
                        </div>
                    </div>

                    @if($laporan->alasan_penolakan)
                        <div class="bg-rose-50 border border-rose-200 rounded-xl p-4">
                            <p class="text-xs font-bold text-rose-700 uppercase tracking-wide mb-1">Alasan Penolakan</p>
                            <p class="text-sm text-rose-800">{{ $laporan->alasan_penolakan }}</p>
                        </div>
                    @endif
                </x-card>

                <!-- Foto Bukti -->
                @if($laporan->foto_bukti_sebelum)
                    <x-card class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-bold text-slate-700">Foto Bukti Kondisi Kerusakan</h3>
                            <a href="{{ asset('storage/' . $laporan->foto_bukti_sebelum) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-800">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Buka Ukuran Penuh</span>
                            </a>
                        </div>
                        <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-100 relative group cursor-zoom-in">
                            <a href="{{ asset('storage/' . $laporan->foto_bukti_sebelum) }}" target="_blank" rel="noopener noreferrer" class="block">
                                <img
                                    src="{{ asset('storage/' . $laporan->foto_bukti_sebelum) }}"
                                    alt="Foto bukti kerusakan laporan {{ $laporan->nomor_tiket }}"
                                    class="w-full object-cover max-h-96 transition-transform duration-300 group-hover:scale-102"
                                    dusk="foto-bukti"
                                >
                                <div class="absolute inset-0 bg-slate-900/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-black/75 text-white text-xs font-semibold backdrop-blur-sm shadow-md">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                        Klik untuk Perbesar Foto
                                    </span>
                                </div>
                            </a>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-2">Foto kondisi sebelum penanganan diunggah oleh pelapor. Klik untuk melihat dalam resolusi asli.</p>
                    </x-card>
                @endif

                <!-- Peta Lokasi -->
                <x-card class="p-5">
                    <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#0E7C86]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Titik Lokasi Kerusakan (Peta)
                    </h3>
                    <div id="detailMap" class="w-full h-64 rounded-xl border border-slate-200 overflow-hidden"></div>
                    <a
                        href="https://www.google.com/maps?q={{ $laporan->latitude }},{{ $laporan->longitude }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-2 inline-flex items-center gap-1.5 text-xs text-[#0E7C86] hover:underline font-medium"
                    >
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Buka di Google Maps
                    </a>
                </x-card>

                <!-- Riwayat Status -->
                <x-card class="p-5">
                    <h3 class="text-sm font-bold text-slate-700 mb-4">Riwayat Perubahan Status</h3>
                    <div class="relative space-y-0">
                        @foreach($laporan->riwayatStatus as $riwayat)
                            <div class="flex gap-3 pb-4 relative" dusk="riwayat-{{ $loop->iteration }}">
                                <div class="flex flex-col items-center">
                                    <div class="h-8 w-8 rounded-full bg-[#0E7C86]/10 border-2 border-[#0E7C86]/30 flex items-center justify-center flex-shrink-0">
                                        <svg class="h-3.5 w-3.5 text-[#0E7C86]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    @if(!$loop->last)
                                        <div class="w-px flex-1 bg-slate-200 mt-1"></div>
                                    @endif
                                </div>
                                <div class="pt-1 pb-2 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                        <x-badge-status :status="$riwayat->status" />
                                        <span class="text-xs text-slate-400">{{ $riwayat->created_at->format('d M Y, H:i') }} WIB</span>
                                    </div>
                                    <p class="text-sm text-slate-700">{{ $riwayat->keterangan }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">oleh: {{ $riwayat->user->name ?? 'Sistem' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            </div>

            <!-- Kolom Kanan: Panel Aksi Verifikasi -->
            <div class="space-y-5">

                <!-- Info Prioritas Saat Ini -->
                <x-card class="p-5">
                    <h3 class="text-sm font-bold text-slate-700 mb-3">Status & Prioritas</h3>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Status Saat Ini</span>
                            <x-badge-status :status="$laporan->status" />
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Prioritas</span>
                            @php
                                $prioClass = match($laporan->prioritas) {
                                    'tinggi' => 'bg-rose-100 text-rose-800 border-rose-300',
                                    'sedang' => 'bg-amber-100 text-amber-800 border-amber-300',
                                    default  => 'bg-sky-100 text-sky-800 border-sky-300',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $prioClass }}">
                                {{ ucfirst($laporan->prioritas ?? 'sedang') }}
                            </span>
                        </div>
                    </div>
                </x-card>

                @if($laporan->status === 'menunggu_verifikasi')
                    <!-- Form Setujui -->
                    <x-card class="p-5 border-l-4 border-l-emerald-500">
                        <h3 class="text-sm font-bold text-emerald-800 mb-3 flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Setujui & Tetapkan Prioritas
                        </h3>
                        <form method="POST" action="{{ route('admin.verifikasi.setujui', $laporan->id) }}" class="space-y-3">
                            @csrf
                            <div>
                                <label for="prioritas" class="block text-xs font-semibold text-slate-700 mb-1">Tingkat Prioritas <span class="text-rose-500">*</span></label>
                                <select
                                    name="prioritas"
                                    id="prioritas"
                                    required
                                    dusk="select-prioritas"
                                    class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('prioritas') border-rose-300 @else border-slate-300 @enderror"
                                >
                                    <option value="">Pilih Prioritas...</option>
                                    <option value="tinggi" {{ old('prioritas') === 'tinggi' ? 'selected' : '' }}>🔴 Tinggi — Bahaya Langsung</option>
                                    <option value="sedang" {{ old('prioritas') === 'sedang' ? 'selected' : '' }}>🟡 Sedang — Perlu Segera</option>
                                    <option value="rendah" {{ old('prioritas') === 'rendah' ? 'selected' : '' }}>🔵 Rendah — Terjadwal</option>
                                </select>
                                @error('prioritas')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="catatan_verifikator" class="block text-xs font-semibold text-slate-700 mb-1">Catatan Verifikator <span class="text-slate-400">(opsional)</span></label>
                                <textarea
                                    name="catatan_verifikator"
                                    id="catatan_verifikator"
                                    rows="3"
                                    dusk="textarea-catatan"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    placeholder="Instruksi teknis, rekomendasi, atau catatan khusus..."
                                >{{ old('catatan_verifikator') }}</textarea>
                                @error('catatan_verifikator')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <button
                                type="submit"
                                dusk="btn-setujui"
                                onclick="return confirm('Setujui laporan {{ $laporan->nomor_tiket }} dan jadwalkan penanganan?')"
                                class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg transition-colors flex items-center justify-center gap-2"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Setujui Laporan
                            </button>
                        </form>
                    </x-card>

                    <!-- Form Tolak -->
                    <x-card class="p-5 border-l-4 border-l-rose-500">
                        <h3 class="text-sm font-bold text-rose-800 mb-3 flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Tolak dengan Alasan
                        </h3>
                        <form method="POST" action="{{ route('admin.verifikasi.tolak', $laporan->id) }}" class="space-y-3">
                            @csrf
                            <div>
                                <label for="alasan_penolakan" class="block text-xs font-semibold text-slate-700 mb-1">Alasan Penolakan <span class="text-rose-500">*</span></label>
                                <textarea
                                    name="alasan_penolakan"
                                    id="alasan_penolakan"
                                    rows="4"
                                    required
                                    dusk="textarea-alasan"
                                    class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-transparent @error('alasan_penolakan') border-rose-300 @else border-slate-300 @enderror"
                                    placeholder="Contoh: Foto bukti tidak relevan, lokasi di luar kewenangan DSDABM, laporan duplikat dengan tiket INFRA-..."
                                >{{ old('alasan_penolakan') }}</textarea>
                                @error('alasan_penolakan')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-[11px] text-slate-400 mt-1">Minimal 10 karakter. Alasan ini akan tampil di halaman detail laporan warga.</p>
                            </div>
                            <button
                                type="submit"
                                dusk="btn-tolak"
                                onclick="return confirm('Tolak laporan {{ $laporan->nomor_tiket }}? Tindakan ini tidak dapat dibatalkan.')"
                                class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold rounded-lg transition-colors flex items-center justify-center gap-2"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Tolak Laporan
                            </button>
                        </form>
                    </x-card>
                @elseif($laporan->status === 'diproses')
                    @if($laporan->disposisi)
                        <x-card class="p-5 space-y-4 border-l-4 border-l-sky-500">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status Penugasan Petugas</span>
                                <x-badge-status :status="$laporan->disposisi->status_penugasan" />
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Surat Tugas (SPT)</p>
                                <p class="font-mono text-sm font-extrabold text-[#1F3A5F]">{{ $laporan->disposisi->nomor_surat_tugas }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Petugas Ditugaskan</p>
                                <p class="font-bold text-sm text-slate-800">{{ $laporan->disposisi->petugas->name }}</p>
                                <p class="text-xs text-slate-500">{{ $laporan->disposisi->petugas->phone ?: $laporan->disposisi->petugas->email }}</p>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-lg text-xs">
                                <span class="text-slate-400 block mb-0.5">Tenggat Waktu:</span>
                                <span class="font-semibold text-slate-700">{{ $laporan->disposisi->tenggat_waktu->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                                <a
                                    href="{{ route('admin.disposisi.show', $laporan->disposisi->id) }}"
                                    class="flex-1 py-2 text-center text-xs font-bold text-white bg-[#1F3A5F] hover:bg-[#162a45] rounded-lg transition"
                                >
                                    Detail SPT
                                </a>
                                <a
                                    href="{{ route('admin.disposisi.pdf', $laporan->disposisi->id) }}"
                                    target="_blank"
                                    class="px-3 py-2 text-center text-xs font-bold text-[#0E7C86] bg-[#0E7C86]/10 hover:bg-[#0E7C86]/20 rounded-lg transition"
                                >
                                    PDF
                                </a>
                            </div>
                        </x-card>
                    @else
                        <x-card class="p-5 space-y-3.5 border-l-4 border-l-amber-500 bg-amber-50/20">
                            <div class="flex items-center gap-2 text-amber-700 font-bold text-xs uppercase tracking-wider">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span>Menunggu Penugasan</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Laporan telah disetujui. Segera terbitkan Surat Perintah Tugas (SPT) agar petugas teknis dapat menangani lokasi ini.
                            </p>
                            <a
                                href="{{ route('admin.disposisi.create', ['laporan_id' => $laporan->id]) }}"
                                dusk="btn-tugaskan-laporan"
                                class="w-full py-2.5 bg-[#0E7C86] hover:bg-[#0b636b] text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Tugaskan Petugas (SPT)</span>
                            </a>
                        </x-card>
                    @endif
                @else
                    <x-card class="p-5">
                        <div class="text-center text-sm text-slate-500 py-4">
                            <svg class="h-10 w-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            <p class="font-medium text-slate-600">Laporan ini sudah {{ $laporan->status === 'ditolak' ? 'ditolak' : 'selesai' }}.</p>
                            <p class="text-xs mt-1">Status saat ini: <strong>{{ ucwords(str_replace('_', ' ', $laporan->status)) }}</strong></p>
                        </div>
                    </x-card>
                @endif

            </div>
        </div>
    </div>

    <!-- Leaflet Map Init -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lat = {{ (float) $laporan->latitude }};
            const lng = {{ (float) $laporan->longitude }};

            const map = L.map('detailMap').setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors | INFRA-DAYA'
            }).addTo(map);

            const redIcon = L.divIcon({
                className: '',
                html: '<div style="width:16px;height:16px;background:#E53E3E;border:3px solid white;border-radius:50%;box-shadow:0 2px 8px rgba(229,62,62,0.6)"></div>',
                iconSize: [16, 16],
                iconAnchor: [8, 8],
            });

            const popupContent = document.createElement('div');
            const strong = document.createElement('strong');
            strong.textContent = @js($laporan->judul);
            popupContent.appendChild(strong);
            popupContent.appendChild(document.createElement('br'));
            const small = document.createElement('small');
            small.textContent = @js(($laporan->kelurahan->nama_kelurahan ?? '') . ', ' . ($laporan->kelurahan->kecamatan->nama_kecamatan ?? ''));
            popupContent.appendChild(small);

            L.marker([lat, lng], { icon: redIcon })
                .addTo(map)
                .bindPopup(popupContent)
                .openPopup();
        });
    </script>
</x-admin-layout>
