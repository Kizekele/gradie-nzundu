<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'section_id', 'frais_scolarite'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
