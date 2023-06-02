<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function course_by_id(Request $request){

        $course = Course::where('id', $request->course_id)->first();
        

        // $courses=Course::where('course_id',$request->course)->pluck('id');

        $sections= Section::where('course_id',$request->course_id)->pluck('id');
        $lessons = Lesson::whereIn('section_id', $sections )->where('type', 1)->get();

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'status' => true,
            'course' => $course,    
            'lessons' => $lessons
        ]);

    }
}
