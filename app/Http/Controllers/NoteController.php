<?php

namespace App\Http\Controllers;

use App\Note;
use App\Tag;
use App\Category;
use Auth;
use Illuminate\Http\Request;
use App\Repositories\NoteRepository;
use App\Http\Requests\NoteCreateRequest;

class NoteController extends Controller
{
    private $noteRepository;
    
    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::pluck('name','id');
        $categories = Category::pluck('name','id');
        return view('note.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoteCreateRequest $request)
    {
        Auth::loginUsingId(1);
        $tags = $this->noteRepository->createNotes($request->get('tags'));
        $data = [
            'title' => $request->get('title'),
            'category_id' => $request->get('category'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ];
        $note = Note::create($data);
        Category::find($request->get('category'))->increment('notes_count');
        Auth::user()->increment('notes_count');
        $note->tags()->attach($tags);
        dd($note->toArray());
        return redirect()->action('NoteController@show', ['id' => $note->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        $tags = Tag::pluck('name','id');
        $categories = Category::pluck('name','id');
        return view('note.create', compact('note', 'tags', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(NoteCreateRequest $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
    }
}
