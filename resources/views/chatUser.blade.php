@extends('theme.default')

<link href="{{asset('public/assets/plugins/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('public/assets/plugins/style.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('public/css/chat.css')}}" rel="stylesheet" type="text/css" />
<style media="screen">
    body.swal2-height-auto {
        height: 100%!important;
    }
</style>
<link href="{{asset('assets/plugins/loader.css')}}" rel="stylesheet" type="text/css" />

@section('content')

<div class="m-portlet m-portlet--mobile m-portlet-chat">
    <div class="chat-portlet-user-list-container">
        <div class="m-widget4 chat-portlet-user-list">
            @foreach ($conversation_users as $conversation_user)
                <a href="{{url('admin/chat/user/'.$conversation_user->id)}}" id="user-list-{{$conversation_user->id}}" class="chat-single-user-list-item m-widget4__item">
                    <div class="m-widget4__img m-widget4__img--logo">
                        <img src="{{asset('public/images/profile/'.$conversation_user->profile_image)}}" alt="">
                    </div>
                    <div class="m-widget4__info">
                        <span class="m-widget4__title">
                            {{$conversation_user->name}}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="chat-portlet-chat-form-container" id="chat-portlet-chat-form-container">
    </div>
</div>

@endsection

<script src="{{asset('public/assets/plugins/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/plugins/scripts.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('public/js/initFire.js')}}" type="text/javascript"></script>
<script src="{{asset('public/js/diffForHumans.js')}}" type="text/javascript"></script>
<script src="{{asset('public/js/mUserChat.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $("#headerUrl").html("<h3>历史 > 聊天</h3>");
    })
</script>
