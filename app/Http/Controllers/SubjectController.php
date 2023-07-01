<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class SubjectController extends Controller
{
    public function show_subjects()
    {
        return view('subjects.show_subjects');
    }

    public function get_subjects_data(Request $request)
    {

        if ($request->ajax()) {
            $subjects = Subject::with('levels')->orderBy('id')->get();
            return DataTables::of($subjects)

            ->addIndexColumn()
            
            ->setRowClass(function ($user) {
                return $user->id % 2 == 0 ? 'alert-warning' : '';
            })

            // ->setRowAttr([
            //     'align' => 'center'
               
            // ])


            ->addColumn('action', function ($subjects) {

                return view('subjects.btns.actions', compact('subjects'));

            })

            ->addColumn('levels_count', function ($subjects) {
                return $subjects->levels->count();
            })



            ->rawColumns(['name','levels_count', 'action' ])

             ->make(true);

                

                
        }
    }


    public function store_subject(Request $request){


        $request->validate([
            'name'   => 'required',

        ]);



        $subject = new Subject();
        $subject->name = $request->name;
        $subject -> save();

        
        return response()->json([]);


    }


    public function delete_subject(Request $request){
        $subject = Subject::find($request->id);
        $subject->delete();
        return response()->json([
            // 'message' => 'تم الحذف بنجاح'
        ]);

    }
}
