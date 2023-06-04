<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function latest_courses()
    {
        $latest = Course::OrderBy('id', 'desc')->paginate(5);


        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'data' => $latest,
        ]);
    }


    public function course_by_id(Request $request)
    {

        $course = Course::where('id', $request->course_id)->first();


        // $courses=Course::where('course_id',$request->course)->pluck('id');

        $sections = Section::where('course_id', $request->course_id)->pluck('id');
        $lessons = Lesson::whereIn('section_id', $sections)->where('type', 1)->get();

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'status' => true,
            'course' => $course,
            'lessons' => $lessons
        ]);
    }

    public function my_Courses()
    {
        $my_courses = Code::where('user_id', Auth::guard('api')->user()->id)->pluck('course_id');
        $courses = Course::whereIn('id', $my_courses)->get();


        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'status' => true,
            'my courses' => $courses,
        ]);
    }

    public function course_by_id_from_myCourses(Request $request)
    {
        $course_id = Code::where('user_id', Auth::guard('api')->user()->id)->where('course_id', $request->course_id)->first();

        if ($course_id) {
            $requested_course = Course::where('id', $course_id->course_id)->first();
            $sections = Section::where('course_id', $request->course_id)->with('lessons')->get();

            $requested_course->sections = $sections;

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'course' => $requested_course,
            ]);
        } else {
            return response()->json([
                'errors' => [
                    'phone' => [
                        '!يجب عليك شراء الدورة أولا',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }
}
