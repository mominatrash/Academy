<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Comment_Reply_Like;
use App\Models\Lesson;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\ElseIf_;

class CommentController extends Controller
{
    public function add_comment(Request $request)
    {
        $lesson = Lesson::where('id', $request->lesson_id)->first();

        if ($lesson) {
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->lesson_id = $request->lesson_id;
            $comment->save();

            return response()->json([
                'message' => 'تم إضافة التعليق بنجاح',
                'code' => 200,
                'status' => true,
                'course' => $comment,
            ]);
        } else {

            return response()->json([
                'errors' => [
                    'phone' => [
                        'الدرس غير موجود، لم يتم اضافة التعليق',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }

    public function show_comments(Request $request)
    {
        $comments = Comment::where('lesson_id', $request->lesson_id)->get();

        if ($comments->count() > 0) {
            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'course' => $comments,
            ]);
        } else {

            return response()->json([
                'errors' => [
                    'phone' => [
                        'لا يوجد تعليقات لهذا الدرس',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }


    public function add_reply(Request $request)
    {
        $comment = Comment::where('id', $request->comment_id)->first();

        if ($comment) {
            $reply = new Reply();
            $reply->reply = $request->reply;
            $reply->comment_id = $request->comment_id;
            $reply->save();

            return response()->json([
                'message' => 'تم إضافة الرد بنجاح',
                'code' => 200,
                'status' => true,
                'course' => $reply,
            ]);
        } else {

            return response()->json([
                'errors' => [
                    'phone' => [
                        'التعليق غير موجود، لم يتم اضافة الرد',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }


    public function show_replies(Request $request)
    {
        $replies = Reply::where('comment_id', $request->comment_id)->get();

        if ($replies->count() > 0) {
            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'course' => $replies,
            ]);
        } else {

            return response()->json([
                'errors' => [
                    'phone' => [
                        'لا يوجد ردود لهذا التعليق',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
    }


    public function comment_reply_like(Request $request)
    {
        if (isset($request->comment_id) && isset($request->reply_id)) {
            return response()->json([
                'errors' => [
                    'phone' => [
                        'يجب اختيار تعليق أو رد',
                    ],
                ],
                'status' => false,
                'code' => 404,
            ]);
        }
        if (isset($request->comment_id) && !isset($request->reply_id)) {

            $comment = Comment::where('id', $request->comment_id)->first();

            if ($comment) {

                $comment_like = Comment_Reply_Like::where('comment_id', $request->comment_id)->where('user_id', Auth::guard('api')->user()->id)->first();

                if ($comment_like) {

                    $comment_like->delete();
                    $comment->likes_count--;
                    $comment->save();

                    return response()->json([
                        'message' => 'تم ازالة اللايك للتعليق',
                        'code' => 200,
                        'status' => true,
                    ]);
                } else {

                    $like = new Comment_Reply_Like();
                    $like->comment_id = $request->comment_id;
                    $like->user_id = Auth::guard('api')->user()->id;
                    $like->save();

                    $comment->likes_count++;
                    $comment->save();

                    return response()->json([
                        'message' => 'تم اضافة اللايك للتعليق',
                        'code' => 200,
                        
                        'status' => true,
                    ]);
                }
            } else {
                return response()->json([
                    'errors' => [
                        'phone' => [
                            'التعليق غير موجود',
                        ],
                    ],
                    'status' => false,
                    'code' => 404,
                ]);
            }
        }
        if (isset($request->reply_id) && !isset($request->comment_id)) {

            $reply = Reply::where('id', $request->reply_id)->first();

            if ($reply) {

                $reply_like = Comment_Reply_Like::where('reply_id', $request->reply_id)->where('user_id', Auth::guard('api')->user()->id)->first();

                if ($reply_like) {

                    $reply_like->delete();
                    $reply->likes_count--;
                    $reply->save();

                    return response()->json([
                        'message' => 'تم ازالة اللايك للرد',
                        'code' => 200,
                        'status' => true,
                    ]);
                } else {

                    $like = new Comment_Reply_Like();
                    $like->reply_id = $request->reply_id;
                    $like->user_id = Auth::guard('api')->user()->id;
                    $like->save();

                    $reply->likes_count++;
                    $reply->save();

                    return response()->json([
                        'message' => 'تم اضافة اللايك للرد',
                        'code' => 200,
                        'status' => true,
                    ]);
                }
            } else {

                return response()->json([
                    'errors' => [
                        'phone' => [
                            'الرد غير موجود',
                        ],
                    ],
                    'status' => false,
                    'code' => 404,
                ]);
            }
        }
    }
}
