<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    public function show_courses()
    {
        $levels = Level::get();
        return view('courses.courses' , compact('levels'));
    }


    
    public function get_courses_data(Request $request)
    {

        if ($request->ajax()) {

            $data = Course::get();

            return DataTables::of($data)

            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                return view('courses.btns.actions', compact('data'));

            })

            ->addColumn('sections_count', function ($data) {
                
                return '<a href="'.route('show_sections', ['id' => $data->id]).'"><button class="btn btn-secondary">'.$data->sections->count().'</button></a>';
            })

            ->addColumn('image', function ($data) {
                
                return '<img src="' . $data->image . '" style="width: 50%;" />';


            })
            
            ->addColumn('is_free', function ($data) {
                if ($data->is_free === 0) {
                   
                    return  ' <span class="badge badge-secondary">مدفوع <i class="fas fa-lock fa-beat fa-beat-fade"></i></span> ';

                } elseif ($data->is_free === 1) {
                    return  '<span class="badge badge-success">مجاني <i class="fas fa-lock-open fa-beat fa-beat-fade"></i>
                    </span>';
                }
            })

            ->rawColumns(['name' , 'sections_count' , 'description' , 'is_free' , 'image'])

             ->make(true);
                
        }
    }


    public function level_courses_data(Request $request , $id)
    {

        if ($request->ajax()) {

            $data = Course::where('level_id' , $id)->get();
            return DataTables::of($data)

            ->addIndexColumn()
            ->addColumn('action', function ($data) {

             return view('courses.btns.actions', compact('data'));

            })

            ->addColumn('sections_count', function ($data) {
                
                return '<a href="'.route('show_courses', ['id' => $data->id]).'"><button class="btn btn-secondary">'.$data->sections->count().'</button></a>';
            })


            ->addColumn('is_free', function ($data) {
                if ($data->is_free === 0) {
                   
                    return  ' <span class="badge badge-secondary">مدفوع <i class="fa fa-lock"></i></span> ';

                } elseif ($data->is_free === 1) {
                    return  '<span class="badge badge-success">مجاني <i class="fa fa-check"></i></span>';
                }
            })

            ->rawColumns(['name' , 'sections_count' , 'description' , 'is_free'])
             ->make(true);
                
        }
    }


    public function store_course(Request $request){

        $request->validate([
            'name'   => 'required',

        ]);

        $image_file = $request->file('image');
        $image = $image_file->getClientOriginalName();

        $course = new Course();
        $course->name = $request->name;
        $course->level_id = $request->level_id;

        $course->image = asset('Attachments/' . $course->name . '/' . $image);
        $course->description = $request->description;
        $course->is_free = $request->is_free;
        $course -> save();

        $image_file->move(public_path('Attachments/' . $course->name), $image);

        return response()->json([]);
    }


    public function update_course(Request $request){

        $request->validate([
            'name'   => 'required',

        ]);

        $course = Course::where('id' , $request->id)->first();

        $image_file = $request->file('image');
        $image = $image_file->getClientOriginalName();

        $course->name = $request->name;
        $course->level_id = $request->level_id;

        $course->image = asset('Attachments/' . $course->name . '/' . $image);
        $course->description = $request->description;
        $course->is_free = $request->is_free;
        $course -> save();

        $image_file->move(public_path('Attachments/' . $course->name), $image);

        return response()->json([]);
    }




    public function delete_course(Request $request){
        $course = Course::find($request->id);
        $course->delete();
        return response()->json([]);

    }
}
