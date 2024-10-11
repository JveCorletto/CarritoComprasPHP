<?php

namespace App\Http\Controllers\Auth;

use App\Models\Usuarios;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }
    
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'Usuario' => 'required|string|max:255|unique:Usuarios,Usuario',
            'Contrasenia' => 'required|string|confirmed',
        ]);

        $user = Usuarios::create([
            'Nombre' => $request->Nombre,
            'Usuario' => $request->Usuario,
            'Contrasenia' => Hash::make($request->Contrasenia),
            'IdRol' => 3,
            'IdEstado' => 1
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect(route('dashboard', absolute: false));
    }
}