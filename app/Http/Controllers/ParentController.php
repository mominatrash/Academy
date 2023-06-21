<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Parent1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    public function parent_login(Request $request)
    {
        $loginData = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'parent_phone' => 'required|numeric',
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

        $user = User::where('phone', $request->phone)->where('parent_phone', $request->parent_phone)->first();
        $parent = Parent1::where('student_phone', $request->phone)->first();

        if ($user && $parent) {
            if ($user->phone == $parent->student_phone && $user->parent_phone == $parent->phone) {
                $accessToken = $parent->createToken('ParentAuthToken')->accessToken;

                return response([
                    'code' => 200,
                    'status' => true,
                    'message' => 'logged in Successfully',
                    'user' => $parent,
                    'access_token' => $accessToken
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Make sure that the information is correct',
                    'code' => 422
                ]);
            }
        } else if ($user && !$parent) {
            if ($user->parent_phone == $request->parent_phone) {
                $parent = new Parent1;
                $parent->phone = $user->parent_phone;
                $parent->student_phone = $user->phone;
                $parent->save();
                $accessToken = $parent->createToken('ParentAuthToken')->accessToken;

                return response([
                    'code' => 200,
                    'status' => true,
                    'message' => 'login Successfully',
                    'user' => $parent,
                    'access_token' => $accessToken
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Make sure that the information is correct',
                    'code' => 422
                ]);
            }
        } else {
            return response()->json(
                [
                    "errors" => [
                        "phone" => [
                            "No Account Assigned To This Phone !"
                        ]
                    ],
                    "status" => false,
                    'code' => 404,
                ]
            );
        }
    }
    public function parent_logout()
    {
        $user = Auth::guard('parent')->user()->token();
        $user->revoke();
        return response()->json([
            'code' => 200,
            "status" => true,
            'message' => 'logout Successfully',
        ]);
    }
}
