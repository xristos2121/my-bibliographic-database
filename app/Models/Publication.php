<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'category_id'
    ];

    // The attributes that should be cast.
    protected $casts = [
        'publication_date' => 'date',
    ];

    /**
     * Get the category associated with the publication.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The tags that belong to the publication.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'publication_tags'); // assuming you have a Tag model and publication_tags pivot table
    }

    /**
     * Get the type associated with the publication.
     */
    public function types()
    {
        return $this->belongsTo(Type::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_publications');
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'publication_keyword');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

}
