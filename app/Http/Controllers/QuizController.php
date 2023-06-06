<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\myQuiz;
use App\Models\Question;
use App\Models\Section;
use App\Models\totalPoints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Random\Engine\Secure;

class QuizController extends Controller
{
    public function quiz_by_id(Request $request)
    {
        $quiz = Quiz::where('id', $request->quiz_id)->first();

        $myQuiz = myQuiz::where('quiz_id', $request->quiz_id)->where('user_id', Auth::guard('api')->user()->id)->first();

        if ($myQuiz && $quiz) {
            $quiz = Quiz::where('id', $request->quiz_id)->with('myquizzes')->first();

            return response()->json([
                'message' => 'عرض النتائج',
                'code' => 200,
                'status' => true,
                'quiz' => $quiz,
            ]);
        } else {
            return response()->json([
                'message' => 'ابدأ الاختبار',
                'code' => 200,
                'status' => true,
                'quiz' => $quiz,
            ]);
        }
    }



    public function start_quiz(Request $request)
    {
        $quiz = Quiz::where('id', $request->quiz_id)->first()->with('questions.answers')->first();


        $myQuiz = myQuiz::where('quiz_id', Auth::guard('api')->user()->id)->first();
        if ($myQuiz && $myQuiz->remaining_attempts > 0) {

            $myQuiz->remaining_attempts--;
            // $myQuiz->user_points = 0;
            $myQuiz->save();

            return response()->json([
                // 'message' => 'تم اضافة اللايك للتعليق',
                'code' => 200,
                'status' => true,
                'quiz' => $quiz,
            ]);
        } elseif ($myQuiz && $myQuiz->remaining_attempts == 0) {
            return response()->json([
                'errors' => [
                    'phone' => [
                        "انتهت المحاولات",
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        } else {


            $myQuiz = new myQuiz();
            $myQuiz->remaining_attempts = $quiz->attempts;
            $myQuiz->user_points = 0;
            $myQuiz->user_id = Auth::guard('api')->user()->id;
            $myQuiz->quiz_id = $quiz->id;
            $myQuiz->save();

            return response()->json([
                // 'message' => 'تم اضافة اللايك للتعليق',
                'code' => 200,
                'status' => true,
                'quiz' => $quiz,
            ]);
        }
    }

    public function end_quiz(Request $request)
    {
        $myQuiz = myQuiz::where('quiz_id', Auth::guard('api')->user()->id)->first();

        $answers_count = 0;


        $quiz = Quiz::where('id', $request->quiz_id)->first();
        $lesson = Lesson::where('quiz_id' , $quiz->id )->first();
        $section = Section::where('lesson_id' , $lesson->id )->first();
        $course = Course::where('section_id' , $section->id )->first();

        $questions = Question::where('quiz_id', $request->quiz_id)->pluck('id');
        $answers = Answer::whereIn('question_id', $questions)->get();


        if ($answers->count() > 0) {
            $d = [];

            $answers1 = json_decode($request->answers_ids, true);

            foreach ($answers1 as $answer) {
                $answer_id = $answer['answer_id'];


                $answers_search = $answers->where('id', $answer_id)->where('status', 1)->first();

                if ($answers_search) {

                    $answers_count++;
                }
            }

            

            $points_for_question = $quiz->points / $questions->count();



            if ($myQuiz->remaining_attempts == $quiz->attempts) {
                $final_point = $answers_count * $points_for_question;

                $myQuiz->user_points = $final_point;
                $myQuiz->save();



                return response()->json([
                    'message' => 'if',
                    'code' => 200,
                    'status' => true,
                    'quiz' => $myQuiz,
                ]);
            } else {

                $attempts_count = $quiz->attempts - $myQuiz->remaining_attempts;
                $attempts_deduction = $quiz->deduction_per_attempt * $attempts_count;
                $final_point = $answers_count * $points_for_question;
                $final_point = $final_point - $attempts_deduction;

                $myQuiz->user_points = $final_point;
                $myQuiz->save();



                return response()->json([
                    'message' => 'else',
                    'code' => 200,
                    'status' => true,
                    'quiz' => $myQuiz,
                ]);
            }
        }
    }
}
