<?php

namespace App\Repositories;

use App\Tag;
use Cache;
use App\Note;

class NoteRepository
{
    public function createNotes($tags)
    {
        return collect($tags)->map(function ($tag) {
            if (is_numeric($tag)) {
                Tag::find($tag)->increment('notes_count');
                return (int)$tag;
            }
            $newTag = Tag::create(['name' => $tag, 'notes_count' => 1]);
            return $newTag->id;
        })->toArray();
    }

    public function editNotes($tags, $id)
    {
        $oldTags = Note::find($id)->tags->pluck('id')->toArray();
        $reduceTags = array_diff($oldTags, $tags);
        $addTags = array_diff($tags, $oldTags);

        foreach($reduceTags as $reduceTag) {
            $tag = Tag::where('id', $reduceTag);
            $tagCount = $tag->count();
            if ($tagCount > 1) {
                \DB::table('note_tag')->where('tag_id', $reduceTag)->where('note_id', $id)->delete();
                $tag->decrement('count', 1);
            } else {
                $tag->delete();
            }
        }

        if (! is_null($addTags)) {
            return $addTags;
        } else {
            return false;
        }
    }
}
