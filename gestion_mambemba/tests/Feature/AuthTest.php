<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private function creerUtilisateur(string $role = 'admin', bool $actif = true): Utilisateur
    {
        return Utilisateur::create([
            'nom' => 'Administrateur',
            'email' => 'admin@mambemba.cd',
            'password' => Hash::make('secret123'),
            'role' => $role,
            'telephone' => '+243 810 000 000',
            'actif' => $actif,
        ]);
    }

    /** Scénario 1 : connexion avec identifiants valides → accès au tableau de bord */
    public function test_connexion_avec_identifiants_valides_accede_au_dashboard(): void
    {
        $this->creerUtilisateur();

        $response = $this->post('/login', [
            'email' => 'admin@mambemba.cd',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/inscription');
        $this->assertAuthenticated();
        $this->get('/inscription')->assertOk();
    }

    /** Scénario 2 : connexion avec identifiants invalides → message d'erreur, accès refusé */
    public function test_connexion_avec_identifiants_invalides_refusee(): void
    {
        $this->creerUtilisateur();

        $response = $this->post('/login', [
            'email' => 'admin@mambemba.cd',
            'password' => 'mauvais-mot-de-passe',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();

        // /inscription est le seul flux protégé → accès refusé sans auth
        $this->get('/inscription')->assertRedirect('/login');
    }

    /** Scénario 2 bis : compte désactivé → accès refusé */
    public function test_connexion_compte_desactive_refusee(): void
    {
        $this->creerUtilisateur(actif: false);

        $response = $this->post('/login', [
            'email' => 'admin@mambemba.cd',
            'password' => 'secret123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}