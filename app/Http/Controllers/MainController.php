<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;

class MainController extends Controller
{
    public function index()
    {
        $title = 'الفيديوهات الأكثر مشاهدة خلال هذا الأسبوع';
        $videos = Video::get();
    
        return view('main', compact('videos', 'title'));
    }

    public function channelsVideos(User $channel)
    {
        $videos = Video::where('user_id', $channel->id)->get();
        $title = ' جميع الفيديوهات الخاصة بالقناة: ' . $channel->name;
        return view('videos.my-videos', compact('videos', 'title'));
    }
}
