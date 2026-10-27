<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SetupTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Uji halaman beranda publik INFRA-DAYA menampilkan elemen branding SDG 9 dan instansi DSDABM.
     */
    public function test_welcome_page_renders_with_brand_and_civic_content(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('INFRA-DAYA')
                ->assertSee('SDG 9')
                ->assertSee('DSDABM')
                ->assertSee('Lapor Kerusakan')
                ->assertSee('Lacak Tiket')
                ->assertSee('Jalan Raya & Trotoar');
        });
    }

    /**
     * Uji halaman login dapat diakses dengan antarmuka yang benar.
     */
    public function test_login_page_renders_properly(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Email')
                ->assertSee('Password')
                ->assertPresent('input[type="email"]')
                ->assertPresent('input[type="password"]');
        });
    }

    /**
     * Uji pengguna terotentikasi dapat melihat dashboard dengan layout responsif.
     */
    public function test_authenticated_user_can_access_dashboard(): void
    {
        $uniqueEmail = 'warga.'.uniqid().'@bandung.go.id';
        $user = User::factory()->create([
            'name' => 'Warga Uji Bandung',
            'email' => $uniqueEmail,
            'role' => 'warga',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertTitleContains('Dashboard Warga')
                ->assertSee('Portal Partisipasi Masyarakat')
                ->assertSee('Warga Uji Bandung')
                ->assertSee('Laporan Kerusakan Terbaru Anda');
        });
    }
}
