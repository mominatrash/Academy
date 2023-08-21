<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                    if (auth()->user()->can('اجابات الاسئلة')) {
                        return '<a href="' . route('show_answers', ['id' => $data->id]) . '"><button class="btn btn-sm btn-primary">تعديل الإجابات (' . $data->answers->count() . ')</button></a>';
                    } else {
                        return 'تعديل الإجابات (' . $data->answers->count() . ')';
                    }
                })
                



                ->rawColumns(['name', 'answers_count', 'quiz'])

                ->make(true);
        }
    }






    
    public function store_question(Request $request, $id)
    {
        $request->validate([
            'questions.*.question' => 'required',
        ]);
    
        if ($request->hasFile('questions.*.question')) {
            $questions = $request->file('questions');
            foreach ($questions as $q) {
                $question_file = $q['question'];
                $question_name = 'question_' . time() . '_' . uniqid() . '.' . $question_file->getClientOriginalExtension();
                
                $quiz = Quiz::where('id' , $id)->first();
                $question_path = 'Attachments/' . 'questions/' . $quiz->name . '/' . now()->format('Y-m-d');
    
                $questionAttachment = new Question();
                $questionAttachment->question = asset($question_path . '/' . $question_name);
                $questionAttachment->quiz_id = $id;
                $questionAttachment->save();
    
                // Use the move method to move the file
                $question_file->move(public_path($question_path), $question_name);
            }
        } else {
            // Handle other non-file input data here
            foreach ($request->questions as $q) {
                $question = new Question();
                $question->question = $q['question'];
                $question->quiz_id = $id;
                $question->save();
            }
        }
    }
    
    
    
    
    
    
    
    

    public function update_question(Request $request)
    {
        $request->validate([
            'question' => 'required',
        ]);
    
        if ($request->hasFile('question')) {
            $question_file = $request->file('question');
            $question_name = 'question_' . time() . '_' . uniqid() . '.' . $question_file->getClientOriginalExtension();
    
            $questionAttachment = Question::where('id', $request->id)->first();
            $question_path = 'Attachments/' . 'questions/' . $questionAttachment->quiz->name . '/' . now()->format('Y-m-d');
            $questionAttachment->question = asset($question_path . '/' . $question_name);
            $questionAttachment->save();
    
            // Use the move method to move the file
            $question_file->move(public_path($question_path), $question_name);
        } else {
            // Handle other non-file input data here
            $question = Question::where('id', $request->id)->first();
            $question->question = $request->question;
            $question->save();
        }
    }
    

    public function delete_question(Request $request)
    {
        $question = Question::find($request->id);
        $question->delete();
        return response()->json([]);
    }
}
