<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Section;
use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Structure des sections et de leurs classes.
     * Maternelle : 1ère, 2ème, 3ème maternelle.
     * Primaire : de la 1ère à la 6ème.
     * Secondaire : 7ème et 8ème (sans le mot "Secondaire").
     * Les autres sections ont 4 classes : 1ère, 2ème, 3ème, 4ème + nom de la section.
     */
    private const SECTIONS = [
        'Maternelle' => ['1ère', '2ème', '3ème'],
        'Primaire' => ['1ère', '2ème', '3ème', '4ème', '5ème', '6ème'],
        'Secondaire' => ['7ème', '8ème'],
        'Électricité générale' => ['1ère', '2ème', '3ème', '4ème'],
        'Mécanique générale' => ['1ère', '2ème', '3ème', '4ème'],
        'Coupe et couture' => ['1ère', '2ème', '3ème', '4ème'],
        'Commercial et gestion' => ['1ère', '2ème', '3ème', '4ème'],
        'Pédagogie' => ['1ère', '2ème', '3ème', '4ème'],
        'Littéraire' => ['1ère', '2ème', '3ème', '4ème'],
        'Biochimie' => ['1ère', '2ème', '3ème', '4ème'],
    ];

    private const SECTION_SECONDAIRE = 'Secondaire';

    /**
     * Frais de scolarité par niveau de classe.
     */
    private const FRAIS = [
        '1ère' => 50000,
        '2ème' => 50000,
        '3ème' => 60000,
        '4ème' => 60000,
        '5ème' => 70000,
        '6ème' => 70000,
        '7ème' => 80000,
        '8ème' => 80000,
    ];

    public function run(): void
    {
        $this->viderAnciennesDonnees();

        $this->creerSectionsEtClasses();
        $this->creerUtilisateurs();
    }

    private function viderAnciennesDonnees(): void
    {
        Schema::disableForeignKeyConstraints();
        Inscription::truncate();
        Eleve::truncate();
        Classe::truncate();
        Section::truncate();
        Schema::enableForeignKeyConstraints();
    }

    private function creerUtilisateurs(): void
    {
        $utilisateurs = [
            [
                'nom' => 'Administrateur',
                'email' => 'admin@mambemba.cd',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'telephone' => '+243 810 000 000',
                'actif' => true,
            ],
            [
                'nom' => 'Gradie Nzundu',
                'email' => 'gradienzundu@gmail.com',
                'password' => Hash::make('gradie123'),
                'role' => 'admin',
                'telephone' => '+243 823 551 245',
                'actif' => true,
            ],
        ];

        foreach ($utilisateurs as $u) {
            Utilisateur::updateOrCreate(
                ['email' => $u['email']],
                $u
            );
        }
    }

    private function creerSectionsEtClasses(): void
    {
        foreach (self::SECTIONS as $nomSection => $niveaux) {
            $section = Section::create([
                'nom' => $nomSection,
                'description' => "Enseignement {$nomSection}",
            ]);

            foreach ($niveaux as $niveau) {
                $nomClasse = $nomSection === self::SECTION_SECONDAIRE
                    ? $niveau
                    : "{$niveau} {$nomSection}";

                Classe::create([
                    'nom' => $nomClasse,
                    'section_id' => $section->id,
                    'frais_scolarite' => self::FRAIS[$niveau] ?? 50000,
                ]);
            }
        }
    }
}