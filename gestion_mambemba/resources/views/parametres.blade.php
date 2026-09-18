{{-- Paramètres du système (informations du collège + frais) --}}
@extends('layouts.admin')

@section('title', 'Paramètres - Collège MAMBEMBA')

{{-- Surligne le menu "Paramètres" dans la sidebar --}}
@section('active_parametres', 'bg-[#163556] text-white')

@section('content')
            {{-- En-tête : titre + bouton Modifier --}}
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold text-[#0d233a]">Paramètres</h1>
                <button type="button" id="btnModifier" class="px-5 py-2.5 bg-[#0d233a] hover:bg-[#163556] text-white rounded-md text-sm font-medium transition shadow-md flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span>Modifier</span>
                </button>
            </div>

            {{-- Bandeau mode édition --}}
            <div id="barreModif" class="hidden bg-blue-50 border border-blue-200 text-blue-700 text-sm px-4 py-3 rounded-md mb-6 flex items-center space-x-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Mode édition activé. Modifiez les informations puis cliquez sur « Enregistrer les Paramètres ».</span>
            </div>

            {{-- Notification de succès --}}
            <div id="toastParametres" class="fixed top-6 right-6 z-50 bg-green-600 text-white px-5 py-3 rounded-md shadow-lg text-sm font-medium opacity-0 transition-opacity duration-300 pointer-events-none hidden"></div>

            <form id="formParametres" action="#" method="POST" class="space-y-10">
                @csrf

                <!-- Informations du Collège -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">Informations du Collège</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="cfg_nom" class="block text-sm font-medium text-gray-700 mb-1">Nom du collège <span class="text-red-500">*</span></label>
                            <input type="text" id="cfg_nom" value="Collège MAMBEMBA" disabled class="w-full bg-gray-100 text-gray-500 cursor-not-allowed border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label for="cfg_annee" class="block text-sm font-medium text-gray-700 mb-1">Année scolaire <span class="text-red-500">*</span></label>
                            <input type="text" id="cfg_annee" value="2026-2027" disabled class="w-full bg-gray-100 text-gray-500 cursor-not-allowed border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label for="cfg_adresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                            <input type="text" id="cfg_adresse" value="Kimbanseke – Kinshasa" disabled class="w-full bg-gray-100 text-gray-500 cursor-not-allowed border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label for="cfg_tel" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <input type="text" id="cfg_tel" value="+243 810 000 000" disabled class="w-full bg-gray-100 text-gray-500 cursor-not-allowed border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                        <div>
                            <label for="cfg_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="cfg_email" value="contact@collegemambemba.cd" disabled class="w-full bg-gray-100 text-gray-500 cursor-not-allowed border border-gray-400 rounded-md px-3 py-2.5 focus:outline-none focus:border-[#0d233a]">
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action bas de page -->
                <div id="actionsParametres" class="hidden items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" id="btnAnnuler" class="px-6 py-2.5 border border-gray-400 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                        Annuler
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-[#0d233a] hover:bg-[#163556] text-white rounded-md text-sm font-medium transition shadow-md">
                        Enregistrer les Paramètres
                    </button>
                </div>

            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const STORAGE_KEY = 'parametresMambemba';
                    const fields = [
                        'cfg_nom', 'cfg_annee', 'cfg_adresse', 'cfg_tel', 'cfg_email'
                    ];

                    const form = document.getElementById('formParametres');
                    const btnModifier = document.getElementById('btnModifier');
                    const btnAnnuler = document.getElementById('btnAnnuler');
                    const actions = document.getElementById('actionsParametres');
                    const barreModif = document.getElementById('barreModif');
                    const toast = document.getElementById('toastParametres');
                    let snapshot = {};

                    function lireValeurs() {
                        const obj = {};
                        fields.forEach(function (id) { obj[id] = document.getElementById(id).value; });
                        return obj;
                    }

                    function appliquer(obj) {
                        fields.forEach(function (id) { document.getElementById(id).value = obj[id]; });
                    }

                    function charger() {
                        const saved = localStorage.getItem(STORAGE_KEY);
                        if (saved) {
                            try { appliquer(JSON.parse(saved)); } catch (e) {}
                        }
                        snapshot = lireValeurs();
                    }

                    function setMode(edition) {
                        fields.forEach(function (id) {
                            const el = document.getElementById(id);
                            el.disabled = !edition;
                            el.classList.toggle('bg-gray-100', !edition);
                            el.classList.toggle('text-gray-500', !edition);
                            el.classList.toggle('cursor-not-allowed', !edition);
                            el.classList.toggle('bg-white', edition);
                        });
                        btnModifier.classList.toggle('hidden', edition);
                        barreModif.classList.toggle('hidden', !edition);
                        actions.classList.toggle('hidden', !edition);
                        actions.classList.toggle('flex', edition);
                        if (edition) document.getElementById('cfg_nom').focus();
                    }

                    function toastMsg(msg) {
                        toast.textContent = msg;
                        toast.classList.remove('hidden');
                        requestAnimationFrame(function () { toast.classList.add('opacity-100'); });
                        clearTimeout(toastMsg._t);
                        toastMsg._t = setTimeout(function () {
                            toast.classList.remove('opacity-100');
                            setTimeout(function () { toast.classList.add('hidden'); }, 300);
                        }, 2500);
                    }

                    charger();
                    setMode(false);

                    btnModifier.addEventListener('click', function () { setMode(true); });

                    btnAnnuler.addEventListener('click', function () {
                        appliquer(snapshot);
                        setMode(false);
                    });

                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        snapshot = lireValeurs();
                        localStorage.setItem(STORAGE_KEY, JSON.stringify(snapshot));
                        setMode(false);
                        toastMsg('Paramètres enregistrés avec succès.');
                    });
                });
            </script>
@endsection
