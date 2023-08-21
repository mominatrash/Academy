<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Lesson_Attachment;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LessonController extends Controller
{
    public function show_lessons($id = null)
    {
        $sections = Section::get();

        if ($id == null) {
            return view('lessons.lessons', compact('sections'));
        } else {

            return view('lessons.lessons', compact('sections', 'id'));
        }
    }



    public function get_lessons_data(Request $request, $id = null)
    {

        if ($request->ajax()) {

            if ($id == null) {
                $data = Lesson::get();
            } else {
                $data = Lesson::where('section_id', $id)->get();
            }


            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    return view('lessons.btns.actions', compact('data'));
                })

                ->addColumn('section_id', function ($data) {

                    return $data->section->name . ' (<span style="color: gray;">' . $data->section->course->name . '</span>)';




                    // '.route('show_lessons', ['id' => $data->id]).'
                })


                ->addColumn('quizzes_count', function ($data) {
                    if (auth()->user()->can('الاختبارات')) {
                        return '<a href="'.route('show_quizzes', ['id' => $data->id]).'"><button class="btn btn-sm btn-primary">' . $data->quizzes->count() . '</button></a>';
                    } else {
                        return $data->quizzes->count();
                    }
                })
                

                ->addColumn('type', function ($data) {
                    if ($data->type === 0) {

                        return  ' <span class="badge badge-secondary">مدفوع <i class="fa fa-lock"></i></span> ';
                    } elseif ($data->type === 1) {
                        return  '<span class="badge badge-success">مجاني <i class="fa fa-check"></i></span>';
                    }
                })

                ->addColumn('video_link', function ($data) {
                    if (auth()->user()->can('عرض فيديو الدروس')) {
                        return '<a href="' . $data->video_link . '" target="_blank"><button class="btn btn-sm btn-light ">' . 'إضغط لعرض الفيديو' . '</button></a>';
                    } else {
                        return '***'; // Or any other message you want to display if the user doesn't have permission
                    }
                })

                ->addColumn('attachments', function ($data) {
                    if (auth()->user()->can('عرض مرفقات الدروس')) {
                        return '<a href="' . route('show_lesson_attachments', ['id' => $data->id]) . '"><button class="btn btn-sm btn-primary">' . $data->attachments->count() . '</button></a>';
                    } else {
                        return $data->attachments->count();
                    }
                })
                

                ->rawColumns(['name', 'quizzes_count', 'type', 'video_link', 'section_id', 'attachments'])

                ->make(true);
        }
    }











    public function store_lesson(Request $request)
    {

        $request->validate([
            'name'   => 'required',

        ]);

        $lesson = new Lesson();
        $lesson->name = $request->name;
        $lesson->section_id = $request->section_id;
        $lesson->description = $request->description;
        $lesson->video_link = $request->video_link;
        $lesson->save();

        return response()->json([]);
    }


    public function update_lesson(Request $request)
    {


        $lesson = Lesson::where('id', $request->id)->first();

        $lesson->name = $request->lesson_name;
        $lesson->course_id = $request->section_id;
        $lesson->save();

        return response()->json([]);
    }


    public function delete_lesson(Request $request)
    {
        $lesson = Lesson::find($request->id);
        $lesson->delete();
        return response()->json([]);
    }




    // attachments


    public function show_lesson_attachments($id)
    {
        $lessons = Lesson::get();

        return view('lessons.attachments', compact('lessons', 'id'));
    }




    public function get_lesson_attachments_data(Request $request, $id)
    {

        if ($request->ajax()) {

            $data = Lesson_Attachment::where('lesson_id', $id)->get();
            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    return view('lessons.btns.attachments_actions', compact('data'));
                })

                ->addColumn('file_link', function ($data) {

                    return '<a href="' . $data->file_link . '" target="_blank"><button class="btn btn-sm btn-primary"><i class="fas fa-solid fa-eye"></i> عرض المرفق</button></a>&nbsp;' . '<a href="' . $data->file_link . '" download><button class="btn btn-sm btn-success"><i class="fas fa-download"></i> تحميل المرفق</button></a>';

                })


                ->rawColumns(['file_name', 'file_link'])
                ->make(true);
        }
    }




    public function store_lesson_attachment(Request $request){

        $request->validate([
            'file_name'   => 'required',
            'lesson_id'   => 'required',
            'file_link'   => 'required',

        ]);

        $attachment_file = $request->file('file_link');
        $attachment = $attachment_file->getClientOriginalName();

        $lesson_attachment = new Lesson_Attachment();
        $lesson_attachment->file_name = $request->file_name;
        $lesson_attachment->lesson_id = $request->lesson_id;

        $lesson_attachment->file_link = asset('Attachments/' . 'Lesson_Files/'.$lesson_attachment->file_name . '/' . $attachment);
        $lesson_attachment -> save();

        $attachment_file->move(public_path('Attachments/' . 'Lesson_Files/'. $lesson_attachment->file_name), $attachment);

        return response()->json([]);
    }


    public function update_lesson_attachment(Request $request){

        $request->validate([
            'file_name'   => 'required',
            'lesson_id'   => 'required',

        ]);
        $lesson_attachment = Lesson_Attachment::where('id' , $request->id)->first();
        $attachment_file = $request->file('file_link');
        $attachment = $attachment_file->getClientOriginalName();

        if ($request->hasFile('file_link')) {
            
            $fileToDelete = 'Attachments/Lesson_Files/تيست2/screen.png';

            if (Storage::disk('public')->exists($fileToDelete)) {
                Storage::disk('public')->delete($fileToDelete);
                return 'File deleted successfully.';
            } else {
                return 'File not found.';
            }
            


        $lesson_attachment->file_name = $request->file_name;
        $lesson_attachment->lesson_id = $request->lesson_id;
        $lesson_attachment->file_link = asset('Attachments/' . 'Lesson_Files/'.$lesson_attachment->file_name . '/' . $attachment);
        $lesson_attachment->save();
        $attachment_file->move(public_path('Attachments/' . 'Lesson_Files/'. $lesson_attachment->file_name), $attachment);

        return response()->json([]);

        }else{

            $lesson_attachment->file_name = $request->file_name;
            $lesson_attachment->lesson_id = $request->lesson_id;
            $lesson_attachment->save();

            return response()->json([]);
        }

    }




    public function delete_lesson_attachment(Request $request){
        $lesson_attachment = Lesson_Attachment::find($request->id);
        $lesson_attachment->delete();
        return response()->json([]);

    }
}
