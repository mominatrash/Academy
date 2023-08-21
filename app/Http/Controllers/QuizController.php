<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\myQuiz;
use App\Models\myQuizzes;
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
                    if (auth()->user()->can('اسئلة الاختبارات')) {

                        return '<a href="'.route('show_questions', ['id' => $data->id]).'"><button class="btn btn-sm btn-primary">' . $data->questions->count() . '</button></a>';
                    } else {
                        return '***';
                    }
                })


                ->addColumn('degrees', function ($data) {
                    if (auth()->user()->can('الطلاب')) {
                       // $myquizzes = myQuiz::where('quiz_id' , $data->id)->count();
                        return '<a href="'.route('show_students', ['id' => $data->id]).'"><button class="btn btn-sm btn-primary">' . myQuizzes::where('quiz_id' , $data->id)->count() . '</button></a>';
                    } else {
                        return $data->questions->count();
                    }
                })
                
                




                ->rawColumns(['action','name', 'questions_number', 'lesson_id', 'degrees' ])

                ->make(true);
        }
    }


    public function show_student_quizzes($user_id)
    {
        $lessons = Lesson::get();
        $quizzes = Quiz::get();

            return view('quizzes.quizzes', compact('lessons' , 'quizzes' , 'user_id'));

        }



        public function student_quizzes_data(Request $request, $user_id)
        {
    
            if ($request->ajax()) {

                    $user_quizzes = myQuizzes::where('user_id' , $user_id)->pluck('quiz_id');
                    $data = Quiz::whereIn('id' , $user_quizzes)->get();

    
    
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
                        if (auth()->user()->can('اسئلة الاختبارات')) {
    
                            return '<a href="'.route('show_questions', ['id' => $data->id]).'"><button class="btn btn-sm btn-primary">' . $data->questions->count() . '</button></a>';
                        } else {
                            return '***';
                        }
                    })
    
    
                    ->addColumn('degrees', function ($data) {
                        if (auth()->user()->can('الطلاب')) {
                           // $myquizzes = myQuiz::where('quiz_id' , $data->id)->count();
                            return '<a href="'.route('show_students', ['id' => $data->id]).'"><button class="btn btn-sm btn-primary">' . myQuizzes::where('quiz_id' , $data->id)->count() . '</button></a>';
                        } else {
                            return $data->questions->count();
                        }
                    })
                    
                    
                    ->addColumn('remaining_attempts', function ($data) use ($user_id) {
                        $remaining_attempts = MyQuizzes::where('user_id', $user_id)->where('quiz_id' , $data->id)->first();
                        return ' <span>' . $remaining_attempts->remaining_attempts . '</span>';
                    })

                    ->addColumn('student_points', function ($data) use ($user_id) {
                            $degree = myQuizzes::where('quiz_id', $data->id)->where('user_id', $user_id)->first();
                            $degreeValue = $degree ? $degree->user_points : 0;
                            $totalDegree = Quiz::where('id', $user_id)->value('points');
                        
                            // Check if degree is less than half of total_degree
                            if ($degreeValue < ($totalDegree / 2)) {
                                return '<span class="badge badge-danger">'.$degreeValue.'</span>';
                            } else {
                                return '<span class="badge badge-success">'.$degreeValue.'</span>';
                            }
                        })
                    
                        ->addColumn('points', function ($data) {
                        return '<span class="badge badge-secondary">'.$data->points.'</span>';
                    })
    
    
                    ->rawColumns(['name','lesson_id', 'type', 'time', 'questions_number' , 'remaining_attempts'  , 'attempts', 'deduction_per_attempt', 'student_points', 'points', 'action'])
    
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
