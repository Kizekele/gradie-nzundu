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

class EleveSearchTest extends TestCase
{
    use RefreshDatabase;

    private function connexion(): void
    {
        Utilisateur::create([
            'nom' => 'Admin',
            'email' => 'admin@mambemba.cd',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
            'actif' => true,
        ]);

        $this->post('/login', ['email' => 'admin@mambemba.cd', 'password' => 'secret123']);
        $this->assertAuthenticated();
    }

    private function creerEleve(string $nom, string $prenom, Classe $classe, string $matricule): Eleve
    {
        $eleve = Eleve::create([
            'matricule' => $matricule,
            'nom' => $nom,
            'postnom' => 'MBAYO',
            'prenom' => $prenom,
            'sexe' => 'M',
            'date_naissance' => '2015-01-01',
            'lieu_naissance' => 'Kinshasa',
            'parent_nom' => $nom,
            'parent_postnom' => 'X',
            'parent_prenom' => 'Parent',
            'parent_sexe' => 'M',
            'parent_telephone' => '+243 000 000 000',
        ]);
        Inscription::create([
            'eleve_id' => $eleve->id,
            'classe_id' => $classe->id,
            'annee_scolaire' => date('Y') . '-' . (date('Y') + 1),
            'date_inscription' => now(),
            'statut' => 'active',
        ]);

        return $eleve;
    }

    private function creerClasse(string $nom): Classe
    {
        $section = Section::create(['nom' => 'Primaire', 'description' => 'Test']);

        return Classe::create(['nom' => $nom, 'section_id' => $section->id, 'frais_scolarite' => 60000]);
    }

    /** Scénario 6 : recherche d'un élève par nom → résultat correspondant affiché */
    public function test_recherche_eleve_par_nom_affiche_le_resultat(): void
    {
        $this->connexion();
        $classe = $this->creerClasse('1ère Primaire');
        $this->creerEleve('KIZABA', 'Marie', $classe, 'MB-2026-001');
        $this->creerEleve('ILUNGA', 'Paul', $classe, 'MB-2026-002');

        $response = $this->get('/eleves?recherche=ILUNGA');

        $response->assertOk();
        $response->assertSee('ILUNGA');
        $response->assertDontSee('KIZABA');
    }

    /** Scénario 7 : génération de la liste des élèves par classe → liste correcte affichée */
    public function test_liste_eleves_par_classe_filtree_correctement(): void
    {
        $this->connexion();
        $classe1 = $this->creerClasse('1ère Primaire');
        $classe2 = $this->creerClasse('2ème Primaire');
        $this->creerEleve('KIZABA', 'Marie', $classe1, 'MB-2026-001');
        $this->creerEleve('ILUNGA', 'Paul', $classe1, 'MB-2026-002');
        $this->creerEleve('MWAMBA', 'Alice', $classe2, 'MB-2026-003');

        // Filtre sur la classe 1
        $response = $this->get('/eleves?classe_id=' . $classe1->id);

        $response->assertOk();
        $response->assertSee('KIZABA');
        $response->assertSee('ILUNGA');
        $response->assertDontSee('MWAMBA');

        // Filtre sur la classe 2
        $response2 = $this->get('/eleves?classe_id=' . $classe2->id);

        $response2->assertOk();
        $response2->assertSee('MWAMBA');
        $response2->assertDontSee('KIZABA');
    }
}