<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $utilisateur = Utilisateur::where('email', $credentials['email'])->first();

        if ($utilisateur && $utilisateur->actif && Hash::check($credentials['password'], $utilisateur->password)) {
            Auth::login($utilisateur);
            $request->session()->regenerate();

            return redirect()->intended(route('inscription'))
                ->with('success', "Bienvenue, {$utilisateur->nom} !");
        }

        return back()
            ->withErrors(['email' => 'Identifiants invalides ou compte désactivé.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('accueil');
    }
}