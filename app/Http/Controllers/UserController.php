<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request){
        $user= $request->user();
        return User::withCount('courses')->withCount('study_sets')->find($user->id);
    }
    public function topCreators(){
        $top_creators= User::withCount('courses')->withCount('study_sets')->orderBy('study_sets_count','desc')->get();
        return $top_creators;
    }
}
