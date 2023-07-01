<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function subject_levels(Subject $subject)
    {
        $levels = Level::where('subject_id', $subject->id)->get();

        return view('subject_levels', compact('subject', 'levels'));
    }


    
    public function subject_levels_data($subjectId)
    {
        $subject = Subject::find($subjectId);
        $levels = $subject->levels;

        return DataTables::of($levels)
            ->addIndexColumn()
            ->rawColumns(['name', 'action'])
            ->make(true);
    }
}

