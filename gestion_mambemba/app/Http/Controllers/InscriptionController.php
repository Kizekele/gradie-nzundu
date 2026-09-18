<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InscriptionController extends Controller
{
    public function create()
    {
        $sections = Section::with('classes')->get();
        return view('inscription', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'postnom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
            'parent_nom' => 'required|string|max:255',
            'parent_postnom' => 'required|string|max:255',
            'parent_prenom' => 'required|string|max:255',
            'parent_profession' => 'nullable|string|max:255',
            'parent_telephone' => 'required|string|max:255',
            'parent_adresse' => 'nullable|string|max:255',
        ]);

        $annee = date('Y');
        $anneeScolaire = $annee . '-' . ($annee + 1);

        $existingEleve = Eleve::where('nom', strtoupper($request->nom))
            ->where('postnom', strtoupper($request->postnom))
            ->where('prenom', ucfirst($request->prenom))
            ->whereDate('date_naissance', $request->date_naissance)
            ->first();

        if ($existingEleve) {
            $doublon = Inscription::where('eleve_id', $existingEleve->id)
                ->where('annee_scolaire', $anneeScolaire)
                ->exists();

            if ($doublon) {
                return back()
                    ->withErrors(['doublon' => "Cet élève est déjà inscrit pour l'année scolaire {$anneeScolaire}. Double inscription refusée."])
                    ->withInput();
            }

            $eleve = $existingEleve;
        } else {
            $count = Eleve::where('matricule', 'like', "MB-{$annee}-%")->count() + 1;
            $matricule = sprintf('MB-%s-%03d', $annee, $count);

            $eleve = Eleve::create([
                'matricule' => $matricule,
                'nom' => strtoupper($request->nom),
                'postnom' => strtoupper($request->postnom),
                'prenom' => ucfirst($request->prenom),
                'sexe' => $request->sexe,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
                'parent_nom' => strtoupper($request->parent_nom),
                'parent_postnom' => strtoupper($request->parent_postnom),
                'parent_prenom' => ucfirst($request->parent_prenom),
                'parent_sexe' => $request->input('parent_sexe', 'M'),
                'parent_profession' => $request->parent_profession ?? null,
                'parent_telephone' => $request->parent_telephone,
                'parent_email' => $request->parent_email ?? null,
                'parent_adresse' => $request->parent_adresse ?? null,
            ]);
        }

        Inscription::create([
            'eleve_id' => $eleve->id,
            'classe_id' => $request->classe_id,
            'annee_scolaire' => $annee . '-' . ($annee + 1),
            'date_inscription' => now(),
            'statut' => 'active',
        ]);

        return redirect()->route('eleves')->with('success', "Élève {$eleve->prenom} {$eleve->nom} inscrit avec succès. Matricule: {$eleve->matricule}");
    }
}
