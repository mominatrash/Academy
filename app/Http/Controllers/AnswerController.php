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





    public function store_answer(Request $request, $id)
    {
        $request->validate([
            'answers.*.answer' => 'required',
        ]);
    
        if ($request->hasFile('answers.*.answer')) {
            $answers = $request->file('answers');
            foreach ($answers as $key => $answer) {
                $status = $request->input('answers.' . $key . '.status');
    
                $answer_file = $answer['answer'];
                $answer_name = 'answer_' . time() . '_' . uniqid() . '.' . $answer_file->getClientOriginalExtension();

                $question = Question::where('id' , $id)->first();

                $answer_path = 'Attachments/' . 'answers/' . $question->question . '/' . now()->format('Y-m-d');
    
                $answerAttachment = new Answer();
                $answerAttachment->answer = asset($answer_path . '/' . $answer_name);
                $answerAttachment->question_id = $id;
                $answerAttachment->status = $status; // Set the status for this answer
    
                $answerAttachment->save();
    
                $answer_file->move(public_path($answer_path), $answer_name);
            }
        } else {
            // Handle other non-file input data here
            foreach ($request->answers as $a) {
                $answer = new Answer();
                $answer->answer = $a['answer'];
                $answer->status = $request->input('answers.0.status'); // Set the status for non-file answer
                $answer->question_id = $id;
                $answer->save();
            }
        }
    }
    
    
    
    


    public function update_answer(Request $request)
    {

        $request->validate([
            'answer'    => 'required',
            'status'    => 'required',
        ]);

        
        if ($request->hasFile('answer')) {
            $answer_file = $request->file('answer');
            $answer_name = 'answer_' . time() . '_' . uniqid() . '.' . $answer_file->getClientOriginalExtension();
    
            $answerAttachment = Answer::where('id', $request->id)->first();
            $answer_path = 'Attachments/' . 'answers/' . $answerAttachment->question->question . '/' . now()->format('Y-m-d');
            $answerAttachment->answer = asset($answer_path . '/' . $answer_name);
            $answerAttachment->status = $request->status;
            $answerAttachment->save();
    
            $answer_file->move(public_path($answer_path), $answer_name);

        }else{
        $answer = Answer::where('id', $request->id)->first();
        $answer->answer = $request->answer;
        $answer->status = $request->status;
        $answer->save();
        }

        

        return response()->json([]);
    }


    public function delete_answer(Request $request)
    {
        $answer = Answer::find($request->id);
        $answer->delete();
        return response()->json([]);
    }
}
