<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Section;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $anneeScolaire = date('Y') . '-' . (date('Y') + 1);

        $totalInscriptions = Inscription::where('annee_scolaire', $anneeScolaire)->count();

        $parSection = Section::withCount(['inscriptions' => function ($q) use ($anneeScolaire) {
            $q->where('annee_scolaire', $anneeScolaire);
        }])->orderByDesc('inscriptions_count')->get();

        $dernieresInscriptions = Inscription::with(['eleve', 'classe'])
            ->where('annee_scolaire', $anneeScolaire)
            ->latest()
            ->take(5)
            ->get();

        $nbSections = Section::count();
        $nbClasses = Classe::count();

        return view('dashbord', compact(
            'totalInscriptions',
            'parSection',
            'dernieresInscriptions',
            'nbSections',
            'nbClasses',
            'anneeScolaire',
        ));
    }
}