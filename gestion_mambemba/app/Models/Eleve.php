<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'postnom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'parent_nom',
        'parent_postnom',
        'parent_prenom',
        'parent_sexe',
        'parent_profession',
        'parent_telephone',
        'parent_email',
        'parent_adresse',
        'photo',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
