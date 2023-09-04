<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(){
        $articles = Article::all();
        return view('welcome',['articles'=>$articles]);
    }
    public function details(Request $request){
        try {
            $article = Article::find($request->id);
            return view('details',['article'=>$article,'coments'=>$article->commentaire]);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public  function update(Request $request){
        try {
            $article = Article::find($request->id);
            return view("updateArticle",['article'=>$article]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function updateSave(Request $request){
        try {
            $article = Article::find($request->id);
            $article->prix = $request->prix;
            $article->description = $request->description;
            $article->titre = $request->titre;
            $article->save();
            return view('details',['article'=>$article]);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function create(Request $request){
        $request->photo->store('public');
        $article = new Article();
        $article->prix = $request->prix;
        $article->titre = $request->titre;
        $article->description = $request->description;
        $article->photo = $request->photo->hashName();
        // $article->user_id =  Auth::user()->id;
        $article->user_id =  1;
        $article->save();

        return redirect('/');
    }

    public function delete(Request $request){
        $article = Article::find($request->id);
        Storage::delete('public'.$article->photo);
        $article->delete();
        return redirect('/dashboard');
    }
}
