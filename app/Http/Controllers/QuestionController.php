<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function show_questions($id = null)
    {
        $quizzes = Quiz::get();

        if ($id == null) {
            return view('questions.questions', compact('quizzes'));
        } else {

            return view('questions.questions', compact('quizzes', 'id'));
        }
    }



    public function get_questions_data(Request $request, $id = null)
    {

        if ($request->ajax()) {

            if ($id == null) {
                $data = Question::get();
            } else {
                $data = Question::where('quiz_id', $id)->get();
            }


            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    return view('questions.btns.actions', compact('data'));
                })

                ->addColumn('quiz', function ($data) {

                    return $data->quiz->name . ' ( <span style="color: gray;">' . $data->quiz->lesson->name . '</span> )';




                    // '.route('show_quizzes', ['id' => $data->id]).'
                })


                ->addColumn('answers_count', function ($data) {

                    return '<a href="' . route('show_answers', ['id' => $data->id]) . '"><button class="btn btn-sm btn-primary">تعديل الإجابات (' . $data->answers->count() . ')</button></a>';



                    //'.route('show_answers', ['id' => $data->id]).'
                })



                ->rawColumns(['name', 'answers_count', 'quiz'])

                ->make(true);
        }
    }





    public function store_question(Request $request , $id)
    {

        $request->validate([
            'questions.*.question'   => 'required',

        ]);


        foreach ($request->questions as $q) {

            // return $question;
            // return $question['question'];
            $question = new Question();
            $question->question = $q['question'];
            $question->quiz_id = $id;
            $question->save();
        }
        // return json_encode($request->question);
        // $question = new Question();
        // $question->question = $request->question;
        // $question->quiz_id = 1;
        // $question -> save();

        // return response()->json([]);
    }


    public function update_question(Request $request)
    {


        $question = Question::where('id', $request->id)->first();
        $question->question = $request->question;
        $question->save();

        return response()->json([]);
    }


    public function delete_question(Request $request)
    {
        $question = Question::find($request->id);
        $question->delete();
        return response()->json([]);
    }
}
