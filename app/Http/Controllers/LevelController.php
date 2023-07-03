<?php

namespace App\Http\Controllers;


use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function show_levels($id = null)
    {
        $subjects = Subject::get();

        if($id == null){
            return view('levels.levels' , compact('subjects'));
        }else{

            return view('levels.levels' , compact('subjects','id'));
        }
    }


    
    public function get_levels_data(Request $request,$id = null)
    {

        if ($request->ajax()) {

            if($id == null){
                $data = Level::get();
            }else{
                $data = Level::where('subject_id',$id)->get();
            }
          

            return DataTables::of($data)

            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                return view('levels.btns.actions', compact('data'));

            })

            ->addColumn('courses_count', function ($data) {
                
                return '<a href="'.route('show_courses', ['id' => $data->id]).'"><button class="btn btn-secondary">'.$data->courses->count().'</button></a>';
            })

            ->rawColumns(['name' , 'courses_count'])

             ->make(true);
                
        }
    }


    


    public function store_level(Request $request){

        $request->validate([
            'name'   => 'required',

        ]);

        $level = new Level();
        $level->name = $request->name;
        $level->subject_id = $request->subject_id;
        $level -> save();

        return response()->json([]);
    }


    public function update_level(Request $request)
    {


        $level = Level::where('id' , $request->id)->first();

        $level->name = $request->level_name;
        $level->subject_id = $request->subject_id;
        $level->save();

        return response()->json([]);
    }


    public function delete_level(Request $request){
        $level = Level::find($request->id);
        $level->delete();
        return response()->json([]);

    }
}

