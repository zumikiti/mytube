<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVideoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVideoRequest $request)
    {
        $input = $request->only([
            'name',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        $input['original_name'] = $originalName;

        if (Video::where('name', $input['name'])->doesntExist()) {
            Video::create($input);
            $file->storeAs('videos', $input['name']);

            // ファイルサイズ
            $size = Storage::disk('local')->size('videos/' . $input['name']);

            return json_encode(['size' => $size]);
        }

        // ファイルの結合
        $filePath = Storage::disk('local')
            ->path('videos/' . $input['name']);
        file_put_contents(
            $filePath,
            file_get_contents($file),
            FILE_APPEND,
        );

        // ファイルサイズ
        $size = Storage::disk('local')->size('videos/' . $input['name']);

        return json_encode(['size' => $size]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVideoRequest  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        //
    }
}
