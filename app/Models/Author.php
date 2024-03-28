<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'affiliation',
        'department',
        'position',
        'orcid_id',
        'profile_picture',
        'biography',
        'research_interests',
    ];

    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'author_publications');
    }
}
