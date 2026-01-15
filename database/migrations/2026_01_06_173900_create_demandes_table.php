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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->enum('type', ['conge', 'permission']);
            $table->date('date_debut');
            $table->date('date_fin');
            $table->text('motif'); // Added motif

            // Renamed etat to statut, default 'en_attente'
            $table->enum('statut', ['en_attente', 'approuve', 'rejete'])
                  ->default('en_attente');

            $table->text('commentaire_admin')->nullable(); // Renamed form commentaire_refus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
