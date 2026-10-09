<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected $appends = [
        'photo_url',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo) {
            return null;
        }

        return Storage::disk(env('PHOTO_DISK', 'public'))->url($this->photo);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
