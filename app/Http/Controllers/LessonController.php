<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Lesson_Attachment;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

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
        $attachments = Lesson_Attachment::where('lesson_id' , $request->lesson_id)->get();

        if($attachments->count() > 0){

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'attachment' => $attachments, 
            ]);
        }else{
 
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
