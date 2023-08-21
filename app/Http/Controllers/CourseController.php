<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use App\Models\totalPoints;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    public function show_courses()
    {
        $levels = Level::get();
        return view('courses.courses' , compact('levels'));

        
    } 
    
    public function show_student_courses($user_id)
    {
        $levels = Level::get();
        return view('courses.courses' , compact('levels' , 'user_id')); 
    }




    public function student_courses_data(Request $request , $user_id)
    {

        if ($request->ajax()) {


            $student_courses = Code::where('user_id' , $user_id)->pluck('course_id');
            $data = Course::whereIn('id' , $student_courses)->get();
            
            $degree = totalPoints::where('user_id' , $user_id)->whereIn('course_id' , $student_courses)->get();


            
            return DataTables::of($data)

            ->addIndexColumn()
            ->addColumn('action', function ($data) {

             return view('courses.btns.actions', compact('data'));

            })

            ->addColumn('sections_count', function ($data) {
                if (auth()->user()->can('الاقسام')) {
                    return '<a href="'.route('show_sections', ['id' => $data->id]).'"><button class="btn btn-sm btn-primary">'.$data->sections->count().'</button></a>';
                } else {
                    return $data->sections->count();
                }
            })
            
            ->addColumn('degree', function ($data) use ($user_id) {
                $user_points = Totalpoints::where('user_id', $user_id)
                    ->where('course_id', $data->id)
                    ->first();

                return $user_points ? $user_points->total_points : 'لم يحصل على درجات بعد';
            })
            


            ->addColumn('is_free', function ($data) {
                if ($data->is_free === 0) {
                   
                    return  ' <span class="badge badge-success">مدفوع <i class="fa fa-check"></i></span> ';

                } elseif ($data->is_free === 1) {
                    return  '<span class="badge badge-success">مجاني <i class="fa fa-check"></i></span>';
                }
            })

            ->rawColumns(['name' , 'sections_count' , 'description' , 'is_free' , 'degree'])
             ->make(true);
                
        }
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
                if (auth()->user()->can('الاقسام')) {
                    return '<a href="'.route('show_sections', ['id' => $data->id]).'"><button class="btn btn-sm btn-primary">'.$data->sections->count().'</button></a>';
                } else {
                    return $data->sections->count();
                }
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
                if (auth()->user()->can('الاقسام')) {
                    return '<a href="'.route('show_sections', ['id' => $data->id]).'"><button class="btn btn-sm btn-primary">'.$data->sections->count().'</button></a>';
                } else {
                    return $data->sections->count();
                }
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
            'image' => 'required|max:10240',

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
            'image' => 'required|max:10240',

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
