<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedFile extends Model
{
    use HasFactory;

    // Geef aan welke velden massaal toewijsbaar zijn
    protected $fillable = [
        'file_id',
        'user_id',
        'email',
    ];

    // Relatie met het File-model
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    // Relatie met het User-model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
