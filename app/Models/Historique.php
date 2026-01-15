<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id',
        'acteur_id',
        'action',
        'commentaire'
    ];

    // Un historique appartient à une demande
    public function demande()
    {
        return $this->belongsTo(Demande::class, 'demande_id');
    }

    // Un historique appartient à un utilisateur (acteur)
    public function acteur()
    {
        return $this->belongsTo(User::class, 'acteur_id');
    }
}
