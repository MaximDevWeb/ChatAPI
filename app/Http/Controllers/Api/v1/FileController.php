<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        sleep(5);

        $request->validate([
            'path' => 'required|string',
            'type' => 'required|string',
            'file' => 'required|file'
        ]);

        $path = $request->file('file')->storePublicly($request->path);
        $link = Storage::url($path);

        $file = new File();
        $file->user_id = Auth::id();
        $file->path = $path;
        $file->link = $link;
        $file->type = $request->type;
        $file->original_name = $request->file('file')->getClientOriginalName();
        $file->save();

        return response()->json([
            'status' => 'success',
            'id' => $file->id,
            'type' => $file->type
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
