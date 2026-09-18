<?php

namespace Tests\Feature;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Section;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InscriptionTest extends TestCase
{
    use RefreshDatabase;

    private function login(): void
    {
        Utilisateur::create([
            'nom' => 'Admin',
            'email' => 'admin@mambemba.cd',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
            'actif' => true,
        ]);
        $this->post('/login', ['email' => 'admin@mambemba.cd', 'password' => 'secret123']);
    }

    private function creerClasse(): Classe
    {
        return Classe::create([
            'nom' => '1ère Primaire',
            'section_id' => Section::create(['nom' => 'Primaire', 'description' => 'Test'])->id,
            'frais_scolarite' => 60000,
        ]);
    }

    private function donneesEleve(array $overrides = []): array
    {
        return array_merge([
            'nom' => 'KABILA',
            'postnom' => 'MBAYO',
            'prenom' => 'Jean',
            'sexe' => 'M',
            'date_naissance' => '2015-03-12',
            'lieu_naissance' => 'Kinshasa',
            'classe_id' => $this->creerClasse()->id,
            'parent_nom' => 'KABILA',
            'parent_postnom' => 'MBAYO',
            'parent_prenom' => 'Pierre',
            'parent_profession' => 'Ingénieur',
            'parent_telephone' => '+243 812 345 678',
            'parent_adresse' => 'Kimbanseke, Kinshasa',
        ], $overrides);
    }

    /** Scénario 3 : enregistrement d'un élève complet → élève enregistré + inscription créée */
    public function test_enregistrement_eleve_complet(): void
    {
        $this->login();
        $response = $this->post('/inscription', $this->donneesEleve());

        $response->assertRedirect('/eleves');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('eleves', [
            'nom' => 'KABILA',
            'prenom' => 'Jean',
            'matricule' => 'MB-' . date('Y') . '-001',
        ]);

        $this->assertDatabaseHas('eleves', ['nom' => 'KABILA', 'parent_nom' => 'KABILA', 'parent_telephone' => '+243 812 345 678']);

        $this->assertDatabaseHas('inscriptions', [
            'eleve_id' => Eleve::first()->id,
            'annee_scolaire' => date('Y') . '-' . (date('Y') + 1),
            'statut' => 'active',
        ]);
    }

    /** Scénario 4 : double inscription (même élève, même année) → rejet + message d'erreur */
    public function test_double_inscription_meme_eleve_meme_annee_refusee(): void
    {
        $this->login();

        // Première inscription
        $this->post('/inscription', $this->donneesEleve());
        $eleve = Eleve::first();

        $this->assertDatabaseCount('inscriptions', 1);

        // Seconde tentative : mêmes nom, postnom, prénom et date de naissance
        $response = $this->post('/inscription', $this->donneesEleve());

        $response->assertSessionHasErrors('doublon');
        $this->assertDatabaseCount('inscriptions', 1);
        $this->assertDatabaseCount('eleves', 1);
    }

    /** Scénario 4 bis : réinscription la même année non autorisée, mais possible une autre année */
    public function test_reinscription_annee_suivante_permise(): void
    {
        $this->login();

        $this->post('/inscription', $this->donneesEleve());
        $eleve = Eleve::first();

        Inscription::where('eleve_id', $eleve->id)->update(['annee_scolaire' => '2025-2026']);

        $response = $this->post('/inscription', $this->donneesEleve());

        $response->assertRedirect('/eleves');
        $this->assertDatabaseCount('inscriptions', 2);
        $this->assertDatabaseCount('eleves', 1);
    }
}