{{-- Page d'inscription : formulaire d'état civil, infos académiques, parents, documents --}}
@extends('layouts.admin')

@section('title', 'Nouvelle Inscription - Collège MAMBEMBA')

@section('active_inscription', 'bg-[#163556] text-white')

@section('content')
            <h1 class="text-2xl font-bold text-[#0d233a] mb-8">Nouvelle Inscription – État Civil</h1>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-md mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('inscription.store') }}" method="POST" class="space-y-10">
                @csrf

                <!-- Identité de l'Élève -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">Identité de l'Élève</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                            <input type="text" name="nom" value="{{ old('nom') }}" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Post-nom <span class="text-red-500">*</span></label>
                            <input type="text" name="postnom" value="{{ old('postnom') }}" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom <span class="text-red-500">*</span></label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sexe <span class="text-red-500">*</span></label>
                            <select name="sexe" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                                <option value="">-- Sexe --</option>
                                <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de naissance <span class="text-red-500">*</span></label>
                            <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lieu de naissance <span class="text-red-500">*</span></label>
                            <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                    </div>
                </div>

                <!-- Informations Académiques -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">Informations Académiques</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section <span class="text-red-500">*</span></label>
                            <select id="sectionSelect" class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                                <option value="">-- Choisir une section --</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Classe <span class="text-red-500">*</span></label>
                            <select name="classe_id" id="classeSelect" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                                <option value="">-- Choisir d'abord une section --</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Identité des Parents / Tuteur -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">Identité des Parents / Tuteur</h3>
                    <input type="hidden" name="parent_sexe" value="M">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom du père <span class="text-red-500">*</span></label>
                            <input type="text" name="parent_nom" value="{{ old('parent_nom') }}" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Post-nom du père <span class="text-red-500">*</span></label>
                            <input type="text" name="parent_postnom" value="{{ old('parent_postnom') }}" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom du père <span class="text-red-500">*</span></label>
                            <input type="text" name="parent_prenom" value="{{ old('parent_prenom') }}" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Profession</label>
                            <input type="text" name="parent_profession" value="{{ old('parent_profession') }}" class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact téléphonique <span class="text-red-500">*</span></label>
                            <input type="text" name="parent_telephone" value="{{ old('parent_telephone') }}" required class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                            <input type="text" name="parent_adresse" value="{{ old('parent_adresse') }}" class="w-full bg-white border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action bas de page -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('inscription') }}" class="px-6 py-2.5 border border-gray-400 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-[#0d233a] hover:bg-[#163556] text-white rounded-md text-sm font-medium transition shadow-md">
                        Enregistrer
                    </button>
                </div>

            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const sections = @json($sections);
                    const sectionSelect = document.getElementById('sectionSelect');
                    const classeSelect = document.getElementById('classeSelect');

                    sectionSelect.addEventListener('change', function () {
                        const sectionId = Number(this.value);
                        classeSelect.innerHTML = '<option value="">-- Choisir une classe --</option>';
                        if (!sectionId) return;
                        const section = sections.find(s => s.id === sectionId);
                        if (section && section.classes) {
                            section.classes.forEach(c => {
                                const opt = document.createElement('option');
                                opt.value = c.id;
                                opt.textContent = c.nom;
                                classeSelect.appendChild(opt);
                            });
                        }
                    });
                });
            </script>
@endsection
