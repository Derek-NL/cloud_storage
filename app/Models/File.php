<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    // Geef aan welke velden massaal kunnen worden toegewezen
    protected $fillable = [
        'user_id',
        'filename',
        'path',
    ];

    // Relatie met de User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relatie met de SharedFile model (voor gedeelde bestanden)
    public function sharedFiles()
    {
        return $this->hasMany(SharedFile::class);
    }
}
            