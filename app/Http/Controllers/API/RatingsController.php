<?php

namespace App\Http\Controllers\API;

use App\Models\Store;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RatingsController extends Controller
{
    public function index($store_id)
    {
        try {
            $store = Store::findOrFail($store_id);
        }
        catch (\Exception $e) {
            return Response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }
        $ratings = $store->ratings;
        return response()->json([
            'status' => true,
            'store_id' => $store_id,
            'ratings' => $ratings
        ], 200);
    }

    public function store(Request $request, $store_id)
    {
        try {
            $store = Store::findOrFail($store_id);
        }
        catch (\Exception $e) {
            return Response()->json([
                'status' => false,
                'message' => 'Store not found'
            ], 404);
        }
        $rating = Rating::create([
            'store_id' => $store_id,
            'score' => $request->score,
            'comment' => $request->comment
        ]);
        return response()->json([
            'status' => true,
            'rating' => $rating
        ], 201);
    }

    public function likeComment(Request $request, $store_id)
    {
        if(empty($request->rating_id) || !is_numeric($request->rating_id)) {
            return Response()->json([
                'status' => false,
                'message' => 'Thiếu tham số rating_id hoặc không đúng định dạng.'
            ]);
        }
        try {
            $store = Store::findOrFail($store_id);
            $rating = Rating::findOrFail($request->rating_id);
        }
        catch (\Exception $e) {
            return Response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }
        if ($rating->store_id != $store_id) {
            return Response()->json([
                'status' => false,
                'message' => 'Comment not own store'
            ]);
        }
//        dd($rating->like_count);
        $rating->like_count++;
        $rating->save();
        return response()->json([
            'status' => true,
            'rating' => $rating
        ], 200);
    }
}