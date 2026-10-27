<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KelurahanRequest;
use App\Services\WilayahService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KelurahanController extends Controller
{
    public function __construct(protected WilayahService $wilayahService) {}

    public function index(Request $request): View
    {
        $kecamatanId = $request->query('kecamatan_id') ? (int) $request->query('kecamatan_id') : null;
        $search = $request->query('search');

        $kelurahanList = $this->wilayahService->getPaginatedKelurahan($kecamatanId, $search);
        $kecamatanList = $this->wilayahService->getAllKecamatan();

        return view('admin.wilayah.kelurahan.index', compact('kelurahanList', 'kecamatanList', 'kecamatanId', 'search'));
    }

    public function create(): View
    {
        $kecamatanList = $this->wilayahService->getAllKecamatan();

        return view('admin.wilayah.kelurahan.create', compact('kecamatanList'));
    }

    public function store(KelurahanRequest $request): RedirectResponse
    {
        $this->wilayahService->createKelurahan($request->validated());

        return redirect()
            ->route('admin.kelurahan.index')
            ->with('success', 'Data kelurahan baru berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $kelurahan = $this->wilayahService->findKelurahan($id);
        $kecamatanList = $this->wilayahService->getAllKecamatan();

        return view('admin.wilayah.kelurahan.edit', compact('kelurahan', 'kecamatanList'));
    }

    public function update(KelurahanRequest $request, int $id): RedirectResponse
    {
        $this->wilayahService->updateKelurahan($id, $request->validated());

        return redirect()
            ->route('admin.kelurahan.index')
            ->with('success', 'Data kelurahan berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->wilayahService->deleteKelurahan($id);

        return redirect()
            ->route('admin.kelurahan.index')
            ->with('success', 'Data kelurahan berhasil dihapus.');
    }
}
