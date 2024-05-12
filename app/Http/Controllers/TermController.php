<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use App\Models\StudySet;
use Illuminate\Support\Facades\DB;
use function array_map;
use function var_dump;

class TermController extends Controller
{
    public function store(Request $request){
        try{
            $user= $request->user();
            $request->validate([
                'term' => 'required',
                'definition' => 'required',
                'study_set_id'=>'required',
                'image'=>'mimes:jpeg,png,jpg,gif',
            ]);
            StudySet::where('owner_id',$user->id)->findOrFail((int) $request->study_set_id);
            $term= new Term();
            $image= $request->file('image');
            if(!empty($image)){
                $path=$image->move('storage/terms', $image->hashName());
                $image_url= asset($path);
                $term->image_url=$image_url;
            }
            $term->term= $request->term;
            $term->definition= $request->definition;
            $term->study_set_id= (int) $request->study_set_id;
            $term->save();
            return $term;
        }catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }
    public function multiStore(Request $request){
        try{
            $user= $request->user();
            $request->validate([
                'study_set_id'=>'required',
                'terms' => 'required|array|min:1',
                'terms.*.term' => 'required|string',
                'terms.*.definition' => 'required|string'
            ]);
            StudySet::where('owner_id',$user->id)->findOrFail((int) $request->study_set_id);
            $studySetId = $request->input('study_set_id');
            $terms = $request->input('terms');
            $termInsertData= array_map(function ($term) use ($studySetId) {
                return [
                    'study_set_id' => $studySetId,
                    'term' => $term['term'],
                    'definition' => $term['definition']
                ];
            }
            ,$terms);
            DB::beginTransaction();
            try {
                Term::insert($termInsertData);
                DB::commit();
                return response()->json(['message' => 'Terms inserted successfully'], 201);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => 'Failed to insert terms'], 500);
            }

        }catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }
    public function update(Request $request){
        try{
            $user= $request->user();
            $request->validate([
                'term_id'=>'required|numeric',
                'term' => 'required',
                'definition' => 'required',
                'image'=>'mimes:jpeg,png,jpg,gif',
            ]);
            $term= Term::findOrFail($request->term_id);
            if($term->study_set->owner_id != $user->id){
                return response()->json([
                    'message' => 'Unauthorized',
                ],401);
            }
            $image= $request->file('image');
            if(empty($request->image_url))  $term->image_url=null;
            if(!empty($image)){
                $path=$image->move('storage/terms', $image->hashName());
                $image_url= asset($path);
                $term->image_url=$image_url;
            }
            $term->term= $request->term;
            $term->definition= $request->definition;
            $term->save();
            unset($term->study_set);
            return $term;
        }catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }
}
