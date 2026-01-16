<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->string('type')->nullable()->change();
            $table->date('date_debut')->nullable()->change();
            $table->date('date_fin')->nullable()->change();
            $table->text('motif')->nullable()->change();
            // We cannot easily modify enum with change(), so we used raw statement or just allow it to hold new value if not strict mode, 
            // but for portability in Laravel with enum, it's often easier to just change column definition to string or use raw SQL.
            // Let's rely on the fact that we can just change the column definition if we drop the enum constraint essentially or redefine it.
            // However, Doctrine DBAL (used by change()) doesn't always support enum well. 
            // A safer approach for enum addition without DBAL issues on some drivers is raw SQL, but let's try standard Laravel way first provided we have doctrine/dbal.
            // Actually, for simplicity and robustness, let's just modify the column to be string or re-declare enum.
            // NOTE: Laravel 'enum' method creates a VARCHAR column with check constraint or actual ENUM type depending on DB.
        });
        
        // Use raw statement to modify enum for MySQL/Postgres explicitly if needed, but let's try the Laravel way:
        // Since modifying underlying enum values is tricky, let's just change it to string for flexibility if the user is okay with it, OR try to redefine it.
        // Actually, let's just use raw SQL to modify the column type to include 'brouillon'.
        DB::statement("ALTER TABLE demandes MODIFY COLUMN statut ENUM('en_attente', 'approuve', 'rejete', 'brouillon') DEFAULT 'en_attente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->string('type')->nullable(false)->change(); // This might fail if nulls exist
            $table->date('date_debut')->nullable(false)->change();
            $table->date('date_fin')->nullable(false)->change();
            $table->text('motif')->nullable(false)->change();
        });
        
         DB::statement("ALTER TABLE demandes MODIFY COLUMN statut ENUM('en_attente', 'approuve', 'rejete') DEFAULT 'en_attente'");
    }
};
