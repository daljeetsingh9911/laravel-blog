<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
