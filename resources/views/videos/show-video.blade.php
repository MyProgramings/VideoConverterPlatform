@extends('layouts.main')
 
@section('content')
<div class="container">
    <div class="row">
        <div class="mx-auto col-9"> 
            <input id="videoId" type="hidden" value="{{$video->id}}">

            <div class='vidcontainer'>
                @foreach($video->convertedvideos as $video_converted)
                    <video id="videoPlayer" controls style= '{{ $video->Longitudinal == "0" ? "width: 100%; height: 90%;" : "width: 900px; height: 510px;"}}'>
                        @if($video->quality == 1080)
                            <source id="webm_source" src="{{ Storage::url($video_converted->webm_Format_1080) }}" type="video/webm">   
                            <source id="mp4_source" src="{{ Storage::url($video_converted->mp4_Format_1080) }}" type="video/mp4">
                        @elseif($video->quality == 720)
                            <source id="webm_source" src="{{ Storage::url($video_converted->webm_Format_720) }}" type="video/webm">
                            <source id="mp4_source" src="{{ Storage::url($video_converted->mp4_Format_720) }}" type="video/mp4">
                        @elseif($video->quality == 480)
                            <source id="webm_source" src="{{ Storage::url($video_converted->webm_Format_480) }}" type="video/webm">
                            <source id="mp4_source" src="{{ Storage::url($video_converted->mp4_Format_480) }}" type="video/mp4">
                        @elseif($video->quality == 360)
                            <source id="webm_source" src="{{ Storage::url($video_converted->webm_Format_360) }}" type="video/webm"> 
                            <source id="mp4_source" src="{{ Storage::url($video_converted->mp4_Format_360) }}" type="video/mp4">
                        @else
                            <source id="webm_source" src="{{ Storage::url($video_converted->webm_Format_240) }}" type="video/webm"> 
                            <source id="mp4_source" src="{{ Storage::url($video_converted->mp4_Format_240) }}" type="video/mp4">
                        @endif
                    </video>
                @endforeach
            </div>
            <select id='qualityPick'>
                <option value="1080" {{ $video->quality == 1080 ? 'selected' : ''}} {{ $video->quality < 1080 ? 'hidden' : ''}}>1080p</option>
                <option value="720" {{ $video->quality == 720 ? 'selected' : ''}} {{ $video->quality < 720 ? 'hidden' : ''}}>720p</option>
                <option value="480" {{ $video->quality == 480 ? 'selected' : ''}} {{ $video->quality < 480 ? 'hidden' : ''}}>480p</option>
                <option value="360" {{ $video->quality == 360 ? 'selected' : ''}} {{ $video->quality < 360 ? 'hidden' : ''}}>360p</option>
                <option value="240" {{ $video->quality == 240 ? 'selected' : ''}}>240p</option> 
            </select>
            <div class="title mt-3">
                <h5>
                    {{$video->title}}
                </h5>
            </div>

            <div class="interaction text-center mt-5">
                <a href="#" class="like ml-3">
                   
                    
                </a> | 
                <a href="#" class="like mr-3">
           
                </a>

                <div class="loginAlert mt-5">
                    
                </div>
            </div>

            <div class="mt-4 px-2">
                <div class="comments">
                    <div class="mb-3">
                        <span>التعليقات</span>
                    </div>
                    <div>
                        <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="إضافة تعليق عام"></textarea>
                        <button type="submit" class="btn btn-info mt-3 saveComment">تعليق</button>
                        
                        <div class="commentAlert mt-5">
                    
                        </div>

                        <div class="commentBody">
                      
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endSection

@section('script')


@endSection