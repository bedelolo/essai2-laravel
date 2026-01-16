<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;

class DemandeController extends Controller
{
    public function index()
    {
        $demandes = Auth::user()->demandes()->orderBy('created_at', 'desc')->get();
        return view('demandes.index', compact('demandes'));
    }

    public function exportPdf()
    {
        $demandes = Auth::user()->demandes()->orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('demandes.pdf', compact('demandes'));
        return $pdf->download('historique_demandes.pdf');
    }

    public function create()
    {
        $demande = Demande::where('user_id', Auth::id())
                          ->where('statut', 'brouillon')
                          ->first();
        return view('demandes.create', compact('demande'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:conge,permission',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'required|string|max:500'
        ]);

        $demande = Demande::where('user_id', Auth::id())
                          ->where('statut', 'brouillon')
                          ->first();

        if ($demande) {
            $demande->update(array_merge($validated, ['statut' => 'en_attente']));
        } else {
            $validated['user_id'] = Auth::id();
            $validated['statut'] = 'en_attente';
            Demande::create($validated);
        }

        return redirect()->route('demandes.index')
            ->with('success', 'Demande envoyée avec succès!');
    }

    public function autosave(Request $request)
    {
        $validated = $request->validate([
            'type' => 'nullable|in:conge,permission',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'motif' => 'nullable|string|max:500'
        ]);

        $demande = Demande::where('user_id', Auth::id())
                          ->where('statut', 'brouillon')
                          ->first();

        if ($demande) {
            $demande->update($validated);
        } else {
            $validated['user_id'] = Auth::id();
            $validated['statut'] = 'brouillon';
            $demande = Demande::create($validated);
        }

        return response()->json(['success' => true, 'demande_id' => $demande->id]);
    }

    public function edit(Demande $demande)
    {
        // Vérifier que l'utilisateur est propriétaire et que la demande est en attente
        if ($demande->user_id !== Auth::id() || $demande->statut !== 'en_attente') {
            abort(403, 'Vous ne pouvez pas modifier cette demande.');
        }

        return view('demandes.edit', compact('demande'));
    }

    public function update(Request $request, Demande $demande)
    {
        // Vérifier que l'utilisateur est propriétaire et que la demande est en attente
        if ($demande->user_id !== Auth::id() || $demande->statut !== 'en_attente') {
            abort(403, 'Vous ne pouvez pas modifier cette demande.');
        }

        $validated = $request->validate([
            'type' => 'required|in:conge,permission',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'required|string|max:500'
        ]);

        $demande->update($validated);

        return redirect()->route('demandes.index')
            ->with('success', 'Demande modifiée avec succès!');
    }

    public function destroy(Demande $demande)
    {
        // Vérifier que l'utilisateur est propriétaire et que la demande est en attente
        if ($demande->user_id !== Auth::id() || $demande->statut !== 'en_attente') {
            abort(403, 'Vous ne pouvez pas supprimer cette demande.');
        }

        $demande->delete();

        return redirect()->route('demandes.index')
            ->with('success', 'Demande supprimée avec succès!');
    }
}