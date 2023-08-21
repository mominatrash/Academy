<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;
use App\Models\myQuizzes;
use App\Models\StudentDegree;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function show_students($id = null)
    {
        $courses = Course::get();

        if($id == null){
            return view('students.students' , compact('courses'));
        }else{

            return view('students.students' , compact('courses','id'));
        }
    }


    
    public function get_students_data(Request $request)
    {

        if ($request->ajax()) {

  
                $data = User::get();
    
          

            return DataTables::of($data)

            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                return view('students.btns.actions', compact('data'));

            })

            
            ->addColumn('verify_status', function ($data) {
                if ($data->verify_status === 'مفعل') {
                    return '<span style="color: green;">مقبول</span> ' . 
                          '<a href="'.route('change_student_status', ['user_id' => $data->id]).'"><button class="btn btn-success btn-sm" style="padding: 3px;"><i class="fas fa-solid fa-toggle-on" style="font-size: 12px;"></i></button>';
                } elseif ($data->verify_status === 'مرفوض') {
                    return '<span style="color: red;">مرفوض</span> ' . 
                            '<a href="'.route('change_student_status', ['user_id' => $data->id]).'"><button class="btn btn-danger btn-sm" style="padding: 3px;"><i class="fas fa-solid fa-toggle-off" style="font-size: 12px;"></i></button>';
                }
            })
            
            
            

            ->addColumn('courses', function ($data) {

                $courses = Code::where('user_id' , $data->id)->count();
                return '<a href="'.route('show_student_courses', ['user_id' => $data->id]).'"><button class="btn btn-sm btn-primary">'.$courses.'</button></a>';

            })
            
            ->addColumn('his_quizzes', function ($data) {

                $quizzes = myQuizzes::where('user_id' , $data->id)->count();
                return '<a href="'.route('show_student_quizzes', ['user_id' => $data->id]).'"><button class="btn btn-sm btn-primary">'.$quizzes.'</button></a>';

            })
            

            ->rawColumns(['name' , 'phone' , 'parent_phone' , 'level' , 'email' , 'study_type' , 'verify_status' , 'his_quizzes' , 'courses'])

             ->make(true);
                
        }
    }


    public function get_student_data(Request $request,$id)
    {

        if ($request->ajax()) {

            $quizzes = myQuizzes::where('quiz_id', $id)->pluck('user_id');

            $data = User::whereIn('id', $quizzes)->get();
            

          

            return DataTables::of($data)

            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                return view('students.btns.actions', compact('data'));

            })

            



            ->addColumn('courses', function ($data) {

                $courses = Code::where('user_id' , $data->id)->count();
                return '<a href="'.route('show_student_courses', ['user_id' => $data->id]).'"><button class="btn btn-sm btn-primary">'.$courses.'</button></a>';

            })

            ->addColumn('degree', function ($data) use ($id) {
                $degree = myQuizzes::where('quiz_id', $id)->where('user_id', $data->id)->first();
                $degreeValue = $degree ? $degree->user_points : 0;
                $totalDegree = Quiz::where('id', $id)->value('points');
            
                // Check if degree is less than half of total_degree
                if ($degreeValue < ($totalDegree / 2)) {
                    return '<span class="badge badge-danger">'.$degreeValue.'</span>';
                } else {
                    return '<span class="badge badge-success">'.$degreeValue.'</span>';
                }
            })
            

            ->addColumn('total_degree', function ($data) use ($id) {
                
                $total_degree = Quiz::where('id', $id)->first();
                return '<span class="badge badge-secondary">'.$total_degree->points.'</span>';
            })

            

            ->rawColumns(['name' , 'phone' , 'parent_phone' , 'level' , 'email' , 'study_type' , 'verify_status' , 'courses' , 'degree', 'total_degree'])

             ->make(true);
                
        }
    }



    function change_student_status($user_id){

        $user = User::where('id' , $user_id)->first();

        if($user->verify_status == 'مفعل'){
            $user->verify_status = 'مرفوض';
            $user->save();
        }else{

            $user->verify_status = 'مفعل';
            $user->save();
        }

        return redirect()->route('show_students');
    }
            


    public function store_student(Request $request){

        $request->validate([
            'name'   => 'required',

        ]);

        $student = new User();
        $student->name = $request->name;
        $student->subject_id = $request->subject_id;
        $student -> save();

        return response()->json([]);
    }


    public function update_student(Request $request)
    {


        $student = User::where('id' , $request->id)->first();

        $student->name = $request->student_name;
        $student->subject_id = $request->subject_id;
        $student->save();

        return response()->json([]);
    }


    public function delete_student(Request $request){
        $student = User::find($request->id);
        $student->delete();
        return response()->json([]);

    }
}
