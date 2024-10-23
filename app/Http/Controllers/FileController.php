<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    public function index()
    {
        $files = File::where('user_id', auth()->id())->get();
        return view('dashboard', compact('files')); // Zorg ervoor dat de view hier goed is
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048', // Maximaal 2MB
        ]);

        // Gebruik de public schijf om bestanden op te slaan
        $path = $request->file('file')->store('files', 'public'); // Zorg ervoor dat je de 'public' schijf gebruikt

        // Controleer of het bestand succesvol is opgeslagen
        if ($path) {
            // Maak een nieuw bestand aan in de database
            File::create([
                'user_id' => auth()->id(),
                         'filename' => $request->file('file')->getClientOriginalName(),
                         'path' => $path,
            ]);
            return back()->with('success', 'Bestand geüpload!');
        } else {
            return back()->withErrors(['file' => 'Bestand kon niet worden opgeslagen.']);
        }
    }


    public function download($id)
    {
        $file = File::findOrFail($id);

        // Debug: controleer het pad van het bestand
        $filePath = storage_path('app/public/' . $file->path); // Zorg ervoor dat je het juiste pad gebruikt
        if (!file_exists($filePath)) {
            return abort(404, 'File not found.');
        }

        // Zorg ervoor dat de gebruiker de eigenaar van het bestand is
        if ($file->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        return response()->download($filePath);
    }


    public function destroy($id)
    {
        // Zoek het bestand op basis van het ID
        $file = File::findOrFail($id);

        // Controleer of de ingelogde gebruiker de eigenaar is van het bestand
        if ($file->user_id !== auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }

        // Verwijder het bestand uit de database
        $file->delete();

        // Optioneel: Verwijder het bestand uit de opslag
        $storagePath = storage_path('app/public/' . $file->path); // Correct pad opbouwen

        // Debugging: Controleer of het bestand bestaat voordat je het verwijdert
        if (file_exists($storagePath)) {
            if (unlink($storagePath)) {
                return back()->with('success', 'Bestand verwijderd!');
            } else {
                return back()->withErrors(['error' => 'Kon het bestand niet verwijderen.']);
            }
        } else {
            return back()->withErrors(['error' => 'Bestand bestaat niet in de opslag.']);
        }
    }

    public function share(Request $request, $fileId)
    {
        $request->validate([
            'username' => 'required|string|max:255',
        ]);

        // Zoek de gebruiker op basis van de gebruikersnaam
        $user = User::where('name', $request->username)->first();

        if (!$user) {
            // Geef een foutmelding terug als de gebruiker niet bestaat
            return back()->withErrors(['username' => 'Gebruiker niet gevonden.']);
        }

        // Zoek het bestand op basis van het ID
        $file = File::find($fileId);

        if (!$file) {
            return back()->withErrors(['file' => 'Bestand niet gevonden.']);
        }

        // Deel het bestand met de gebruiker
        \DB::table('shared_files')->insert([
            'file_id' => $file->id,
            'user_id' => $user->id, // Gebruik het ID van de gebruiker
            'created_at' => now(),
                                           'updated_at' => now(),
        ]);

        return back()->with('success', 'Bestand succesvol gedeeld met ' . $user->name);
    }

    public function sharedFiles()
    {
        // Verkrijg de bestanden die met de huidige gebruiker zijn gedeeld
        $files = \DB::table('shared_files')
        ->where('shared_files.user_id', auth()->id()) // Specificeer de tabelnaam
        ->join('files', 'shared_files.file_id', '=', 'files.id')
        ->select('files.*')
        ->get();

        return view('shared_files', compact('files'));
    }

    public function downloadSharedFile($fileId)
    {
        // Zoek het bestand op basis van het ID
        $file = \DB::table('files')->where('id', $fileId)->first();

        if (!$file) {
            return redirect()->back()->withErrors(['error' => 'Bestand niet gevonden.']);
        }

        // Download het bestand
        return Storage::disk('public')->download($file->path, $file->filename);
    }
}
