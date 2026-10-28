<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Conocimiento;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Usa transacciones (no RefreshDatabase) para no borrar los datos de la base local.
 */
class AdminPanelTest extends TestCase
{
    use DatabaseTransactions;

    private function admin(): User
    {
        $user = User::factory()->create(['area' => 'Desarrollo']);
        $user->is_admin = true;
        $user->save();

        return $user;
    }

    public function test_invitado_es_redirigido_al_login()
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_usuario_que_no_es_admin_vuelve_al_inicio()
    {
        $user = User::factory()->create(['area' => 'Soporte']);

        foreach (['/admin', '/admin/conocimientos', '/admin/categorias', '/admin/usuarios'] as $url) {
            $this->actingAs($user)->get($url)
                ->assertRedirect('/dashboard')
                ->assertSessionHas('status');
        }
    }

    public function test_admin_entra_al_panel_al_iniciar_sesion()
    {
        $admin = $this->admin();

        $this->post('/login', ['email' => $admin->email, 'password' => 'password'])
            ->assertRedirect('/admin');
    }

    public function test_usuario_normal_entra_al_dashboard_al_iniciar_sesion()
    {
        $user = User::factory()->create(['area' => 'Soporte']);

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/dashboard');
    }

    public function test_admin_con_sesion_que_abre_login_va_al_panel()
    {
        $this->actingAs($this->admin())->get('/login')->assertRedirect('/admin');
    }

    public function test_admin_ve_todas_las_secciones()
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin')->assertOk()->assertSee('Fichas más consultadas');
        $this->actingAs($admin)->get('/admin/conocimientos')->assertOk();
        $this->actingAs($admin)->get('/admin/conocimientos/create')->assertOk();
        $this->actingAs($admin)->get('/admin/categorias')->assertOk();
        $this->actingAs($admin)->get('/admin/categorias/create')->assertOk();
        $this->actingAs($admin)->get('/admin/usuarios')->assertOk();
        $this->actingAs($admin)->get("/admin/usuarios/{$admin->id}/edit")->assertOk();
    }

    public function test_no_se_elimina_una_categoria_con_fichas()
    {
        $admin = $this->admin();
        $categoria = Categoria::create(['nombre' => 'Prueba admin', 'color' => 'red']);
        $ficha = new Conocimiento(['titulo' => 'T', 'problema' => 'P', 'solucion' => 'S', 'categoria_id' => $categoria->id]);
        $ficha->user_id = $admin->id;
        $ficha->save();

        $this->actingAs($admin)->delete("/admin/categorias/{$categoria->id}")->assertSessionHas('error');
        $this->assertModelExists($categoria);
    }

    public function test_admin_no_puede_eliminarse_a_si_mismo()
    {
        $admin = $this->admin();

        $this->actingAs($admin)->delete("/admin/usuarios/{$admin->id}")->assertSessionHas('error');
        $this->assertModelExists($admin);
    }

    public function test_ver_una_ficha_suma_una_consulta_sin_cambiar_updated_at()
    {
        $user = User::factory()->create(['area' => 'Soporte']);
        $categoria = Categoria::create(['nombre' => 'Prueba vistas', 'color' => 'blue']);
        $ficha = new Conocimiento(['titulo' => 'T', 'problema' => 'P', 'solucion' => 'S', 'categoria_id' => $categoria->id]);
        $ficha->user_id = $user->id;
        $ficha->updated_at = now()->subDays(3);
        $ficha->save();
        $antes = $ficha->fresh()->updated_at;

        $this->actingAs($user)->get("/conocimientos/{$ficha->id}")->assertOk()->assertSee('Consultado 1 vez');

        $this->assertSame(1, $ficha->fresh()->vistas);
        $this->assertTrue($ficha->fresh()->updated_at->eq($antes));
    }

    public function test_admin_puede_editar_fichas_de_otros()
    {
        $admin = $this->admin();
        $otro = User::factory()->create(['area' => 'Soporte']);
        $categoria = Categoria::create(['nombre' => 'Prueba policy', 'color' => 'green']);
        $ficha = new Conocimiento(['titulo' => 'T', 'problema' => 'P', 'solucion' => 'S', 'categoria_id' => $categoria->id]);
        $ficha->user_id = $otro->id;
        $ficha->save();

        $this->assertTrue($admin->can('update', $ficha));
        $this->assertTrue($admin->can('delete', $ficha));
        $this->assertFalse(User::factory()->create()->can('update', $ficha));
    }
}
