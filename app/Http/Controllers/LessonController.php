<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function lesson_by_id(Request $request)
    {

        $lesson = Lesson::where('id', $request->lesson_id)->first();

        if($lesson->type == 1){

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'course' => $lesson, 
            ]);
        }else{

            
        }


    }
}
