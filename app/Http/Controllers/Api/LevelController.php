<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
  
    public function subject_levels(Request $request)
    {
        $levels=Level::where('subject_id',$request->subject_id)->get();

        $newObject = [
            "id" => 0,
            "name" => "الكل",
            "subject_id" =>$request->subject_id,
            "created_at" => "2023-06-02T22:00:47.000000Z",
            "updated_at" => "2023-06-02T22:00:47.000000Z"
        ];
        
        $mergedData = collect($levels)->prepend($newObject);


        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status'=>true,
            'data'=>$mergedData
        ]);
    }
}
