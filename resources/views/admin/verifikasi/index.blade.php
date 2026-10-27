<x-admin-layout title="Antrean Verifikasi Laporan">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-[#0E7C86] mb-1">
                    <span>Admin DSDABM</span>
                    <span>•</span>
                    <span>Fase 5</span>
                </div>
                <h1 class="text-2xl font-extrabold text-[#1F3A5F] tracking-tight">Antrean Verifikasi Laporan</h1>
                <p class="text-sm text-slate-500 mt-1">Tinjau, setujui, atau tolak laporan kerusakan infrastruktur dari warga Kota Bandung.</p>
            </div>
            <div class="flex items-center gap-3 text-sm font-semibold">
                <span class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                    {{ $laporanList->total() }} laporan
                </span>
            </div>
        </div>

        <!-- Flash -->
        <x-flash />

        <!-- Filter Panel -->
        <x-card class="p-4">
            <form method="GET" action="{{ route('admin.verifikasi.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1 uppercase tracking-wide">Cari Laporan</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="No. Tiket / Judul / Pelapor..."
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent"
                    >
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1 uppercase tracking-wide">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="menunggu_verifikasi" {{ $status === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="diproses" {{ $status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1 uppercase tracking-wide">Kategori</label>
                    <select name="kategori_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ (string)$kategoriId === (string)$kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1 uppercase tracking-wide">Kecamatan</label>
                    <select name="kecamatan_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-[#0E7C86] focus:border-transparent">
                        <option value="">Semua Kecamatan</option>
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec->id }}" {{ (string)$kecamatanId === (string)$kec->id ? 'selected' : '' }}>
                                {{ $kec->nama_kecamatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2 lg:col-span-4 flex items-center gap-2">
                    <button type="submit" dusk="btn-filter" class="px-4 py-2 bg-[#1F3A5F] text-white text-xs font-bold rounded-lg hover:bg-[#162a45] transition-colors">
                        Terapkan Filter
                    </button>
                    @if($search || $status || $kategoriId || $kecamatanId)
                        <a href="{{ route('admin.verifikasi.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-200 transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </x-card>

        <!-- Tabel Antrean -->
        @if($laporanList->isEmpty())
            <x-empty-state
                title="Tidak Ada Laporan Ditemukan"
                description="Tidak ada laporan yang cocok dengan filter yang Anda pilih."
            />
        @else
            <x-card class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">No. Tiket</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Laporan</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pelapor</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Lokasi</th>
                                <th class="px-4 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($laporanList as $laporan)
                                <tr class="hover:bg-slate-50/60 transition-colors {{ $laporan->status === 'menunggu_verifikasi' ? 'border-l-2 border-l-amber-400' : '' }}" dusk="laporan-row-{{ $laporan->id }}">
                                    <td class="px-4 py-3">
                                        <span class="font-mono text-xs font-bold text-[#1F3A5F]">{{ $laporan->nomor_tiket }}</span>
                                    </td>
                                    <td class="px-4 py-3 max-w-xs">
                                        <p class="font-semibold text-slate-800 truncate">{{ $laporan->judul }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5 truncate">{{ Str::limit($laporan->deskripsi_kondisi, 60) }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="font-medium text-slate-700">{{ $laporan->warga->name ?? '-' }}</p>
                                        <p class="text-xs text-slate-400">{{ $laporan->warga->email ?? '' }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">
                                            {{ $laporan->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-slate-600">
                                        {{ $laporan->kelurahan->nama_kelurahan ?? '-' }},
                                        {{ $laporan->kelurahan->kecamatan->nama_kecamatan ?? '' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <x-badge-status :status="$laporan->status" />
                                    </td>
                                    <td class="px-4 py-3 text-center text-xs text-slate-500">
                                        {{ $laporan->created_at->format('d M Y') }}
                                        <br>
                                        <span class="text-slate-400">{{ $laporan->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a
                                            href="{{ route('admin.verifikasi.show', $laporan->id) }}"
                                            dusk="btn-detail-{{ $laporan->id }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-[#0E7C86] hover:bg-[#0b636b] rounded-lg transition-colors"
                                        >
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($laporanList->hasPages())
                    <div class="px-4 py-3 border-t border-slate-100">
                        {{ $laporanList->withQueryString()->links() }}
                    </div>
                @endif
            </x-card>
        @endif
    </div>
</x-admin-layout>
