<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use App\Models\StudySet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use function array_map;
use function var_dump;

class TermController extends Controller
{
    public function store(Request $request){
        try{
            $request->validate([
                'term' => 'required',
                'definition' => 'required',
                'study_set_id'=>'required',
                'image'=>'mimes:jpeg,png,jpg,gif',
            ]);
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
            $request->validate([
                'study_set_id'=>'required',
                'terms' => 'required|array|min:1',
                'terms.*.term' => 'required|string',
                'terms.*.definition' => 'required|string'
            ]);
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
    public function update(Request $request, $id){
        try{
            $user= $request->user();
            $request->validate([
                'term' => 'required|string',
                'definition' => 'required|string',
                'image'=>'mimes:jpeg,png,jpg,gif|nullable',
            ]);
            $term= Term::findOrFail($id);
            if($request->has("image")) {
                $image = $request->file('image');
                if ($term->image_url) {
                    $relativePath = str_replace(url('/') . '/', '', $term->image_url);
                    if (File::exists($relativePath)) {
                        File::delete($relativePath);
                    }
                }
                if (!empty($image)) {
                    $path = $image->move('storage/terms', $image->hashName());
                    $image_url = asset($path);
                    $term->image_url = $image_url;
                }else{
                    $term->image_url = null;
                }
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

    public function destroy(Request $request, $id){
        try{
            $user= $request->user();
            $term= Term::findOrFail($id);
            if ($term->image_url) {
                $relativePath = str_replace(url('/') . '/', '', $term->image_url);
                if (File::exists($relativePath)) {
                    File::delete($relativePath);
                }
            }
            $term->delete();
            return true;
        }catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ],400);
        }
    }
}
