<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['user','tags'])->latest()->paginate();
 
        return view("articles.index",compact("articles"));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        
        $categories = Category::pluck('name','id');
        $tags = Tag::pluck('name','id');
        return view("articles.create",compact("categories",'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
       $article = Article::create([
        'slug' =>  Str::slug($request->name),
        'name' => $request->name,
        'excerpt' => $request->excerpt,
        'description' => $request->description,
        'category_id'=> $request->category_id,
        'user_id'=> auth()->user()->id,
        'status'=> ($request->status == 'on'? '1' : '0')
       ]);

       // for storing records inside paviot table
       $article->tags()->attach($request->tags);

       return redirect(route('articles.index'))
                    ->with('message','Article has been successfullt created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        
        return view("articles.show", compact("article"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $artical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $artical)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $artical)
    {
        //
    }
}
