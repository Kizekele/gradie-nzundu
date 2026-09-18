{{-- ============================================
     LAYOUT ADMIN
     Utilisé par : dashboard, inscription
     Structure : sidebar fixe + header + contenu
     ============================================ --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Collège MAMBEMBA')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased flex h-screen overflow-hidden">

    {{-- PRELOADER : écran de chargement --}}
    <div id="preloader">
        <div class="loader-spinner"></div>
        <p>Chargement...</p>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                var p = document.getElementById('preloader');
                if (p) p.classList.add('hidden');
            }, 400);
        });
    </script>

    {{-- SIDEBAR : navigation fixe à gauche --}}
    <aside class="w-64 bg-[#0d233a] text-white flex flex-col justify-between shrink-0 hidden md:flex">
        <div>
            {{-- Logo cliquable vers l'accueil --}}
            <a href="{{ route('accueil') }}" class="p-6 flex items-center space-x-3 border-b border-gray-800 hover:bg-[#163556] transition">
                <div class="w-10 h-10 rounded-full overflow-hidden border border-white flex items-center justify-center p-0 bg-white">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo Collège MAMBEMBA" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="text-[10px] text-gray-300 block uppercase">Collège</span>
                    <span class="text-sm font-black tracking-wide">MAMBEMBA</span>
                </div>
            </a>

            {{-- Menu de navigation admin --}}
            {{-- L'élément actif est surchargé via @section('active_xxx') dans chaque page --}}
            <nav class="p-4 space-y-1 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg @yield('active_dashboard', 'text-gray-300 hover:bg-[#163556] hover:text-white') transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('inscription') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg @yield('active_inscription', 'text-gray-300 hover:bg-[#163556] hover:text-white') transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Nouvelle Inscription</span>
                </a>
                <a href="{{ route('eleves') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg @yield('active_eleves', 'text-gray-300 hover:bg-[#163556] hover:text-white') transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Liste des Élèves</span>
                </a>
                <a href="{{ route('parametres') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg @yield('active_parametres', 'text-gray-300 hover:bg-[#163556] hover:text-white') transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Paramètres</span>
                </a>
            </nav>
        </div>

        {{-- Lien de retour vers l'accueil --}}
        <div class="p-4 border-t border-gray-800">
            <a href="{{ route('accueil') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:text-white hover:bg-[#163556] transition text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Retour à l'accueil</span>
            </a>
        </div>
    </aside>

    {{-- ZONE DE CONTENU PRINCIPAL --}}
    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        {{-- Header avec logo et nom du collège --}}
        <header class="bg-white border-b border-gray-200 py-4 px-8 flex items-center justify-between sticky top-0 z-10">
            <a href="{{ route('accueil') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full overflow-hidden border border-[#0d233a] flex items-center justify-center p-0 bg-white">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo Collège MAMBEMBA" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="text-xs font-bold text-[#0d233a] block">Collège <span class="text-gray-400 font-normal">Coracts</span></span>
                    <span class="text-base font-black text-[#0d233a] tracking-tight block -mt-1">MAMBEMBA</span>
                </div>
            </a>
            <div class="text-center">
                <h2 class="text-xl font-black text-[#0d233a] tracking-wide">COLLÈGE MAMBEMBA</h2>
                <p class="text-xs text-gray-600 italic">Kimbanseke – Kinshasa</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm font-bold text-[#0d233a] block">{{ Auth::user()?->nom ?? 'Utilisateur' }}</p>
                    <p class="text-xs text-gray-500 block">{{ Auth::user()?->role ?? '' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 border border-red-200 text-red-600 rounded-md text-sm font-medium hover:bg-red-50 transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- Contenu dynamique de la page --}}
        <main class="p-10 max-w-5xl mx-auto w-full">
            @yield('content')
        </main>
    </div>

</body>
</html>