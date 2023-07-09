<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SectionController extends Controller
{
    public function show_sections($id = null)
    {
        $courses = Course::get();

        if($id == null){
            return view('sections.sections' , compact('courses'));
        }else{

            return view('sections.sections' , compact('courses','id'));
        }
    }


    
    public function get_sections_data(Request $request,$id = null)
    {

        if ($request->ajax()) {

            if($id == null){
                $data = Section::get();
            }else{
                $data = Section::where('course_id',$id)->get();
            }
          

            return DataTables::of($data)

            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                return view('sections.btns.actions', compact('data'));

            })

            ->addColumn('lessons_count', function ($data) {
                
                return '<a href="'.route('show_lessons', ['id' => $data->id]).'"><button class="btn btn-secondary">'.$data->lessons->count().'</button></a>';
                
            })

            ->rawColumns(['name' , 'lessons_count'])

             ->make(true);
                
        }
    }


    


    public function store_section(Request $request){

        $request->validate([
            'name'   => 'required',

        ]);

        $section = new Section();
        $section->name = $request->name;
        $section->course_id = $request->course_id;
        $section -> save();

        return response()->json([]);
    }


    public function update_section(Request $request)
    {


        $section = Section::where('id' , $request->id)->first();

        $section->name = $request->section_name;
        $section->course_id = $request->course_id;
        $section->save();

        return response()->json([]);
    }


    public function delete_section(Request $request){
        $section = Section::find($request->id);
        $section->delete();
        return response()->json([]);

    }
}
