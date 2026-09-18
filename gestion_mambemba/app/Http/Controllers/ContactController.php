<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sujet' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        return redirect()->route('contact')->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons bientôt.');
    }
}
