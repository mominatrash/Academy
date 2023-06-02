<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Course;
use App\Models\Subject;
use Mockery\Matcher\Subset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SubjectController extends Controller
{
    public function show_subjects()
    {
        $subjects = Subject::with('levels')->get();

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'status' => true,
            'subjects' => $subjects
        ]);
    }

    public function get_courses_from_subject(Request $request)
    {

        if($request->level_id == 0){
            $levels=Level::where('subject_id',$request->subject_id)->pluck('id');
            $courses=Course::whereIn('level_id',$levels)->get();
        }else{
            $courses=Course::where('level_id',$request->level_id)->get();
        }


      
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status'=>true,
            'data'=>$courses
        ]);
    }

}
