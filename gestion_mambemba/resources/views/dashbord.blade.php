@extends('layouts.admin')

@section('title', 'Tableau de bord - Collège MAMBEMBA')
@section('active_dashboard', 'bg-[#163556] text-white')

@section('content')

{{-- Styles personnalisés --}}
<style>
    @keyframes fadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes countUp   { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }
    @keyframes pulse-ring { 0%   { box-shadow: 0 0 0 0 rgba(13,35,58,0.12); }
                           70%  { box-shadow: 0 0 0 12px rgba(13,35,58,0); }
                           100% { box-shadow: 0 0 0 0 rgba(13,35,58,0); } }
    .fade-up   { animation: fadeUp 0.6s ease-out both; }
    .count-up  { animation: countUp 0.5s ease-out both; }
    .delay-1   { animation-delay: 0.1s; }
    .delay-2   { animation-delay: 0.2s; }
    .delay-3   { animation-delay: 0.3s; }
    .delay-4   { animation-delay: 0.4s; }
    .card-hover { transition: transform 0.25s, box-shadow 0.25s; }
    .card-hover:hover { transform: translateY(-6px); box-shadow: 0 12px 28px rgba(13,35,58,0.18); }
</style>

<section class="space-y-8">

    {{-- En-tête dashboard --}}
    <div class="flex items-center justify-between fade-up">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0d233a] tracking-tight">Tableau de bord</h1>
            <p class="text-gray-500 text-sm mt-1">Année scolaire {{ $anneeScolaire }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('inscription') }}" class="inline-flex items-center gap-2 bg-[#0d233a] hover:bg-[#163556] text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-md transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nouvelle Inscription
            </a>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 card-hover fade-up delay-1">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#0d233a] to-[#163556] flex items-center justify-center count-up">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-[#0d233a]">{{ number_format($totalInscriptions) }}</p>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mt-0.5">Inscrits cette année</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 card-hover fade-up delay-2">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center count-up">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-blue-600">{{ $nbSections }}</p>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mt-0.5">Sections</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 card-hover fade-up delay-3">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center count-up">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-emerald-600">{{ $nbClasses }}</p>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mt-0.5">Classes</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 card-hover fade-up delay-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-400 to-amber-500 flex items-center justify-center count-up">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-amber-500">{{ $dernieresInscriptions->count() }}</p>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mt-0.5">Dernières insc.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Diagramme circulaire + Répartition par section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 fade-up delay-2">
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-[#0d233a] mb-6">Répartition par section</h3>
            <div class="flex items-center justify-center">
                <canvas id="sectionPieChart" width="280" height="280"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-[#0d233a] mb-6">Nombre d'inscrits par section</h3>
            <div class="space-y-4">
                @foreach($parSection as $section)
                    @php
                        $pct = $totalInscriptions > 0 ? round(($section->inscriptions_count / $totalInscriptions) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-semibold text-gray-700">{{ $section->nom }}</span>
                            <span class="text-sm font-bold text-[#0d233a]">{{ $section->inscriptions_count }} <span class="font-normal text-gray-400">({{ $pct }}%)</span></span>
                        </div>
                        <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-[#0d233a] to-blue-400 transition-all duration-700 ease-out" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
                @if($totalInscriptions === 0)
                    <p class="text-gray-400 text-sm text-center py-4">Aucune inscription pour le moment.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Dernières inscriptions --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden fade-up delay-3">
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-[#0d233a]">Dernières inscriptions</h3>
            <a href="{{ route('eleves') }}" class="text-sm font-semibold text-[#0d233a] hover:underline no-print">Voir tout →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <th class="px-8 py-3 text-left font-semibold">Élève</th>
                        <th class="px-8 py-3 text-left font-semibold">Classe</th>
                        <th class="px-8 py-3 text-left font-semibold">Date</th>
                        <th class="px-8 py-3 text-left font-semibold">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($dernieresInscriptions as $inscription)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#0d233a] to-[#163556] flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($inscription->eleve->prenom ?? '?', 0, 1) }}{{ substr($inscription->eleve->nom ?? '?', 0, 1) }}
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $inscription->eleve->prenom ?? '?' }} {{ $inscription->eleve->nom ?? '?' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-4 text-gray-600">{{ $inscription->classe->nom ?? '—' }}</td>
                            <td class="px-8 py-4 text-gray-500">{{ $inscription->date_inscription?->format('d/m/Y') ?? '—' }}</td>
                            <td class="px-8 py-4">
                                @if($inscription->statut === 'active')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200">Active</span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">{{ $inscription->statut }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-gray-400">Aucune inscription récente.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>

{{-- Chart.js CDN + initialisation du diagramme --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const data = @json($parSection->map(fn($s) => $s->inscriptions_count)->values());
    const labels = @json($parSection->map(fn($s) => $s->nom)->values());

    if (data.length === 0 || data.every(v => v === 0)) return;

    const palette = [
        '#0d233a', '#1e3a5f', '#2563eb', '#0891b2', '#059669', '#d97706', '#dc2626', '#7c3aed',
    ];

    new Chart(document.getElementById('sectionPieChart'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: palette.slice(0, data.length),
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 10,
            }],
        },
        options: {
            responsive: true,
            cutout: '58%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 14,
                        boxHeight: 14,
                        borderRadius: 4,
                        useBorderRadius: true,
                        padding: 16,
                        font: { size: 12, weight: '600' },
                    },
                },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                            return ' ' + ctx.label + ' : ' + ctx.parsed + ' (' + pct + '%)';
                        }
                    }
                }
            },
            animation: { animateScale: true, animateRotate: true, duration: 1200, easing: 'easeOutQuart' },
        }
    });
});
</script>

@endsection