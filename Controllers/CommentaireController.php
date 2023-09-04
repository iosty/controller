<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    public function save(Request $request){
        $coment = new Commentaire();
        $coment->contenue = $request->contenue;
        $coment->article_id = $request->id;
        $coment->user_id = Auth::user()->id;
        $coment->save();
        return  redirect('details?id='. $request->id);
        // $control = new ArticleController();
        // return $control->details($request);
    }
}
