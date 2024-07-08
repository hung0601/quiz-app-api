<?php

namespace App\Http\Middleware;

use App\Models\StudySet;
use App\Models\Term;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use function response;

class CheckAccessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $study_set_id = null;
        if (isset($request->id)) {
            $term = Term::find($request->id);
            if (!$term) return response()->json([
                'message' => 'Term not found',
            ], 404);
            $study_set_id = $term->study_set_id;
        } else if (isset($request->study_set_id)) {
            $study_set_id = $request->study_set_id;
        }

        if (!$study_set_id) return response()->json([
            'message' => 'Bad request',
        ], 400);

        $set = StudySet::find($study_set_id);
        if (!$set) return response()->json([
            'message' => 'Term not found',
        ], 404);
        if($set->owner_id == $user->id) return $next($request);
        $editable = DB::table('study_set_access')
            ->where('study_set_id', $study_set_id)
            ->where('user_id', $user->id)
            ->where('access_level', StudySet::EDIT_ACCESS_LEVEL)
            ->first();
        if(!$editable) return response()->json([
            'message' => 'Unauthorized',
        ], 401);
        return $next($request);
    }
}
