<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function section_by_id_from_purchased_course(Request $request)
    {
        $section = Section::where('id', $request->section_id)->with('lessons.quizzes')->first();
        if ($section) {
            $course_id = Code::where('user_id', Auth::guard('api')->user()->id)->where('course_id', $section->course_id)->first();

            if ($course_id) {
                //  $section = Section::where('id', $request->section_id)->where('course_id', $request->course_id)->with('lessons')->first();

                return response()->json([
                    'message' => 'data fetched successfully',
                    'code' => 200,
                    'status' => true,
                    'section' => $section,
                ]);
            } else {

                return response()->json([
                    'errors' => [
                        'course' => [
                            'يجب عليك شراء الدورة أولا.',
                        ],
                    ],
                    'status' => false,
                    'code' => 404,
                ]);
            }
        } else {
            return response()->json([
                'errors' => [
                    'section' => [
                        'هذا الفصل غير موجود أو غير تابع لهذه الدورة',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }
}
