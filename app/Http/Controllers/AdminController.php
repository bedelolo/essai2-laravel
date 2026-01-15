<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\User;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{

    /**
     * Tableau de bord admin
     */
    public function dashboard()
    {
        $demandesEnAttente = Demande::where('statut', 'en_attente')
            ->latest()
            ->get();

        $totalDemandes     = Demande::count();
        $demandesApprouvees = Demande::where('statut', 'approuve')->count();
        $demandesRejetees   = Demande::where('statut', 'rejete')->count();
        $totalUsers         = User::where('role', 'user')->count();

        return view('admin.dashboard', compact(
            'demandesEnAttente',
            'totalDemandes',
            'demandesApprouvees',
            'demandesRejetees',
            'totalUsers'
        ));
    }

    /**
     * Liste des demandes en attente
     */
    public function demandesEnAttente()
    {
        $demandes = Demande::with('user')
            ->where('statut', 'en_attente')
            ->latest()
            ->get();

        return view('admin.demandes-en-attente', compact('demandes'));
    }

    /**
     * Historique des demandes
     */
    /**
     * Historique des demandes (traitées)
     */
    public function historique(Request $request)
    {
        $query = Demande::with('user')
            ->whereIn('statut', ['approuve', 'rejete']);

        // Filtrage optionnel par statut spécifique
        if ($request->has('statut') && in_array($request->statut, ['approuve', 'rejete'])) {
            $query->where('statut', $request->statut);
        }

        $demandes = $query->latest('updated_at')->get();

        return view('admin.historique', compact('demandes'));
    }

    public function exportPdf()
    {
        // Exporter uniquement les demandes traitées
        $demandes = Demande::with('user')
            ->whereIn('statut', ['approuve', 'rejete'])
            ->latest('updated_at')
            ->get();
            
        $pdf = Pdf::loadView('admin.pdf', compact('demandes'));
        return $pdf->download('historique_global_demandes.pdf');
    }

    /**
     * Approuver une demande
     */
    public function approuver(Request $request, Demande $demande)
    {
        $request->validate([
            'commentaire' => 'nullable|string|max:500',
        ]);

        $demande->update([
            'statut' => 'approuve',
            'commentaire_admin' => $request->commentaire,
        ]);

        return redirect()->back()->with('success', 'Demande approuvée avec succès.');
    }

    /**
     * Rejeter une demande
     */
    public function rejeter(Request $request, Demande $demande)
    {
        $request->validate([
            'commentaire' => 'required|string|max:500',
        ]);

        $demande->update([
            'statut' => 'rejete',
            'commentaire_admin' => $request->commentaire,
        ]);

        return redirect()->back()->with('success', 'Demande rejetée avec succès.');
    }
}
