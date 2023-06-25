<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Code;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodeController extends Controller
{
    public function generate_codes_for_course(Request $request)
    {
        $x = $request->codes;
        for ($i = 0; $i < $x; $i++) {
            $gens = Str::random(5) . '-' . Str::random(5) . '-' . Str::random(5);
            $code = new Code();
            $code->code = $gens;
            $code->course_id = $request->course_id;
            // $code->user_id = Auth::guard('api')->user->id;
            $code->save();
        }

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => $x . ' codes have been generated'
        ]);
    }


    public function subscribe(Request $request)
    {
        $user = User::where('id', Auth::guard('api')->user()->id)->first();

        if ($user->verify_status == "مقبول") {
            $code = Code::where('code', $request->code)->first();
            if ($code) {
                if ($code->status == 0) {

                    $course = Code::where('course_id', $request->course_id)->first();

                    if ($course) {

                        $code->user_id = Auth::guard('api')->user()->id;
                        $code->status = 1;
                        $code->save();

                        return response()->json([
                            'code' => 200,
                            'status' => true,
                            'message' => 'تم الإشتراك بالدورة بنجاح'
                        ]);
                    } else {

                        return response()->json(
                            [
                                "errors" => [
                                    "phone" => [
                                        "!هذا الكود غير صالح لهذه الدورة"
                                    ]
                                ],
                                "status" => false,
                                'code' => 404,
                            ]
                        );
                    }
                } else {

                    return response()->json(
                        [
                            "errors" => [
                                "phone" => [
                                    "!الكود مستخدم"
                                ]
                            ],
                            "status" => false,
                            'code' => 404,
                        ]
                    );
                }
            } else {

                return response()->json(
                    [
                        "errors" => [
                            "phone" => [
                                "!الكود غير صالح"
                            ]
                        ],
                        "status" => false,
                        'code' => 404,
                    ]
                );
            }
        }else{

            return response()->json(
                [
                    "errors" => [
                        "phone" => [
                            "يرجى تفعيل الحساب أولا"
                        ]
                    ],
                    "status" => false,
                    'code' => 404,
                ]
            );
        }
    }
}
