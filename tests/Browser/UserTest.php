<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Fase 2: Pengujian E2E User & Role Management (Admin).
 */
class UserTest extends DuskTestCase
{
    use DatabaseMigrations;

    private function loginAsAdmin(Browser $browser): User
    {
        $admin = User::factory()->create([
            'email' => 'admin.test.'.uniqid().'@dsdabm.bandung.go.id',
            'role' => 'admin',
        ]);
        $browser->loginAs($admin);

        return $admin;
    }

    /**
     * Admin dapat melihat halaman kelola pengguna.
     */
    public function test_admin_can_view_user_index(): void
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsAdmin($browser);

            $browser->visit(route('admin.users.index'))
                ->assertSee('Kelola Pengguna')
                ->assertPresent('table');
        });
    }

    /**
     * Admin dapat menambahkan pengguna baru (petugas).
     */
    public function test_admin_can_create_new_user(): void
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsAdmin($browser);

            $uniqueEmail = 'petugas.'.uniqid().'@dsdabm.bandung.go.id';

            $browser->visit(route('admin.users.create'))
                ->type('name', 'Petugas Uji Coba')
                ->type('email', $uniqueEmail)
                ->type('phone', '081233445566')
                ->select('role', 'petugas')
                ->type('password', 'password123')
                ->type('password_confirmation', 'password123')
                ->click('@submit-btn')
                ->waitForLocation('/admin/users')
                ->assertSee('berhasil ditambahkan')
                ->assertSee('Petugas Uji Coba');
        });
    }

    /**
     * Validasi: nama dan email wajib diisi.
     */
    public function test_user_creation_requires_mandatory_fields(): void
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsAdmin($browser);

            $browser->visit(route('admin.users.create'))
                ->click('@submit-btn')
                ->assertPathIs('/admin/users/create');
        });
    }

    /**
     * Admin dapat mengubah data pengguna.
     */
    public function test_admin_can_edit_user(): void
    {
        $user = User::factory()->create([
            'name' => 'User Lama',
            'email' => 'user.edit.'.uniqid().'@test.com',
            'role' => 'petugas',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $this->loginAsAdmin($browser);

            $browser->visit(route('admin.users.edit', $user->id))
                ->clear('name')
                ->type('name', 'User Diedit')
                ->click('@submit-btn')
                ->waitForLocation('/admin/users')
                ->assertSee('berhasil diperbarui')
                ->assertSee('User Diedit');
        });
    }

    /**
     * Non-admin (warga) dilarang mengakses manajemen pengguna (403).
     */
    public function test_non_admin_cannot_access_user_management(): void
    {
        $warga = User::factory()->create([
            'email' => 'warga.block.'.uniqid().'@test.com',
            'role' => 'warga',
        ]);

        $this->browse(function (Browser $browser) use ($warga) {
            $browser->loginAs($warga)
                ->visit(route('admin.users.index'))
                ->assertSee('403');
        });
    }
}
