<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Scope a query to only include authors matching the search term.
     *
     * @param  Builder  $query
     * @param  string|null  $search
     * @return Builder
     */
    public function scopeSearch($query, $searchTerms)
    {
        return $query->when($searchTerms['first_name'], function ($q) use ($searchTerms) {
            $q->where('first_name', 'like', "%{$searchTerms['first_name']}%");
        })
            ->when($searchTerms['last_name'], function ($q) use ($searchTerms) {
                $q->where('last_name', 'like', "%{$searchTerms['last_name']}%");
            })
            ->when($searchTerms['email'], function ($q) use ($searchTerms) {
                $q->where('email', 'like', "%{$searchTerms['email']}%");
            })
            ->when($searchTerms['affiliation'], function ($q) use ($searchTerms) {
                $q->where('affiliation', 'like', "%{$searchTerms['affiliation']}%");
            })
            ->when($searchTerms['department'], function ($q) use ($searchTerms) {
                $q->where('department', 'like', "%{$searchTerms['department']}%");
            })
            ->when($searchTerms['position'], function ($q) use ($searchTerms) {
                $q->where('position', 'like', "%{$searchTerms['position']}%");
            })
            ->when($searchTerms['orcid_id'], function ($q) use ($searchTerms) {
                $q->where('orcid_id', 'like', "%{$searchTerms['orcid_id']}%");
            });
    }
}
