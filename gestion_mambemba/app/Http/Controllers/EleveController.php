<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Section;
use Illuminate\Http\Request;

class EleveController extends Controller
{
    public function index(Request $request)
    {
        $query = Eleve::with(['inscriptions.classe.section']);

        if ($request->filled('recherche')) {
            $q = $request->recherche;
            $query->where(function ($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('postnom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('matricule', 'like', "%{$q}%");
            });
        }

        if ($request->filled('classe_id')) {
            $query->whereHas('inscriptions', function ($sub) use ($request) {
                $sub->where('classe_id', $request->classe_id);
            });
        }

        if ($request->filled('statut')) {
            $query->whereHas('inscriptions', function ($sub) use ($request) {
                $sub->where('statut', $request->statut);
            });
        }

        $eleves = $query->latest()->get();
        $classes = Classe::with('section')->get();

        return view('liste_eleves', compact('eleves', 'classes'));
    }

    public function update(Request $request, Eleve $eleve)
    {
        $request->validate([
            'matricule' => 'required|string|max:255|unique:eleves,matricule,' . $eleve->id,
            'nom' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'prenom' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
            'statut' => 'required|in:active,inactive',
        ]);

        $eleve->update([
            'matricule' => $request->matricule,
            'nom' => strtoupper($request->nom),
            'prenom' => ucfirst($request->prenom),
            'sexe' => $request->sexe,
        ]);

        $inscription = $eleve->inscriptions()->latest()->first();
        if ($inscription) {
            $inscription->update([
                'classe_id' => $request->classe_id,
                'statut' => $request->statut,
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Élève modifié avec succès.']);
        }

        return redirect()->route('eleves')->with('success', 'Élève modifié avec succès.');
    }

    public function impressionParSection()
    {
        $anneeScolaire = date('Y') . '-' . (date('Y') + 1);

        $inscriptions = Inscription::with(['eleve', 'classe.section'])
            ->where('annee_scolaire', $anneeScolaire)
            ->orderBy('classe_id')
            ->get();

        $sections = Section::with('classes')->orderBy('nom')->get()->map(function ($section) use ($inscriptions) {
            $section->classes = $section->classes->map(function ($classe) use ($inscriptions) {
                $classe->eleves = $inscriptions
                    ->where('classe_id', $classe->id)
                    ->map(fn ($inscription) => $inscription->eleve)
                    ->values();
                return $classe;
            });
            return $section;
        });

        $totalEleves = $inscriptions->count();

        return view('impression_eleves', compact('sections', 'totalEleves', 'anneeScolaire'));
    }

    public function destroy(Eleve $eleve)
    {
        $nom = $eleve->prenom . ' ' . $eleve->nom;
        $eleve->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => "Élève {$nom} supprimé."]);
        }

        return redirect()->route('eleves')->with('success', "Élève {$nom} supprimé.");
    }
}
