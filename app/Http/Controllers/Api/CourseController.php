<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Code;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\totalPoints;
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

    public function course_by_id(Request $request)
    {
        $requested_course = Course::where('id', $request->course_id)->first();
        $course_id = Code::where('user_id', Auth::guard('api')->user()->id)->where('course_id', $request->course_id)->first();
        $top_students = totalPoints::where('course_id', $request->course_id)->orderBy('total_points', 'desc')->get();

        if ($requested_course->is_free == 0 && isset($course_id)) {

            $sections = Section::where('course_id', $request->course_id)->with('lessons')->get();


            if ($sections->count() > 0) {
                $requested_course->sections = $sections;


                $requested_course['top students'] = $top_students;


                return response()->json([
                    'message' => 'data fetched successfully',
                    'code' => 200,
                    'status' => true,
                    'course' => $requested_course,

                ]);
            }
        } elseif ($requested_course->is_free == 0 && !isset($course_id)) {
            $sections = Section::where('course_id', $request->course_id)->pluck('id');
            $lessons = Lesson::whereIn('section_id', $sections)->where('type', 1)->get();
            if ($lessons->count() > 0) {

                return response()->json([
                    'message' => 'data fetched successfully',
                    'code' => 200,
                    'status' => true,
                    'course' => $requested_course,
                    'lessons' => $lessons,
                ]);
            }
        } elseif ($requested_course->is_free == 1) {
            $sections = Section::where('course_id', $request->course_id)->pluck('id');
            $lessons = Lesson::whereIn('section_id', $sections)->get();

            $requested_course['top students'] = $top_students;
            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'course' => $requested_course,
                'lessons' => $lessons,
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
