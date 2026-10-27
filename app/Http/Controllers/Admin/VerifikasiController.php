<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VerifikasiRequest;
use App\Models\KategoriInfrastruktur;
use App\Services\LaporanService;
use App\Services\WilayahService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifikasiController extends Controller
{
    public function __construct(
        protected LaporanService $laporanService,
        protected WilayahService $wilayahService,
    ) {}

    /**
     * Antrean verifikasi laporan masuk.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $kategoriId = $request->query('kategori_id');
        $kecamatanId = $request->query('kecamatan_id');

        $laporanList = $this->laporanService->getPaginatedLaporanAdmin($search, $status, $kategoriId, $kecamatanId);
        $kategoriList = KategoriInfrastruktur::orderBy('nama_kategori')->get();
        $kecamatanList = $this->wilayahService->getAllKecamatan();

        return view('admin.verifikasi.index', compact(
            'laporanList', 'kategoriList', 'kecamatanList',
            'search', 'status', 'kategoriId', 'kecamatanId'
        ));
    }

    /**
     * Halaman detail laporan & form aksi verifikasi.
     */
    public function show(int $id): View
    {
        $laporan = $this->laporanService->findLaporan($id);

        return view('admin.verifikasi.show', compact('laporan'));
    }

    /**
     * Setujui laporan & tetapkan prioritas.
     */
    public function setujui(VerifikasiRequest $request, int $id): RedirectResponse
    {
        try {
            $laporan = $this->laporanService->setujuiLaporan(
                $id,
                auth()->id(),
                $request->validated('prioritas'),
                $request->validated('catatan_verifikator'),
            );

            return redirect()
                ->route('admin.verifikasi.show', $id)
                ->with('success', "Laporan {$laporan->nomor_tiket} berhasil disetujui dengan prioritas ".ucfirst($request->validated('prioritas')).'.');
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Tolak laporan dengan alasan wajib.
     */
    public function tolak(VerifikasiRequest $request, int $id): RedirectResponse
    {
        try {
            $laporan = $this->laporanService->tolakLaporan(
                $id,
                auth()->id(),
                $request->validated('alasan_penolakan'),
            );

            return redirect()
                ->route('admin.verifikasi.index')
                ->with('success', "Laporan {$laporan->nomor_tiket} berhasil ditolak dan warga akan diberitahukan.");
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
