<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuizController extends Controller
{
    public function show_quizzes($id = null)
    {
        $lessons = Lesson::get();
        $quizzes = Quiz::get();

        if ($id == null) {
            return view('quizzes.quizzes', compact('lessons' , 'quizzes'));
        } else {

            return view('quizzes.quizzes', compact('lessons', 'quizzes' , 'id'));
        }
    }



    public function get_quizzes_data(Request $request, $id = null)
    {

        if ($request->ajax()) {

            if ($id == null) {
                $data = Quiz::get();
            } else {
                $data = Quiz::where('lesson_id', $id)->get();
            }


            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {

                    return view('quizzes.btns.actions', compact('data'));
                })

                ->addColumn('lesson_id', function ($data) {

                    return $data->lesson->name . ' (<span style="color: gray;">' . $data->lesson->section->name . '</span>)';




                    // '.route('show_quizzes', ['id' => $data->id]).'
                })


                ->addColumn('questions_number', function ($data) {

                    return '<a href="'.route('show_questions', ['id' => $data->id]).'"><button class="btn btn-sm btn-primary">' . $data->questions->count() . '</button></a>';
                    // '.route('show_quizzes', ['id' => $data->id]).'
                })




                ->rawColumns(['action','name', 'questions_number', 'lesson_id', ])

                ->make(true);
        }
    }








    public function store_quiz(Request $request)
    {

        $request->validate([
            'name'   => 'required',

        ]);

        $quiz = new Quiz();
        $quiz->name = $request->name;
        $quiz->lesson_id = $request->lesson_id;
        $quiz->type = $request->type;
        $quiz->input_type = $request->input_type;
        $quiz->points = $request->points;
        $quiz->time = $request->time;
        $quiz->questions_number = $request->questions_number;
        $quiz->attempts = $request->attempts;
        $quiz->deduction_per_attempt = $request->deduction_per_attempt;
        $quiz->notes = $request->notes;
        $quiz->save();

        return response()->json([]);
    }


    public function update_quiz(Request $request)
    {


        $quiz = Quiz::where('id', $request->id)->first();

        $quiz->name = $request->name;
        $quiz->lesson_id = $request->lesson_id;
        $quiz->type = $request->type;
        $quiz->input_type = $request->input_type;
        $quiz->points = $request->points;
        $quiz->time = $request->time;
        $quiz->questions_number = $request->questions_number;
        $quiz->attempts = $request->attempts;
        $quiz->deduction_per_attempt = $request->deduction_per_attempt;
        $quiz->notes = $request->notes;
        $quiz->save();

        return response()->json([]);
    }


    public function delete_quiz(Request $request)
    {
        $quiz = Quiz::find($request->id);
        $quiz->delete();
        return response()->json([]);
    }
}
