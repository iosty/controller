<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FormationController extends Controller
{
    public function index(){
        return Formation::all();
    }

    public function save(Request $request){
        $formation = new Formation();
        $formation->intitule = $request->intitule;
        $formation->type = $request->type;
        $formation->description = $request->description;
        $formation->cout = $request->cout;
        $formation->lieu = $request->lieu;
        $formation->duree = $request->duree;
        $formation->save();
        return response($formation,201)->json();
    }
    public function show($id){
        return Formation::find($id);
    }
    public function update(Request $request,$id){
        $formation = Formation::find($id);
        $formation->intitule = $request->intitule;
        $formation->type = $request->type;
        $formation->description = $request->description;
        $formation->cout = $request->cout;
        $formation->lieu = $request->lieu;
        $formation->duree = $request->duree;
        $formation->save();
        return $formation;
    }

    public function delete(Request $request,$id){
        $formation = Formation::find($id);
        $formation->delete();
        return response("supression reussi",200);
    }

    public function register(Request $request){
        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password)
        ]);
        return $user->createToken("Bearer");
    }

    public function login(Request $request){
        $candidate = User::where('email',$request->email)->get();
        if ($candidate) {
            if (Auth::attempt($request->all())) {
                $user = User::find($candidate[0]->id);
                return $user->createToken("Bearer");
            }
        }
    }
}
