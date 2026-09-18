{{-- Liste des élèves inscrits au collège --}}
@extends('layouts.admin')

@section('title', 'Liste des Élèves - Collège MAMBEMBA')

@section('active_eleves', 'bg-[#163556] text-white')

@section('content')
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-md mb-6" id="flashSuccess">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold text-[#0d233a]">Liste des Élèves</h1>
                <a href="{{ route('inscription') }}" class="px-5 py-2.5 bg-[#0d233a] hover:bg-[#163556] text-white rounded-md text-sm font-medium transition shadow-md flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Nouvelle Inscription</span>
                </a>
            </div>

            {{-- Barre de recherche et filtres --}}
            <form method="GET" action="{{ route('eleves') }}" class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 mb-6 flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-1 relative">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="recherche" value="{{ request('recherche') }}" placeholder="Rechercher par nom, prénom ou matricule..." class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-400 rounded-md text-sm focus:outline-none focus:border-[#0d233a]">
                </div>
                <div class="flex items-center gap-3">
                    <select name="classe_id" class="bg-gray-50 border border-gray-400 rounded-md px-3 py-2.5 text-sm text-gray-600 focus:outline-none focus:border-[#0d233a]">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                    <select name="statut" class="bg-gray-50 border border-gray-400 rounded-md px-3 py-2.5 text-sm text-gray-600 focus:outline-none focus:border-[#0d233a]">
                        <option value="">Tous statuts</option>
                        <option value="active" {{ request('statut') == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ request('statut') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    <button type="submit" class="px-4 py-2.5 bg-[#0d233a] text-white rounded-md text-sm font-medium hover:bg-[#163556] transition">Filtrer</button>
                </div>
            </form>

            {{-- Tableau des élèves --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#0d233a] text-white text-left">
                            <th class="px-4 py-3 font-medium">N°</th>
                            <th class="px-4 py-3 font-medium">Matricule</th>
                            <th class="px-4 py-3 font-medium">Nom complet</th>
                            <th class="px-4 py-3 font-medium">Sexe</th>
                            <th class="px-4 py-3 font-medium">Classe</th>
                            <th class="px-4 py-3 font-medium">Contact parent</th>
                            <th class="px-4 py-3 font-medium">Statut</th>
                            <th class="px-4 py-3 font-medium text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($eleves as $i => $eleve)
                            @php
                                $inscription = $eleve->inscriptions->last();
                                $classeNom = $inscription ? ($inscription->classe ? $inscription->classe->nom : '—') : '—';
                                $statut = $inscription ? $inscription->statut : '—';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-600">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-[#0d233a]">{{ $eleve->matricule }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $eleve->nom }} {{ $eleve->postnom }} {{ $eleve->prenom }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $eleve->sexe }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $classeNom }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $eleve->parent_telephone ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if($statut === 'active')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Actif</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">{{ $statut }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button class="modifierEleve p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Modifier"
                                                data-id="{{ $eleve->id }}"
                                                data-matricule="{{ $eleve->matricule }}"
                                                data-nom="{{ $eleve->nom }}"
                                                data-prenom="{{ $eleve->prenom }}"
                                                data-sexe="{{ $eleve->sexe }}"
                                                data-classe="{{ $inscription ? $inscription->classe_id : '' }}"
                                                data-statut="{{ $statut }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button class="supprimerEleve p-1.5 text-red-600 hover:bg-red-50 rounded" title="Supprimer"
                                                data-id="{{ $eleve->id }}"
                                                data-nom="{{ $eleve->prenom }} {{ $eleve->nom }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">Aucun élève trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="flex items-center justify-between mt-6 text-sm text-gray-600">
                <p>Affichage de <span class="font-medium">1</span> à <span class="font-medium">{{ $eleves->count() }}</span> sur <span class="font-medium">{{ $eleves->count() }}</span> élèves</p>
            </div>

            {{-- MODALE : modifier un élève --}}
            <div id="modalEleve" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-[#0d233a]">Modifier un élève</h3>
                        <button type="button" class="fermerEleve p-1.5 text-gray-500 hover:bg-gray-100 rounded" title="Fermer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <form id="formEleve" method="POST" class="px-6 py-5 space-y-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="eleveId" name="_eleveId">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Matricule <span class="text-red-500">*</span></label>
                                <input type="text" id="eleveMatricule" name="matricule" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-[#0d233a]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                                <input type="text" id="eleveNom" name="nom" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-[#0d233a]">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                <input type="text" id="elevePrenom" name="prenom" class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-[#0d233a]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sexe</label>
                                <select id="eleveSexe" name="sexe" class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 text-sm text-gray-600 focus:outline-none focus:border-[#0d233a]">
                                    <option value="M">M</option>
                                    <option value="F">F</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                                <select id="eleveStatut" name="statut" class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 text-sm text-gray-600 focus:outline-none focus:border-[#0d233a]">
                                    <option value="active">Actif</option>
                                    <option value="inactive">Inactif</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Classe <span class="text-red-500">*</span></label>
                            <select id="eleveClasse" name="classe_id" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 text-sm text-gray-600 focus:outline-none focus:border-[#0d233a]">
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                            <button type="button" class="fermerEleve px-6 py-2.5 border border-gray-400 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Annuler</button>
                            <button type="submit" class="px-6 py-2.5 bg-[#0d233a] hover:bg-[#163556] text-white rounded-md text-sm font-medium transition shadow-md">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const modal = document.getElementById('modalEleve');
                    const form = document.getElementById('formEleve');
                    const token = '{{ csrf_token() }}';

                    function fermerModal() {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        form.reset();
                    }

                    document.querySelectorAll('.fermerEleve').forEach(function (b) {
                        b.addEventListener('click', fermerModal);
                    });

                    modal.addEventListener('click', function (e) {
                        if (e.target === modal) fermerModal();
                    });

                    document.querySelectorAll('.modifierEleve').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            document.getElementById('eleveId').value = btn.dataset.id;
                            document.getElementById('eleveMatricule').value = btn.dataset.matricule;
                            document.getElementById('eleveNom').value = btn.dataset.nom;
                            document.getElementById('elevePrenom').value = btn.dataset.prenom || '';
                            document.getElementById('eleveSexe').value = btn.dataset.sexe || 'M';
                            document.getElementById('eleveClasse').value = btn.dataset.classe || '';
                            document.getElementById('eleveStatut').value = btn.dataset.statut || 'active';
                            form.action = '/eleves/' + btn.dataset.id;
                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                        });
                    });

                    document.querySelectorAll('.supprimerEleve').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            if (!confirm('Supprimer l\'élève « ' + btn.dataset.nom + ' » ?')) return;
                            const f = document.createElement('form');
                            f.method = 'POST';
                            f.action = '/eleves/' + btn.dataset.id;
                            f.innerHTML = '<input type="hidden" name="_token" value="' + token + '"><input type="hidden" name="_method" value="DELETE">';
                            document.body.appendChild(f);
                            f.submit();
                        });
                    });

                    if (document.getElementById('flashSuccess')) {
                        setTimeout(function () {
                            const el = document.getElementById('flashSuccess');
                            el.style.transition = 'opacity 0.5s';
                            el.style.opacity = '0';
                            setTimeout(function () { el.remove(); }, 500);
                        }, 3000);
                    }
                });
            </script>
@endsection
