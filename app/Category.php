<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'notes_count'];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
