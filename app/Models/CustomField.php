<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    protected $fillable = ['publication_id', 'field_definition_id', 'value'];

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }

    public function fieldDefinition()
    {
        return $this->belongsTo(FieldDefinition::class);
    }
}
