<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Verify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'phone'    => 'required|numeric|unique:users',
            'parent_phone'    => 'required|numeric',
            'password' => 'required|min:8',
            'level' => 'required',
            'study_type' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation error',
                'code' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }


        $user = new User();

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->parent_phone = $request->parent_phone;
        $user->password = bcrypt($request->password);
        $user->level = $request->level;
        $user->study_type = $request->study_type;
        $user->save();




        $user['token'] = $user->createToken('accessToken')->accessToken;


        return response()->json([
            'message' => 'user created successfully',
            'code' => 200,
            'status' => true,
            'data' => $user,
        ]);
    }

    public function login(Request $request)
    {

        $loginData = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'password' => 'required',
        ]);

        if ($loginData->fails()) {
            $errors = $loginData->errors();

            return response([
                'status' => false,
                'message' => 'Make sure that the information is correct and fill in all fields',
                'errors' => $errors,
                'code' => 422
            ]);
        }


        $user = User::where('phone', $request->phone)->first();





        if ($user) {

            if (!Hash::check($request->password, $user->password)) {

                return response()->json(
                    [
                        "errors" => [
                            "password" => [
                                "Invalid Password!"
                            ]
                        ],
                        "status" => false,
                        'code' => 404,
                    ]
                );
            } else {




                $accessToken = $user->createToken('authToken')->accessToken;

                return response([
                    'code' => 200,
                    'status' => true,
                    'message' => 'login Successfully',
                    'user' => $user,
                    'access_token' => $accessToken
                ]);
            }
        } else {

            return response()->json(
                [
                    "errors" => [
                        "phone" => [
                            "No Account Assigned To This phone!"
                        ]
                    ],
                    "status" => false,
                    'code' => 404,
                ]
            );
        }
    }


    public function logout()
    {

        $user = Auth::guard('api')->user()->token();
        $user->revoke();
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Logged out Successfully',
        ]);
    }

    public function forgot_password(Request $request)
    {

        $user = User::where('phone', $request->phone)->first();

        if ($user) {

            $randomCode = Str::random(6);


            $user->code = $randomCode;
            $user->save();

            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => 'a change password request code has been sent to your email',
                'data' => $randomCode
            ]);
        } else {

            return response()->json(
                [
                    "errors" => [
                        "phone" => [
                            "No Account Assigned To This phone!"
                        ]
                    ],
                    "status" => false,
                    'code' => 404,
                ]
            );
        }
    }

    public function verify_pass_code(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->code == $request->code) {



                return response()->json([
                    'code' => 200,
                    'status' => true,

                ]);
            } else {

                return response()->json(
                    [
                        "errors" => [
                            "phone" => [
                                "Code is invalid!"
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
                            "No Account Assigned To This phone!"
                        ]
                    ],
                    "status" => false,
                    'code' => 404,
                ]
            );
        }
    }


    public function change_forgotten_password(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->code == $request->code) {

                $user->code = null;
                $user->password = bcrypt($request->new_password);
                $user->save();


                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'message' => 'Password updated successfully',

                ]);
            } else {

                return response()->json(
                    [
                        "errors" => [
                            "phone" => [
                                "Code is invalid!"
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
                            "No account assigned to this phone!"
                        ]
                    ],
                    "status" => false,
                    'code' => 404,
                ]
            );
        }
    }


    public function verify_acc(Request $request)
    {
        $verify = new Verify();


        $verify->user_id = Auth::guard('api')->user()->id;
        $verify->name = $request->name;
        $verify->governorate = $request->governorate;
        $verify->address = $request->address;

        $pfp = $request->file('pfp');
        $pfp_name = $pfp->getClientOriginalName();
        $verify->pfp = asset('Attachments/' . 'verify attachments/' . Auth::guard('api')->user()->id . '/' . $pfp_name);
        $pfp->move(public_path('Attachments/' . 'verify attachments/' . Auth::guard('api')->user()->id), $pfp_name);


        $front_ID = $request->file('front_ID');
        $front_ID_name = $front_ID->getClientOriginalName();
        $verify->front_ID = asset('Attachments/' . 'verify attachments/' . Auth::guard('api')->user()->id  . '/' . $front_ID_name);
        $front_ID->move(public_path('Attachments/' . 'verify attachments/' . Auth::guard('api')->user()->id ), $front_ID_name);


        $back_ID = $request->file('back_ID');
        $back_ID_name = $back_ID->getClientOriginalName();
        $verify->back_ID = asset('Attachments/' . 'verify attachments/' . Auth::guard('api')->user()->id  . '/' . $back_ID_name);
        $back_ID->move(public_path('Attachments/' . 'verify attachments/' . Auth::guard('api')->user()->id ), $back_ID_name);


        $verify->save();


        return response()->json([
            'message' => 'تم ارفاق الملف للدرس بنجاح',
            'code' => 200,
            'status' => true,
            'attachment' => $verify,
        ]);
    }


    public function verify_accept(Request $request)
    {
        $accept = Verify::where('id' , $request->verify_id)->first();

        $accept->status = "مقبول";
        $accept->save();

        $user = User::where('id' , $accept->user_id)->first();
        $user->verify_status = "مقبول";
        $user->save();
    }


    public function verify_decline(Request $request)
    {
        $accept = Verify::where('id' , $request->verify_id)->first();

        $accept->status = "مرفوض";
        $accept->save();

        $user = User::where('id' , $accept->user_id)->first();
        $user->verify_status = "مرفوض";
        $user->save();
    }
}
