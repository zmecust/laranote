<?php

namespace App\Http\Controllers;

use App\Note;
use App\Tag;
use App\Category;
use Auth;
use Illuminate\Http\Request;
use App\Repositories\NoteRepository;
use App\Http\Resources\NoteCollection;
use App\Transform\ImportantTransformer;
use App\Http\Requests\NoteCreateRequest;

class NoteController extends Controller
{
    private $noteRepository;

    private $importantTransformer;
    
    public function __construct(ImportantTransformer $importantTransformer, NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
        $this->importantTransformer = $importantTransformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $category = $this->noteRepository->createCategory($request->get('category'));
        $tags = $this->noteRepository->createNotes($request->get('tags'));
        $data = [
            'title' => $request->get('title'),
            'category_id' => $category,
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ];
        $note = Note::create($data);
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
        // return view('note.show', compact('note'));
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
            if ($note->category->notes_count > 0) {
                $note->category->decrement('notes_count');
            }
            return $this->responseSuccess('删除用户信息成功');
        }
        return $this->responseError('删除用户信息失败');
    }

    public function important()
    {
        $notes = Note::where('is_important', 'T')->where('user_id', Auth::id())->with('category', 'tags')->get();
        return $this->responseSuccess('Ok', $this->importantTransformer->transformCollection($notes->toArray()));
    }

    public function trash()
    {
        $notes = Note::onlyTrashed()->where('user_id', Auth::id())->with('category', 'tags')->get();
        return $this->responseSuccess('Ok', $this->importantTransformer->transformCollection($notes->toArray()));
    }

    public function changeImportant($id)
    {
        $note = Note::find($id);
        if (empty($note)) {
            return $this->responseError('not found this note');
        }
        if ($note->is_important == 'T') {
            $note->is_important = 'F';
            $note->save();
        } else {
            $note->is_important = 'T';
            $note->save();
        }
        return $this->responseSuccess('OK');
    }

    public function getCount()
    {
        $data = [
            'trash_count' => Note::where('user_id', Auth::id())->onlyTrashed()->get()->count(),
            'important_count' => Note::where(['is_important' => 'T', 'user_id' => Auth::id()])->get()->count()
        ];
        return $this->responseSuccess('OK', $data);
    }

    public function untrash($id)
    {
        Note::where('id', $id)->restore();
        Note::find($id)->category->increment('notes_count');
        return $this->responseSuccess('OK');
    }

    public function trashForever($id)
    {
        $note = Note::withTrashed()->find($id);
        if ($note) {
            \DB::transaction(function () use ($note) {
                $category = $note->category;
                $category->decrement('notes_count');
                    if ($category->notes_count <= 0) {
                        $category->delete();
                    }
                $note->user->decrement('notes_count');
                $note->forceDelete();
            });
            return $this->responseSuccess('OK');
        }
        return $this->responseError('删除失败');
    }
}
