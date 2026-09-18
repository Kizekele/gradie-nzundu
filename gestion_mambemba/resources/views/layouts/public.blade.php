{{-- ============================================
     LAYOUT PUBLIC
     Utilisé par : accueil, apropos, contact
     Structure : header, contenu, footer
     ============================================ --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Collège MAMBEMBA')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-gray-800 antialiased">

    {{-- Transition de fluidité au chargement de la page --}}
    <style>
        body { animation: pageFadeIn 0.5s ease-out; }
        @keyframes pageFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

    {{-- HEADER : logo + navigation + CTA --}}
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            {{-- Logo cliquable vers l'accueil --}}
            <a href="{{ route('accueil') }}" class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-[#0d233a] flex items-center justify-center p-0 bg-white">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo Collège MAMBEMBA" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="text-xs font-semibold tracking-wider text-gray-500 uppercase block">Collège</span>
                    <span class="text-xl font-black text-[#0d233a] tracking-tight">MAMBEMBA</span>
                </div>
            </a>

            {{-- Navigation principale --}}
            {{-- L'onglet actif est détecté automatiquement via request()->routeIs() --}}
            <nav class="hidden md:flex items-center space-x-8 font-medium text-gray-700">
                <a href="{{ route('accueil') }}" class="hover:text-[#0d233a] transition pb-1 {{ request()->routeIs('accueil') ? 'text-[#0d233a] font-semibold border-b-2 border-[#0d233a]' : '' }}">Accueil</a>
                <a href="{{ route('apropos') }}" class="hover:text-[#0d233a] transition pb-1 {{ request()->routeIs('apropos') ? 'text-[#0d233a] font-semibold border-b-2 border-[#0d233a]' : '' }}">À Propos</a>
                <a href="{{ route('contact') }}" class="hover:text-[#0d233a] transition pb-1 {{ request()->routeIs('contact') ? 'text-[#0d233a] font-semibold border-b-2 border-[#0d233a]' : '' }}">Contact</a>
            </nav>

            {{-- Bouton CTA vers le tableau de bord --}}
            <div>
                <a href="{{ route('inscription') }}" class="bg-[#0d233a] hover:bg-[#163556] text-white px-5 py-3 rounded-md font-medium text-sm transition shadow-md">
                    Commencer l'inscription
                </a>
            </div>
        </div>
    </header>

    {{-- CONTENU PRINCIPAL (propulsé par @yield dans chaque page) --}}
    @yield('content')

    {{-- FOOTER : coordonnées et liens --}}
    <footer class="bg-[#0d233a] text-white pt-16 pb-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 text-sm">
            <div>
                <h3 class="font-bold text-base mb-4 tracking-wide">Contact Us</h3>
                <p class="text-gray-300 leading-relaxed mb-2">Avenue KIMPESE n°101</p>
                <p class="text-gray-300 leading-relaxed mb-2">Kimbanseke, Kinshasa</p>
            </div>
            <div>
                <h3 class="font-bold text-base mb-4 tracking-wide">Coordonnées</h3>
                <ul class="space-y-2 text-gray-300">
                    <li>
                        Site web : <a href="https://collegemambemba.cd" target="_blank" rel="noopener" class="hover:text-white transition">collegemambemba.cd</a>
                    </li>
                    <li>
                        Téléphone : <a href="tel:+243823551245" class="hover:text-white transition">0823 551 245</a>
                    </li>
                    <li>
                        E-mail : <a href="mailto:epaphrasmambemba7@gmail.com" class="hover:text-white transition">epaphrasmambemba7@gmail.com</a>
                    </li>
                    <li>
                        WhatsApp : <a href="https://wa.me/243823551245" target="_blank" rel="noopener" class="hover:text-white transition">+243 823 551 245</a>
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-base mb-4 tracking-wide">Liens Rapides</h3>
                <ul class="space-y-2 text-gray-300">
                    <li><a href="{{ route('accueil') }}" class="hover:text-white transition">Accueil</a></li>
                    <li><a href="{{ route('apropos') }}" class="hover:text-white transition">À Propos</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact</a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>
</html>