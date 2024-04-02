<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    /**
     * Scope a query to only include categories matching the search term.
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
                    ->orWhere('name', 'like', "%{$search}%");
            } else {
                return $query->where('name', 'like', "%{$search}%");
            }
        }

        return $query;
    }

}
