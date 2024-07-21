<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Collection extends Model
{
    use HasFactory;

    protected $table = 'collections';

    protected $fillable = ['name', 'slug', 'description', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Collection::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Collection::class, 'parent_id');
    }

    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'collection_publication');
    }

    /**
     * Scope a query to only include collection matching the search term.
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

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($collection) {
            $collection->slug = $collection->generateUniqueSlug($collection->name);
        });
    }

    public function generateUniqueSlug($title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
