<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnswerController extends Controller
{
    public function show_answers($id = null)
    {
        $questions = Answer::get();

        if ($id == null) {
            return view('questions.answers', compact('questions'));
        } else {

            return view('questions.answers', compact('questions', 'id'));
        }
    }



    public function get_answers_data(Request $request, $id = null)
    {

        if ($request->ajax()) {

            if ($id == null) {
                $data = Answer::get();
            } else {
                $data = Answer::where('question_id', $id)->get();
            }


            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    return view('questions.btns.answers_actions', compact('data'));
                })



                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge badge-success" style="width: 50px; font-size: 12px;">صحيحة</span>';
                    } else {
                        return '<span class="badge badge-danger" style="width: 50px; font-size: 12px;">خاطئة</span>';
                    }
                })
                



                ->rawColumns(['answer', 'status', 'actions'])

                ->make(true);
        }
    }





    public function store_answer(Request $request , $id)
    {

        $request->validate([
            'answers.*.answer'   => 'required',

        ]);


        foreach ($request->answers as $a) {

            // return $answer;
            // return $answer['answer'];
            $answer = new Answer();
            $answer->answer = $a['answer'];
            $answer->status = $a['status'];
            $answer->question_id = $id;
            $answer->save();
        }
        // return json_encode($request->answer);
        // $answer = new answer();
        // $answer->answer = $request->answer;
        // $answer->quiz_id = 1;
        // $answer -> save();

        // return response()->json([]);
    }


    public function update_answer(Request $request)
    {

        

        $answer = Answer::where('id', $request->id)->first();
        $answer->answer = $request->answer;
        $answer->status = $request->status;
        $answer->save();

        

        return response()->json([]);
    }


    public function delete_answer(Request $request)
    {
        $answer = Answer::find($request->id);
        $answer->delete();
        return response()->json([]);
    }
}
