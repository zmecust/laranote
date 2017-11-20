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
        Auth::loginUsingId(1);
        $notes = Category::select('id', 'name')->with(['notes' => function ($query) {
            $query->select('id', 'title', 'is_important', 'category_id', 'created_at')->where('user_id', Auth::id())->get();
        }])->get();
        return $this->responseSuccess('OK', $notes);
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

    public function store(NoteCreateRequest $request)
    {
        //dd($request->all());
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
        // $note->body = \MarkdownEditor::parse($note->body);
        //return view('note.show', compact('note'));
        return $this->responseSuccess('Ok', Note::where('id', $note->id)->with('category', 'tags')->first());
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
        return view('note.edit', compact('note', 'tags', 'categories'));
    }

    public function update(NoteCreateRequest $request, Note $note)
    {
        Auth::loginUsingId(1);
        $data = [
            'title' => $request->get('title'),
            'category_id' => $request->get('category'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ];
        $note->update($data);
        if ($addTags = $this->noteRepository->editNotes($request->get('tags'), $note->id)) {
            foreach ($addTags as $addTag) {
                if (! is_numeric($addTag)) {
                    $note->tags()->create([
                        'name' => $addTag,
                        'articles_count' => 1,
                        'user_id' => Auth::id()
                    ]);
                } else {
                    $note->tags()->attach($addTag);
                    Tag::where('id', $addTag)->increment('count', 1);
                }
            }
        }
        return $this->responseSuccess('OK');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();
        if ($note->trashed()) {
            return $this->responseSuccess('删除用户信息成功');
        } else {
            return $this->responseError('删除用户信息失败');
        }
    }
}
