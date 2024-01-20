<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use App\Models\StudySet;

class TermController extends Controller
{
    public function store(Request $request){
        try{
            $user= $request->user();
            $request->validate([
                'term' => 'required',
                'definition' => 'required',
                'study_set_id'=>'required',
                'image'=>'required|mimes:jpeg,png,jpg,gif',
            ]);
            StudySet::where('owner_id',$user->id)->findOrFail((int) $request->study_set_id);
            $image= $request->file('image');
            $path=$image->move('storage/terms', $image->hashName());
            $image_url= asset($path);
            $term= new Term();
            $term->term= $request->term;
            $term->definition= $request->definition;
            $term->image_url=$image_url;
            $term->study_set_id= (int) $request->study_set_id;
            $term->save();
            return $term;
        }catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }
}
