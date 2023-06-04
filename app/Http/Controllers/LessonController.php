<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Lesson_Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{

    public function add_attachment_lesson(Request $request)
    {
        $attachmentFile = $request->file('attachment');
        $file_name = $attachmentFile->getClientOriginalName();

        $attachment = new Lesson_Attachment();
        $attachment->file_name = $file_name;
        $attachment->lesson_id = $request->lesson_id;

        $attachment->file_link = asset('Attachments/' . $request->lesson_id . '/' . $file_name);

        $attachment->save();


        $fileName = $file_name;
        $attachmentFile->move(public_path('Attachments/' . $request->lesson_id), $fileName);

        return response()->json([
            'message' => 'تم ارفاق الملف للدرس بنجاح',
            'code' => 200,
            'status' => true,
            'attachment' => $attachment,
        ]);
    }

    public function show_attachments_for_lesson(Request $request)
    {
        $attachments = Lesson_Attachment::where('lesson_id', $request->lesson_id)->get();

        if ($attachments->count() > 0) {

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'attachment' => $attachments,
            ]);
        } else {

            return response()->json([
                'errors' => [
                    'phone' => [
                        'لا يوجد مرفقات لهذا الدرس',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }

    // public function show_download_attachment(Request $request)
    // {
    //     $attachment = Lesson_Attachment::where('id' , $request->attachment_id)->where('lesson_id' , $request->lesson_id)->first('file_link');

    //     return response()->json([
    //         'code' => 200,
    //         'status' => true,
    //         'attachment' => $attachment,
    //     ]);
    // }

    public function lesson_by_id(Request $request)
    {

        $lesson1 = Lesson::where('id', $request->lesson_id)->with('comments' , 'attachments')->first();

        if ($lesson1) {

            if ($lesson1->type == 1) {

                return response()->json([
                    'message' => 'data fetched successfully',
                    'code' => 200,
                    'status' => true,
                    'course' => $lesson1,
                ]);
            } else {
                $section = Section::where('id', $lesson1->section_id)->first();
                $course_id = Code::where('user_id', Auth::guard('api')->user()->id)->where('course_id', $request->course_id)->first();

                if ($course_id) {
                    // $section = Section::where('id', $lesson->section_id)->where('course_id', $request->course_id)->first();
                    $lesson = Lesson::where('section_id', $section->id)->with('comments' , 'attachments')->first();


                    return response()->json([
                        'message' => 'data fetched successfully',
                        'code' => 200,
                        'status' => true,
                        'section' => $lesson,
                    ]);
                } else {

                    return response()->json([
                        'errors' => [
                            'phone' => [
                                'يجب شراء الدورة أولا',
                            ],
                        ],
                        'status' => false,
                        'code' => 404,
                    ]);
                }
            }
        } else {
            return response()->json([
                'errors' => [
                    'section' => [
                        'الدرس غير موجود',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }
}
