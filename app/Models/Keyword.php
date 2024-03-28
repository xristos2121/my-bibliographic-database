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

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'publication_keyword');
    }

}
