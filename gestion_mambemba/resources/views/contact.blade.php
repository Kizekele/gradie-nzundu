{{-- Page Contact : formulaire de contact et coordonnées --}}
@extends('layouts.public')

@section('title', 'Contact - Collège MAMBEMBA')

@section('content')

<section class="relative bg-gray-900 text-white py-24 bg-cover bg-center" style="background-image: linear-gradient(rgba(13, 35, 58, 0.8), rgba(13, 35, 58, 0.8)), url('{{ asset('img/logo.jpg') }}');">
    <div class="max-w-4xl mx-auto text-center px-6">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">Contact</h1>
        <p class="text-lg text-gray-200 font-light">Nous sommes à votre écoute</p>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-20">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-md mb-6" id="flashSuccess">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
        <div class="animate-on-scroll">
            <h2 class="text-3xl font-bold text-[#0d233a] mb-4">Envoyez-nous un message</h2>
            <div class="w-16 h-1 bg-[#0d233a] mb-8"></div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-md mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span class="text-red-500">*</span></label>
                        <input type="text" name="nom" value="{{ old('nom') }}" required class="w-full bg-white border border-gray-400 rounded-md px-4 py-3 focus:outline-none focus:border-[#0d233a] transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-white border border-gray-400 rounded-md px-4 py-3 focus:outline-none focus:border-[#0d233a] transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sujet</label>
                    <input type="text" name="sujet" value="{{ old('sujet') }}" class="w-full bg-white border border-gray-400 rounded-md px-4 py-3 focus:outline-none focus:border-[#0d233a] transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                    <textarea name="message" rows="5" required class="w-full bg-white border border-gray-400 rounded-md px-4 py-3 focus:outline-none focus:border-[#0d233a] transition">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="bg-[#0d233a] hover:bg-[#163556] text-white px-8 py-3.5 rounded-md font-medium transition shadow-md">
                    Envoyer le message
                </button>
            </form>
        </div>

        <div class="animate-on-scroll delay-200 space-y-10">
            <div>
                <h2 class="text-3xl font-bold text-[#0d233a] mb-4">Nos Coordonnées</h2>
                <div class="w-16 h-1 bg-[#0d233a] mb-8"></div>
            </div>
            <div class="flex items-start space-x-5">
                <div class="w-12 h-12 bg-[#0d233a] rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Adresse</h3>
                    <p class="text-gray-600 text-sm">Avenue KIMPESE n°101<br>Kimbanseke, Kinshasa<br>République Démocratique du Congo</p>
                </div>
            </div>
            <div class="flex items-start space-x-5">
                <div class="w-12 h-12 bg-[#0d233a] rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Téléphone</h3>
                    <p class="text-gray-600 text-sm">+243 123 456 789<br>+243 987 654 321</p>
                </div>
            </div>
            <div class="flex items-start space-x-5">
                <div class="w-12 h-12 bg-[#0d233a] rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Email</h3>
                    <p class="text-gray-600 text-sm">contact@college-mambemba.cd<br>info@college-mambemba.cd</p>
                </div>
            </div>
            <div class="flex items-start space-x-5">
                <div class="w-12 h-12 bg-[#0d233a] rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Horaires</h3>
                    <p class="text-gray-600 text-sm">Lun – Ven : 7h30 – 16h00<br>Sam : 8h00 – 12h00</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
