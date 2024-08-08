<div class="m-messenger__userinfo">
    <span>{{$conversation['username']}}</span>
</div>
<div class="m-messenger__messages messenger-message-container__lizhe" id="messenger-message-container">
    @foreach ($conversation['messages'] as $message)
    <div class="m-messenger__wrapper">
        @if ($message->sender_id == $my_id)
        <div class="m-messenger__message m-messenger__message--in">
            <div class="m-messenger__message-body">
                <div class="m-messenger__message-arrow"></div>
                <div class="m-messenger__message-content">
                    @if ($message->type == 1)
                        <div class="m-messenger__message-text"><?php echo str_replace( "\n", '<br />', $message->content_text ); ?></div>
                    @elseif ($message->type == 2)
                        <div class="m-messenger__message-image">
                            <img src="{{asset('public/images/chat/'.$message->content_image)}}" alt="">
                        </div>
                    @elseif ($message->type == 3)
                        <div class="m-messenger__message-audio">
                        <audio controls>
                            <source src="{{asset('public/audios/chat/'.$message->content_audio)}}" > Your browser does not support the audio element. </audio>
                        </div>
                    @elseif ($message->type == 4)
                        <div class="m-messenger__message-video">
                        <video width="320" height="240" controls>   
                            <source src="{{asset('public/videos/chat/'.$message->content_video)}}"> Your browser does not support the video tag. </video>
                        </div>
                    @endif
                    <div class="m-messenger__message-time">{{$message->created_at->diffForHumans()}}</div>
                </div>
            </div>
        </div>
        @else
        <div class="m-messenger__message m-messenger__message--out">
            <div class="m-messenger__message-body">
                <div class="m-messenger__message-arrow"></div>
                <div class="m-messenger__message-content">
                    @if ($message->type == 1)
                        <div class="m-messenger__message-text"><?php echo str_replace( "\n", '<br />', $message->content_text ); ?></div>
                        
                    @elseif ($message->type == 2)
                        <div class="m-messenger__message-image">
                            <img src="{{asset('public/images/chat/'.$message->content_image)}}" alt="">
                        </div>
                        
                    @elseif ($message->type == 3)
                        <div class="m-messenger__message-audio">
                        <audio controls>
                            <source src="{{asset('public/audios/chat/'.$message->content_audio)}}" > Your browser does not support the audio element. </audio>
                        </div>
                    @elseif ($message->type == 4)
                        <div class="m-messenger__message-video">
                        <video width="320" height="240" controls>   
                            <source src="{{asset('public/videos/chat/'.$message->content_video)}}"> Your browser does not support the video tag. </video>
                        </div>
                    @endif
                    <div class="m-messenger__message-time">{{$message->created_at->diffForHumans()}}</div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>

