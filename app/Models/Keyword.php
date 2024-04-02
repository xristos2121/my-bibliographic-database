<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Scope a query to only include keywords matching the search term.
     *
     * @param  Builder  $query
     * @param  string|null  $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            if (is_numeric($search)) {
                return $query->where('id', $search)
                    ->orWhere('keyword', 'like', "%{$search}%");
            } else {
                return $query->where('keyword', 'like', "%{$search}%");
            }
        }

        return $query;
    }
}
