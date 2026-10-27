<?php

namespace Tests\Feature;

use App\Models\KategoriInfrastruktur;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\LaporanKerusakan;
use App\Models\RiwayatStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifikasiAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $warga;

    private LaporanKerusakan $laporan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $this->warga = User::factory()->create(['role' => 'warga', 'is_active' => true]);

        $kecamatan = Kecamatan::create([
            'kode_kecamatan' => 'BDG-001',
            'nama_kecamatan' => 'Coblong',
        ]);
        $kelurahan = Kelurahan::create([
            'kecamatan_id' => $kecamatan->id,
            'kode_kelurahan' => 'BDG-001-01',
            'nama_kelurahan' => 'Dago',
        ]);
        $kategori = KategoriInfrastruktur::create([
            'nama_kategori' => 'Jalan Raya',
            'deskripsi' => 'Kerusakan pada jalan raya',
            'bobot_prioritas' => 2,
        ]);

        $this->laporan = LaporanKerusakan::create([
            'nomor_tiket' => 'INFRA-20261013-0001',
            'warga_id' => $this->warga->id,
            'kelurahan_id' => $kelurahan->id,
            'kategori_id' => $kategori->id,
            'judul' => 'Lubang Jalan Dalam di Depan SMP 5',
            'deskripsi_kondisi' => 'Lubang berdiameter sekitar 80cm dan kedalaman 20cm.',
            'latitude' => -6.8975,
            'longitude' => 107.6103,
            'foto_bukti_sebelum' => 'laporan/sebelum/test.jpg',
            'status' => 'menunggu_verifikasi',
            'prioritas' => 'sedang',
        ]);

        RiwayatStatus::create([
            'laporan_id' => $this->laporan->id,
            'user_id' => $this->warga->id,
            'status' => 'menunggu_verifikasi',
            'keterangan' => 'Laporan diajukan oleh pelapor.',
        ]);
    }

    // =========================================================
    // PBI-5.1: Antrean Verifikasi
    // =========================================================

    public function test_admin_dapat_melihat_antrean_verifikasi(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.verifikasi.index'));

        $response->assertStatus(200);
        $response->assertSee('INFRA-20261013-0001');
        $response->assertSee('Lubang Jalan Dalam di Depan SMP 5');
    }

    public function test_warga_tidak_dapat_akses_antrean_verifikasi(): void
    {
        $response = $this->actingAs($this->warga)
            ->get(route('admin.verifikasi.index'));

        $response->assertStatus(403);
    }

    public function test_guest_diarahkan_login_saat_akses_verifikasi(): void
    {
        $response = $this->get(route('admin.verifikasi.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_dapat_filter_laporan_berdasarkan_status(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.verifikasi.index', ['status' => 'menunggu_verifikasi']));

        $response->assertStatus(200);
        $response->assertSee('INFRA-20261013-0001');
    }

    public function test_admin_tidak_lihat_laporan_saat_filter_status_tidak_cocok(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.verifikasi.index', ['status' => 'selesai']));

        $response->assertStatus(200);
        $response->assertDontSee('INFRA-20261013-0001');
    }

    // =========================================================
    // PBI-5.2: Detail Laporan
    // =========================================================

    public function test_admin_dapat_melihat_detail_laporan(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.verifikasi.show', $this->laporan->id));

        $response->assertStatus(200);
        $response->assertSee('INFRA-20261013-0001');
        $response->assertSee('Lubang Jalan Dalam di Depan SMP 5');
        $response->assertSee('Lubang berdiameter sekitar 80cm');
    }

    // =========================================================
    // PBI-5.3: Setujui Laporan
    // =========================================================

    public function test_admin_dapat_menyetujui_laporan_dengan_prioritas_tinggi(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.verifikasi.setujui', $this->laporan->id), [
                'prioritas' => 'tinggi',
                'catatan_verifikator' => 'Segera ditangani karena berpotensi kecelakaan.',
            ]);

        $response->assertRedirect(route('admin.verifikasi.show', $this->laporan->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('laporan_kerusakan', [
            'id' => $this->laporan->id,
            'status' => 'diproses',
            'prioritas' => 'tinggi',
        ]);

        // Cek riwayat status tercatat
        $this->assertDatabaseHas('riwayat_status', [
            'laporan_id' => $this->laporan->id,
            'user_id' => $this->admin->id,
            'status' => 'diproses',
        ]);
    }

    public function test_setujui_gagal_jika_prioritas_tidak_diisi(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.verifikasi.setujui', $this->laporan->id), [
                'prioritas' => '',
            ]);

        $response->assertSessionHasErrors('prioritas');

        $this->assertDatabaseHas('laporan_kerusakan', [
            'id' => $this->laporan->id,
            'status' => 'menunggu_verifikasi', // belum berubah
        ]);
    }

    public function test_setujui_gagal_jika_laporan_sudah_diproses(): void
    {
        // Ubah status laporan menjadi sudah diproses
        $this->laporan->update(['status' => 'diproses']);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.verifikasi.setujui', $this->laporan->id), [
                'prioritas' => 'sedang',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    // =========================================================
    // PBI-5.4: Tolak Laporan
    // =========================================================

    public function test_admin_dapat_menolak_laporan_dengan_alasan(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.verifikasi.tolak', $this->laporan->id), [
                'alasan_penolakan' => 'Foto bukti tidak menunjukkan lokasi yang jelas dan berulang.',
            ]);

        $response->assertRedirect(route('admin.verifikasi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('laporan_kerusakan', [
            'id' => $this->laporan->id,
            'status' => 'ditolak',
            'alasan_penolakan' => 'Foto bukti tidak menunjukkan lokasi yang jelas dan berulang.',
        ]);

        $this->assertDatabaseHas('riwayat_status', [
            'laporan_id' => $this->laporan->id,
            'user_id' => $this->admin->id,
            'status' => 'ditolak',
        ]);
    }

    public function test_tolak_gagal_jika_alasan_kosong(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.verifikasi.tolak', $this->laporan->id), [
                'alasan_penolakan' => '',
            ]);

        $response->assertSessionHasErrors('alasan_penolakan');

        $this->assertDatabaseHas('laporan_kerusakan', [
            'id' => $this->laporan->id,
            'status' => 'menunggu_verifikasi',
        ]);
    }

    public function test_tolak_gagal_jika_alasan_terlalu_pendek(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.verifikasi.tolak', $this->laporan->id), [
                'alasan_penolakan' => 'Salah',
            ]);

        $response->assertSessionHasErrors('alasan_penolakan');
    }

    public function test_warga_tidak_bisa_menolak_laporan(): void
    {
        $response = $this->actingAs($this->warga)
            ->post(route('admin.verifikasi.tolak', $this->laporan->id), [
                'alasan_penolakan' => 'Saya coba tolak laporan sendiri ini tidak valid.',
            ]);

        $response->assertStatus(403);
    }
}
