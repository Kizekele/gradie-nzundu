{{-- Page À Propos : histoire, mission, valeurs du Collège MAMBEMBA --}}
@extends('layouts.public')

@section('title', 'À Propos - Collège MAMBEMBA')

@section('content')

{{-- BANNIÈRE HERO --}}
<section class="relative bg-gray-900 text-white py-24 bg-cover bg-center" style="background-image: linear-gradient(rgba(13, 35, 58, 0.8), rgba(13, 35, 58, 0.8)), url('{{ asset('img/apropos.jpg') }}');">
    <div class="max-w-4xl mx-auto text-center px-6">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">À Propos</h1>
        <p class="text-lg text-gray-200 font-light">Collège MAMBEMBA — Bâtir l'avenir par l'éducation</p>
    </div>
</section>

{{-- SECTION HISTOIRE --}}
<section class="max-w-6xl mx-auto px-6 py-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div class="animate-on-scroll">
            <h2 class="text-3xl font-bold text-[#0d233a] mb-4">Notre Histoire</h2>
            <div class="w-16 h-1 bg-[#0d233a] mb-6"></div>
            <p class="text-gray-600 leading-relaxed mb-4">
                Fondé avec la vision de fournir une éducation de qualité accessible à tous, le Collège MAMBEMBA s'est imposé comme un établissement de référence dans la commune de Kimbanseke, Kinshasa.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Depuis sa création, l'école n'a cessé de croître, accompagnant des générations d'élèves vers la réussite scolaire et l'épanouissement personnel.
            </p>
        </div>
        <div class="animate-on-scroll delay-200">
            <img src="{{ asset('img/histoire.jpg') }}" alt="Collège MAMBEMBA" class="rounded-xl shadow-lg w-full">
        </div>
    </div>
</section>

{{-- SECTION MISSION : 3 piliers éducatifs --}}
<section class="bg-gray-50 py-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-[#0d233a] mb-2">Notre Mission</h2>
            <div class="w-16 h-1 bg-[#0d233a] mx-auto mb-4"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="animate-on-scroll bg-white p-8 rounded-xl shadow-md text-center hover-lift">
                <div class="w-16 h-16 bg-[#0d233a] rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-[#0d233a] mb-3">Éducation de Qualité</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Offrir un enseignement rigoureux adapté aux défis du monde moderne.</p>
            </div>
            <div class="animate-on-scroll delay-200 bg-white p-8 rounded-xl shadow-md text-center hover-lift">
                <div class="w-16 h-16 bg-[#0d233a] rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-[#0d233a] mb-3">Encadrement Personnalisé</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Un suivi attentif de chaque élève pour favoriser son épanouissement.</p>
            </div>
            <div class="animate-on-scroll delay-400 bg-white p-8 rounded-xl shadow-md text-center hover-lift">
                <div class="w-16 h-16 bg-[#0d233a] rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-[#0d233a] mb-3">Ouverture sur le Monde</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Préparer les élèves à devenir des citoyens du monde responsables.</p>
            </div>
        </div>
    </div>
</section>

{{-- SECTION VALEURS --}}
<section class="max-w-6xl mx-auto px-6 py-20">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-[#0d233a] mb-2">Nos Valeurs</h2>
        <div class="w-16 h-1 bg-[#0d233a] mx-auto mb-4"></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="animate-on-scroll text-center">
            <div class="text-4xl font-black text-[#0d233a] mb-2">01</div>
            <h3 class="font-bold text-gray-800 mb-2">Excellence</h3>
            <p class="text-gray-500 text-sm">La recherche constante de la performance académique.</p>
        </div>
        <div class="animate-on-scroll delay-100 text-center">
            <div class="text-4xl font-black text-[#0d233a] mb-2">02</div>
            <h3 class="font-bold text-gray-800 mb-2">Discipline</h3>
            <p class="text-gray-500 text-sm">Le respect et la rigueur comme fondements de la réussite.</p>
        </div>
        <div class="animate-on-scroll delay-200 text-center">
            <div class="text-4xl font-black text-[#0d233a] mb-2">03</div>
            <h3 class="font-bold text-gray-800 mb-2">Intégrité</h3>
            <p class="text-gray-500 text-sm">L'honnêteté et la transparence dans toutes nos actions.</p>
        </div>
        <div class="animate-on-scroll delay-300 text-center">
            <div class="text-4xl font-black text-[#0d233a] mb-2">04</div>
            <h3 class="font-bold text-gray-800 mb-2">Solidarité</h3>
            <p class="text-gray-500 text-sm">L'entraide et l'esprit communautaire au cœur de notre projet.</p>
        </div>
    </div>
</section>

{{-- SECTION CTA : inscription --}}
<section class="bg-[#0d233a] text-white py-16">
    <div class="max-w-4xl mx-auto text-center px-6">
        <h2 class="text-3xl font-bold mb-4">Prêt à Rejoindre Notre Communauté ?</h2>
        <p class="text-gray-300 mb-8">Inscrivez votre enfant dès maintenant au Collège MAMBEMBA.</p>
        <a href="{{ route('inscription') }}" class="inline-block bg-white text-[#0d233a] font-semibold px-8 py-3.5 rounded-md shadow-lg hover:bg-gray-100 transition">
            Commencer une inscription
        </a>
    </div>
</section>

@endsection