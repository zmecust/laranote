<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'notes_count'];

    public function notes()
    {
        return $this->belongsToMany(Note::class)->withTimestamps();
    }
}
