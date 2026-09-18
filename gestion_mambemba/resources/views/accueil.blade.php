{{-- Page d'accueil publique du Collège MAMBEMBA --}}
@extends('layouts.public')

@section('title', 'Collège MAMBEMBA')



@section('content')

    {{-- HERO : Bannière principale avec parallaxe --}}
    <section class="hero-parallax relative bg-gray-900 text-white py-32 bg-cover bg-center" style="background-image: linear-gradient(rgba(13, 35, 58, 0.75), rgba(13, 35, 58, 0.75)), url('{{ asset('img/accueil.jpg') }}');">
        <div class="max-w-4xl mx-auto text-center px-6 relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">
                Collège MAMBEMBA
            </h1>
            <p class="text-lg md:text-xl text-gray-200 mb-8 font-light">
                L'éducation des enfants est notre vocation.
            </p>
            <a href="{{ route('inscription') }}" class="inline-block bg-white text-[#0d233a] font-semibold px-8 py-3.5 rounded-md shadow-lg hover:bg-gray-100 transition">
                Commencer une inscription
            </a>
        </div>
    </section>

    {{-- SECTION 3 COLONNES : Mot du Promoteur, Niveaux, Actualités --}}
    <section class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-3 gap-12">
        
        {{-- Colonne 1 : Mot du Promoteur --}}
        <div class="animate-on-scroll">
            <h2 class="text-2xl font-bold text-[#0d233a] mb-2">Mot du Promoteur</h2>
            <div class="w-12 h-1 bg-[#0d233a] mb-6"></div>
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
                Collège MAMBEMBA, dont l'éducation des enfants est notre vocation a doté la chance de connaitre entre [jeu] de commerce une de notre note ga teneur oot as Promoteur.
            </p>
            <a href="#" class="text-[#0d233a] font-semibold text-sm inline-flex items-center hover:underline">
                Letter comment <span class="ml-2">→</span>
            </a>
        </div>

        {{-- Colonne 2 : Nos Niveaux d'Études --}}
        <div class="animate-on-scroll delay-200">
            <h2 class="text-2xl font-bold text-[#0d233a] mb-2">Nos Niveaux d'Études</h2>
            <div class="w-12 h-1 bg-[#0d233a] mb-6"></div>
            <div class="space-y-3 mt-6">
                @foreach($sections as $section)
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 border border-gray-300 rounded-lg flex items-center justify-center text-[#0d233a] bg-gray-50 shadow-sm shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14v7"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700">{{ $section->nom }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Colonne 3 : Dernières Actualités --}}
        <div class="animate-on-scroll delay-400">
            <h2 class="text-2xl font-bold text-[#0d233a] mb-2">Dernières Actualités</h2>
            <div class="w-12 h-1 bg-[#0d233a] mb-6"></div>
            
            <div class="bg-white border border-gray-100 p-5 rounded-xl shadow-lg relative hover-lift">
                <p class="text-xs text-gray-700 leading-relaxed mb-4">
                    <strong class="text-black">Dernières Actualités</strong> - Collège MAMBEMBA Brorle : L'éducation de collège, et'ingartes est nor grades dr M...
                </p>
                <a href="#" class="text-[#0d233a] font-semibold text-xs inline-flex items-center hover:underline">
                    Read more <span class="ml-1">→</span>
                </a>
            </div>
        </div>

    </section>

@endsection