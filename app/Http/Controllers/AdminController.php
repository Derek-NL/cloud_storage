<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Controleer of de gebruiker admin is
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Je hebt geen toegang tot deze pagina.');
        }

        // Haal de meest geüploade bestanden per gebruiker op
        $mostUploadedFiles = DB::table('files')
            ->select('user_id', DB::raw('count(*) as total_uploads'))
            ->groupBy('user_id')
            ->orderBy('total_uploads', 'desc')
            ->limit(5)
            ->get();

        // Haal het aantal actieve sessies op
        $activeSessions = DB::table('sessions')->count();

        // Tel het aantal PNG, JPEG, en JPG bestanden
        $fileCounts = File::select(DB::raw('
                SUM(CASE WHEN filename LIKE "%.png" THEN 1 ELSE 0 END) as png_count,
                SUM(CASE WHEN filename LIKE "%.jpg" OR filename LIKE "%.jpeg" THEN 1 ELSE 0 END) as jpg_count
            '))
            ->first();

        return view('admin.dashboard', [
            'mostUploadedFiles' => $mostUploadedFiles,
            'activeSessions' => $activeSessions,
            'fileCounts' => $fileCounts,
        ]);
    }
}
