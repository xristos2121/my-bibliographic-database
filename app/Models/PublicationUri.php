<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationUri extends Model
{
    use HasFactory;

    protected $table = 'publication_uri';

    protected $fillable = ['publication_id', 'uri'];

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
}
