<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Article;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function welcome()
    {
        $welcome = Banner::where('type', '=', 'welcome')->get();
        if ($welcome->count() > 0) {

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'orders' => $welcome
            ]);
        } else {
            return response()->json([
                'message' => 'No Welcome data found!',
                'code' => 500,
                'status' => false,
            ]);
        }
    }

    public function banner()
    {
        $banner = Banner::where('type', '=', 'banner')->get();
        if ($banner->count() > 0) {

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'orders' => $banner
            ]);
        } else {
            return response()->json([
                'message' => 'No orders found!',
                'code' => 500,
                'status' => false,
            ]);
        }
    }


    public function privacy()
    {
        $privacy = Banner::where('type', '=', 'privacy')->get();
        if ($privacy->count() > 0) {

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'orders' => $privacy
            ]);
        } else {
            return response()->json([
                'message' => 'No orders found!',
                'code' => 500,
                'status' => false,
            ]);
        }
    }

    public function about_us()
    {
        $about_us = Banner::where('type', '=', 'about us')->get();
        if ($about_us->count() > 0) {

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'orders' => $about_us
            ]);
        } else {
            return response()->json([
                'message' => 'No orders found!',
                'code' => 500,
                'status' => false,
            ]);
        }
    }

    public function ad_details()
    {
        $ad = Banner::where('type', '=', 'ad')->get();
        if ($ad->count() > 0) {

            return response()->json([
                'message' => 'data fetched successfully',
                'code' => 200,
                'status' => true,
                'orders' => $ad
            ]);
        } else {
            return response()->json([
                'message' => 'No orders found!',
                'code' => 500,
                'status' => false,
            ]);
        }
    }

    public function show_articles()
    {
        $articles = Article::paginate(5);

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'status' => true,
            'orders' => $articles
        ]);
    }


    public function article_by_id(Request $request)
    {
        $article = Article::where('id' , $request->article_id)->first();
        $articles = Article::paginate(5);

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'status' => true,
            'article' => $article,
            'other articles' => $articles,
        ]);
    }
}
