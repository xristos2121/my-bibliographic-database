<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldDefinition extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public function customFields()
    {
        return $this->hasMany(CustomField::class);
    }

    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'custom_fields');
    }
}
