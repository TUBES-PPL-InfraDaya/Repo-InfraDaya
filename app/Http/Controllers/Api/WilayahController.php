<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WilayahService;
use Illuminate\Http\JsonResponse;

class WilayahController extends Controller
{
    public function __construct(protected WilayahService $wilayahService) {}

    /**
     * Endpoint API publik/web untuk dropdown berjenjang kelurahan berdasarkan kecamatan.
     */
    public function kelurahanByKecamatan(int $id): JsonResponse
    {
        $kelurahan = $this->wilayahService->getKelurahanByKecamatan($id);

        return response()->json([
            'success' => true,
            'kecamatan_id' => $id,
            'data' => $kelurahan,
        ]);
    }
}
