<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $table = 'publication_types';

    protected $fillable = ['name'];

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
}
