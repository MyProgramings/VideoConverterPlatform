<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Video;
use Storage;
use Illuminate\Support\Str;
use App\Jobs\ConvertVideoForStreaming;
use App\Models\Convertedvideo;
use App\Models\Like;
use App\Models\View;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $videos = auth()->user()->videos->sortByDesc('created_at');
        $title = 'آخر الفيديوهات المرفوعة';
        return view('videos.my-videos', compact('videos', 'title'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('videos.uploader');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'image|required',
            'video' => 'required',
        ]);

        $randomPath = Str::random(16);

        $videoPath = $randomPath . '.' . $request->video->getClientOriginalExtension();
        $imagePath = $randomPath . '.' . $request->image->getClientOriginalExtension();

        $manager = new ImageManager(new Driver());
        
        $img = $manager->read($request->image);

        $img = $img->resize(320, 180)->save();

        $request->video->storeAs('/convert', $videoPath, 'public');
        $request->image->storeAs('/convert', $imagePath, 'public');

        $video = Video::create([
            'disk'        => 'public',
            'video_path'  => $videoPath,
            'image_path'  => $imagePath,
            'title'       => $request->title,
        ]);

        ConvertVideoForStreaming::dispatch($video);

        return redirect()->back()->with(
            'success',
            'سيكون مقطع الفيديو متوفر في أقصر وقت عندما ننتهي من معالجته'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        return view('videos.show-video', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }

    public function search(Request $request)
    {

    }

    public function addView(Request $request)
    {
        
    }

    public function mostViewedVideos()
    {
        
    }
}
