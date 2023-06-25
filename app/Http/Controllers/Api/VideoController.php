<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function add_video(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'link' => 'required|url|regex:/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/',
        ]);



        $video = new Video();
        $video->link = $request->link;

        $duration = $request->duration;
        list($hours, $minutes) = explode(':', $duration);
        $durationInSeconds = ($hours * 3600) + ($minutes * 60);

        $video->duration = date('H:i', strtotime('+ ' . $durationInSeconds . ' seconds'));


        $attachmentFile = $request->file('thumbnail');
        $file_name = $attachmentFile->getClientOriginalName();

        $video->thumbnail = asset('Attachments/' . 'thumbnails/' . '/' . $file_name);
        $attachmentFile->move(public_path('Attachments/' . 'thumbnails/'), $file_name);

        $video->save();

        return response()->json([
            'message' => 'تم ارفاق الملف للدرس بنجاح',
            'code' => 200,
            'status' => true,
            'attachment' => $video,
        ]);
    }


    public function videos()
    {
        $videos = Video::paginate(5);

        return response()->json([
            'code' => 200,
            'status' => true,
            'attachment' => $videos,
        ]);
    }
}
