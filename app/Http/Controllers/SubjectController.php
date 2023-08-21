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

            $data = Subject::with('levels')->orderBy('id')->get();

            return DataTables::of($data)

            ->addIndexColumn()
            
            // ->setRowClass(function ($user) {
            //     return $user->id % 2 == 0 ? 'alert-warning' : '';
            // })



            // ->addColumn('name', function ($data) {


            //    return '<button class="btn btn-primary">'.$data->name.'</button>';

            // })
            ->addColumn('action', function ($data) {


                return view('subjects.btns.actions', compact('data'));

            })

            ->addColumn('levels_count', function ($data) {
                if (auth()->user()->can('المراحل')) {
                    return '<a href="'.route('show_levels', $data->id).'"><button class="btn btn-sm btn-primary">'.$data->levels->count().'</button></a>';
                } else {
                    return $data->levels->count();
                }
            })
            



            ->rawColumns(['levels_count' ,'name'])

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

        
        return response()->json([

        ]);


    }


    public function update_subject(Request $request)
    {
        $subject= Subject::where('id',$request->id)->first();
        $subject->name=$request->subject_name;
        $subject->save();
        return response()->json();
    }


    public function delete_subject(Request $request){
        $subject = Subject::find($request->id);
        $subject->delete();
        return response()->json([
            // 'message' => 'تم الحذف بنجاح'
        ]);

    }
}
