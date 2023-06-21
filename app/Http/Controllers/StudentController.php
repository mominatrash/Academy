<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\StudentAttendance;
use App\Models\StudentDegree;
use App\Models\studentGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function my_group()
    {

        if (Auth::guard('api')->user()->study_type == "حضوري") {

            $my_group = studentGroup::where('user_id', Auth::guard('api')->user()->id)->first();

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'group' => $my_group,
            ]);
        } else {
            return response()->json([
                'errors' => [
                    'phone' => [
                        'الحساب الكتروني',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }

    public function my_exams()
    {
        if (Auth::guard('api')->user()->study_type == "حضوري") {

            $my_exams = StudentDegree::where('user_id', Auth::guard('api')->user()->id)->get();

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'group' => $my_exams,
            ]);
        } else {
            return response()->json([
                'errors' => [
                    'phone' => [
                        'الحساب الكتروني',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }

    public function my_lectures()
    {

        if (Auth::guard('api')->user()->study_type == "حضوري") {

            $my_lectures = StudentAttendance::where('user_id', Auth::guard('api')->user()->id)->with('lecture')->get();

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'group' => $my_lectures,
            ]);
        } else {
            return response()->json([
                'errors' => [
                    'phone' => [
                        'الحساب الكتروني',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }

    public function installments()
    {
        if (Auth::guard('api')->user()->study_type == "حضوري") {

            $installments = Installment::where('user_id', Auth::guard('api')->user()->id)->get();

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'group' => $installments,
            ]);
        } else {
            return response()->json([
                'errors' => [
                    'phone' => [
                        'الحساب الكتروني',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }


    public function study_type()
    {

        if (Auth::guard('api')->user()->study_type == "حضوري") {

            $installments = Installment::where('user_id', Auth::guard('api')->user()->id)->get();

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'group' => $installments,
            ]);
        } else {
            return response()->json([
                'errors' => [
                    'phone' => [
                        'الحساب الكتروني',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }


    public function student_statistics()
    {
        if (Auth::guard('api')->user()->study_type == 'حضوري') {

            $attendance = StudentAttendance::where('user_id', Auth::guard('api')->user()->id)->get();
            $exams = StudentDegree::where('user_id', Auth::guard('api')->user()->id)->get();
            $installments = Installment::where('user_id', Auth::guard('api')->user()->id)->latest();

            $student_attendance['lectures'] = $attendance->count();
            $student_attendance['presence'] = $attendance->where('status', 'حضور')->count();
            $student_attendance['absence'] = $attendance->where('status', 'غياب')->count();
            $student_attendance['vacation'] = $attendance->where('status', 'اجازة')->count();

            $degrees_record['exams'] = $exams->count();
            $degrees_record['success'] = $exams->where('status', 'نجاح')->count();
            $degrees_record['fail'] = $exams->where('status', 'رسوب')->count();
            $degrees_record['absence'] = $exams->where('status', 'غياب')->count();

            $student_installments['overall'] = $installments->count();
            $student_installments['paid'] = $installments->sum('deserved_amount') - $installments->sum('remaining_amount');
            $student_installments['remaining'] = $installments->sum('remaining_amount');

            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'Student Attendance' => $student_attendance,
                'Degrees Record' => $degrees_record,
                'Installments Record' => $student_installments,
            ]);
        } else {

            return response()->json([
                'errors' => [
                    'phone' => [
                        'الحساب الكتروني',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }
}
