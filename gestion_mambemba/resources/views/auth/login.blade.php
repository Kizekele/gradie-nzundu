{{-- Page de connexion --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Collège MAMBEMBA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased min-h-screen flex items-center justify-center p-6"
      style="background-image: linear-gradient(rgba(13, 35, 58, 0.85), rgba(13, 35, 58, 0.85)), url('{{ asset('img/accueil.jpg') }}'); background-size: cover; background-position: center;">

    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-8">
        <a href="{{ route('accueil') }}" class="flex items-center justify-center space-x-3 mb-6">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo Collège MAMBEMBA" class="w-14 h-14 rounded-full object-cover border-2 border-[#0d233a]">
            <div>
                <span class="text-base font-black text-[#0d233a] block">COLLÈGE MAMBEMBA</span>
                <span class="text-xs text-gray-500 block">Kimbanseke – Kinshasa</span>
            </div>
        </a>

        <h1 class="text-xl font-bold text-[#0d233a] text-center mb-6">Connexion</h1>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-md mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-md mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.attempt') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full bg-white border border-gray-400 rounded-md px-4 py-3 focus:outline-none focus:border-[#0d233a] transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                       class="w-full bg-white border border-gray-400 rounded-md px-4 py-3 focus:outline-none focus:border-[#0d233a] transition">
            </div>
            <button type="submit" class="w-full bg-[#0d233a] hover:bg-[#163556] text-white px-6 py-3 rounded-md font-semibold transition shadow-md">
                Se connecter
            </button>
        </form>

        <p class="text-xs text-gray-500 text-center mt-6">
            <a href="{{ route('accueil') }}" class="hover:text-[#0d233a] transition font-medium">← Retour à l'accueil</a>
        </p>
    </div>

</body>
</html>