<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.usuarios.index', [
            'usuarios' => User::withCount('conocimientos')->orderBy('name')->paginate(15),
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.usuarios.edit', ['user' => $user]);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->safe()->only(['name', 'area']));

        // Un administrador no puede quitarse a sí mismo el rol (se quedaría sin acceso al panel)
        if (! $user->is($request->user())) {
            $user->is_admin = $request->boolean('is_admin');
        }

        $user->save();

        return redirect()->route('admin.usuarios.index')->with('status', "Usuario {$user->name} actualizado.");
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta desde el panel de administración.');
        }

        // Sus fichas se eliminan en cascada (llave foránea user_id)
        $user->delete();

        return redirect()->route('admin.usuarios.index')->with('status', "Usuario {$user->name} eliminado.");
    }
}
