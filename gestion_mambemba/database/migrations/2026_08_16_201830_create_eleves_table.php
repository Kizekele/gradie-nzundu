<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('postnom')->nullable();
            $table->string('prenom');
            $table->string('sexe');
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('parent_nom');
            $table->string('parent_postnom')->nullable();
            $table->string('parent_prenom')->nullable();
            $table->string('parent_sexe')->nullable();
            $table->string('parent_profession')->nullable();
            $table->string('parent_telephone');
            $table->string('parent_email')->nullable();
            $table->string('parent_adresse')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
