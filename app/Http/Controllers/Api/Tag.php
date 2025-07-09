<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Tag extends Controller
{
    public function store_tag(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'tag_nutriheaven_excerise_id' => 'required|integer',
            'tag_name' => 'required|string|max:255',
            'tag_description' => 'nullable|string|max:500',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $user_id = auth('sanctum')->id();

        $tag = new \App\Models\Tag();
        $tag->tag_nutriheaven_excerise_id = $request->input('tag_nutriheaven_excerise_id');
        $tag->tag_name = $request->input('tag_name');
        $tag->tag_description = $request->input('tag_description');
        $tag->save();

        return response()->json(['status' => 'success', 'message' => 'Tag added successfully', 'data' => $tag], 201);
    }
}
