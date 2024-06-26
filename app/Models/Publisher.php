<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $table = 'publishers';

    protected $fillable = [
        'name',
        'site_url'
    ];

    public function publications()
    {
        return $this->hasMany(Publication::class, 'publisher_id');
    }

    /**
     * Scope a query to only include publishers matching the search term.
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
