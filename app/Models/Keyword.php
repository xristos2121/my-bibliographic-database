<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;
    protected $table = 'keywords';

    protected $fillable = [
        'keyword',
    ];

    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'publication_keywords');
    }
}
