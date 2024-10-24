<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\File;
use App\Models\User;
use App\Models\SharedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        // Verkrijg bestanden die door de ingelogde gebruiker zijn geüpload
        $files = File::where('user_id', auth()->id())->get();
        return view('dashboard', compact('files'));
    }

    public function store(Request $request)
    {
        // Validatie van het geüploade bestand
        $request->validate([
            'file' => 'required|file|max:2048', // Maximaal 2MB
        ]);

        // Bestand opslaan op de public schijf
        $path = $request->file('file')->store('files', 'public');

        // Bestandsrecord aanmaken in de database
        File::create([
            'user_id' => auth()->id(),
                     'filename' => $request->file('file')->getClientOriginalName(),
                     'path' => $path,
        ]);

        return back()->with('success', 'Bestand geüpload!');
    }

    public function download($id)
    {
        $file = File::findOrFail($id);

        // Controleer of de gebruiker de eigenaar is van het bestand
        if ($file->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        // Download het bestand
        return Storage::disk('public')->download($file->path, $file->filename);
    }   

    public function destroy($id)
    {
        $file = File::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is
        if ($file->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        // Verwijder het bestand uit de database
        $file->delete();

        // Verwijder het bestand uit de opslag
        Storage::disk('public')->delete($file->path);

        return back()->with('success', 'Bestand verwijderd!');
    }
    
    public function share(Request $request)
    {
        // Valideer de input
        $request->validate([
            'email' => 'required|email', // Controleer of het een geldig e-mailadres is
            'file_id' => 'required|exists:files,id', // Zorg ervoor dat het bestand bestaat
        ]);
    
        // Zoek het bestand
        $file = File::findOrFail($request->input('file_id'));
    
        // Deel het bestand met het e-mailadres
        SharedFile::create([
            'file_id' => $file->id,
            'email' => $request->input('email'), // Gebruik e-mailadres
            'user_id' => Auth::id(), // ID van de huidige gebruiker
        ]);
    
        return redirect()->back()->with('success', 'Bestand succesvol gedeeld met ' . $request->input('email'));
    }

    public function sharedWithMe()
    {
        // Verkrijg alle gedeelde bestanden voor de ingelogde gebruiker
        $sharedFiles = SharedFile::with(['file', 'user']) // Laad de gerelateerde modellen
            ->where('email', Auth::user()->email) // Filter op het e-mailadres van de ingelogde gebruiker
            ->get();

        return view('shared-files', compact('sharedFiles'));
    }

    public function downloadSharedFile($id)
    {
        // Zoek de gedeelde bestand record
        $sharedFile = SharedFile::with('file')->where('id', $id)->firstOrFail();
    
        // Controleer of de gebruiker het bestand heeft ontvangen
        if ($sharedFile->email !== Auth::user()->email) {
            return abort(403, 'Unauthorized action.');
        }
    
        // Download het bestand
        return Storage::disk('public')->download($sharedFile->file->path, $sharedFile->file->filename);
    }
     
}
