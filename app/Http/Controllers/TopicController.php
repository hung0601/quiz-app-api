<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        try {
            return Topic::take(20)->get();
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }
    public function search(Request $request)
    {
        try {
            $searchStr='';
            if(isset($request->search)) $searchStr=$request->search;
            return Topic::where('name', 'like', "%$searchStr%")->limit(20)->get();
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:topics',
            ]);
            $topic= Topic::create([
                'name'=> $request->name
            ]);
            return  $topic;
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 400);
        }
    }
}
