<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'notes_count', 'user_id'];

    public function notes()
    {
        return $this->belongsToMany(Note::class)->withTimestamps();
    }
}
