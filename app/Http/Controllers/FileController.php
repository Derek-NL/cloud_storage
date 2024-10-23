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

    public function share(Request $request, $fileId)
    {
        $request->validate([
            'username' => 'required|string|max:255',
        ]);

        // Zoek de gebruiker op basis van de gebruikersnaam
        $user = User::where('name', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Gebruiker niet gevonden.']);
        }

        // Zoek het bestand op basis van het ID
        $file = File::find($fileId);

        if (!$file) {
            return back()->withErrors(['file' => 'Bestand niet gevonden.']);
        }

        // Controleer of het bestand al is gedeeld met de gebruiker
        $exists = \DB::table('shared_files')->where('file_id', $file->id)->where('user_id', $user->id)->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Bestand is al gedeeld met deze gebruiker.']);
        }

        // Deel het bestand met de gebruiker
        \DB::table('shared_files')->insert([
            'file_id' => $file->id,
            'user_id' => $user->id,
            'created_at' => now(),
                                           'updated_at' => now(),
        ]);

        return back()->with('success', 'Bestand succesvol gedeeld met ' . $user->name);
    }

    public function sharedFiles()
    {
        // Verkrijg de bestanden die met de huidige gebruiker zijn gedeeld
        $files = \DB::table('shared_files')
        ->where('shared_files.user_id', auth()->id())
        ->join('files', 'shared_files.file_id', '=', 'files.id')
        ->select('files.*')
        ->get();

        return view('shared_files', compact('files'));
    }

    public function downloadSharedFile($fileId)
    {
        // Controleer of het bestand gedeeld is met de huidige gebruiker
        $sharedFile = \DB::table('shared_files')
        ->where('file_id', $fileId)
        ->where('user_id', auth()->id())
        ->first();

        if (!$sharedFile) {
            return redirect()->back()->withErrors(['error' => 'U hebt geen toegang tot dit bestand.']);
        }

        // Zoek het bestand op basis van het ID
        $file = File::find($fileId);

        if (!$file) {
            return redirect()->back()->withErrors(['error' => 'Bestand niet gevonden.']);
        }

        // Download het bestand
        return Storage::disk('public')->download($file->path, $file->filename);
    }
}
