<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class Publication extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'publications';

    // The attributes that are mass assignable.
    protected $fillable = [
        'title',
        'abstract',
        'publication_date',
        'type_id',
        'category_id',
        'publisher_id',
        'file',
        'slug',
        'active',
    ];

    protected $dates = [
        'publication_date',
    ];

    protected $attributes = [
        'active' => true,
    ];

    public function getPublicationDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m');
    }

    public function setPublicationDateAttribute($value)
    {
        $this->attributes['publication_date'] = Carbon::createFromFormat('Y-m', $value)->startOfMonth();
    }

    /**
     * Get the category associated with the publication.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The tags that belong to the publication.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'publication_tags'); // assuming you have a Tag model and publication_tags pivot table
    }

    /**
     * Get the type associated with the publication.
     */
    public function types(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id'); // Ensure the foreign key is specified correctly
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_publications');
    }

    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'publication_keyword');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_publication');
    }

    public function uris()
    {
        return $this->hasMany(PublicationUri::class);
    }

    public function hasPublisher(): bool
    {
        return !empty($this->publisher_id);
    }

    public function hasKeywords()
    {
        return $this->keywords->isNotEmpty();
    }

    public function hasCategories()
    {
        return $this->categories->isNotEmpty();
    }

    public function customFields()
    {
        return $this->hasMany(CustomField::class);
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($publication) {
            $publication->slug = $publication->generateUniqueSlug($publication->title);
        });

        static::updating(function ($publication) {
            if ($publication->isDirty('title')) {
                $publication->slug = $publication->generateUniqueSlug($publication->title);
            }
        });

        static::deleting(function ($publication) {
            $publication->customFields()->delete();
            $publication->uris()->delete();

            if ($publication->file) {
                Storage::disk('public')->delete($publication->file);
            }
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
