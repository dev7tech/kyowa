<?php

namespace App\Http\Controllers\admin;

use FCM;
use Auth;
use App\User;
use App\Image;
use App\Message;
use App\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class ConversationController extends Controller
{
    public function showSingleChat(Request $request, $id)
    {
        try {
            $conversations = Conversation::all();
            $conversation = Conversation::where('user_one', $id)->first();
            
            $chatuser = User::find($conversation->user_one);
            $single_conversation['username'] = $chatuser->name;
            $messages = Message::where('conversation_unique', $conversation->unique)->orderBy('created_at', 'ASC')->get();
            $single_conversation['messages'] = $messages;

            $users = array();
            foreach ($conversations as $conversation) {
                $users[] = $conversation->user_one;
            }
            $conversation_users = User::whereIn('id', $users)->get();

            return view('chatusersingle', ['conversation_users' => $conversation_users, 'singleConv' => $single_conversation, 'my_id' => $id]);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function sendTextMessage(Request $request)
    {
        try {
            $receiverUser = User::find($request->receiver_id);
            $conversation = Conversation::where('user_one', $request->user->id)->where('user_two', $receiverUser->id)->first();

            $message = new Message;
            $message->conversation_unique = $conversation->unique;
            $message->type = 1;
            $message->content_text = $request->message;
            $message->sender_id = $request->user->id;
            $message->save();

            // // if (!Cache::has('superadmin_online')) {
            // //     $localNotify = new LocalNotification;
            // //     $localNotify->notify_text = "you have unread message from ".$username;
            // //     $localNotify->action_url = url('chat/user/'.$conversation->unique);
            // //     $localNotify->admin_id = $super_admin->id;
            // //     $localNotify->save();
            // // }

            // $notificationBuilder = new PayloadNotificationBuilder('You have a new message.');
            // $notificationBuilder->setBody($username.' sent you a message.')
            // 				    ->setSound('default')
            //                     ->setBadge('0');

            // $notification = $notificationBuilder->build();

            // $dataBuilder = new PayloadDataBuilder();
            // $dataBuilder->addData(['content_body' => $message->content_text,'unique' => $message->conversation_unique, 'type' => 1, 'created_at' => $message->created_at->format('Y-m-d H:i:s')]);
            // $data = $dataBuilder->build();

            // $token = $receiverUser->token;

            // $downstreamResponse = FCM::sendTo($token, null, $notification, $data);

            // $downstreamResponse->numberSuccess();
            // $downstreamResponse->numberFailure();
            // $downstreamResponse->numberModification();
            // $downstreamResponse->tokensToDelete();
            // $downstreamResponse->tokensToModify();
            // $downstreamResponse->tokensToRetry();

            return response()->json(['result' => 'success'],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function sendImageMessage(Request $request)
    {
        try {
            $receiverUser = User::find($request->receiver_id);

            $image = 'chat-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('public/images/chat', $image);
            
            $conversation = Conversation::where('user_one', $request->user->id)->where('user_two', $receiverUser->id)->first();

            $message = new Message;
            $message->conversation_unique = $conversation->unique;
            $message->type = 2;
            $message->content_image = $image;
            $message->sender_id = $request->user->id;
            $message->save();

            // // if (!Cache::has('superadmin_online')) {
            // //     $localNotify = new LocalNotification;
            // //     $localNotify->admin_id = $super_admin->id;
            // //     $localNotify->notify_text = "you have unread message from ".$username;
            // //     $localNotify->action_url = url('chat/user/'.$conversation->unique);
            // //     $localNotify->save();
            // // }

            // $notificationBuilder = new PayloadNotificationBuilder('You have a new message.');
            // $notificationBuilder->setBody($username.' sent you a Image message.')
            // 				    ->setSound('default')
            //                     ->setBadge('0');

            // $notification = $notificationBuilder->build();

            // $dataBuilder = new PayloadDataBuilder();
            // $dataBuilder->addData(['image_url' => $image_url,'unique' => $message->conversation_unique, 'type' => 2, 'created_at' => $message->created_at->format('Y-m-d H:i:s')]);
            // $data = $dataBuilder->build();

            // $token = $receiverUser->token;

            // $downstreamResponse = FCM::sendTo($token, null, $notification, $data);

            // $downstreamResponse->numberSuccess();
            // $downstreamResponse->numberFailure();
            // $downstreamResponse->numberModification();
            // $downstreamResponse->tokensToDelete();
            // $downstreamResponse->tokensToModify();
            // $downstreamResponse->tokensToRetry();

            return response()->json(['result' => 'success', 'image' => $image], 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function sendAudioMessage(Request $request)
    {
        try {
            $receiverUser = User::find($request->receiver_id);

            $audio = 'chat-' . uniqid() . '.' . $request->audio->getClientOriginalExtension();
            $request->audio->move('public/audios/chat', $audio);
            
            $conversation = Conversation::where('user_one', $request->user->id)->where('user_two', $receiverUser->id)->first();

            $message = new Message;
            $message->conversation_unique = $conversation->unique;
            $message->type = 3;
            $message->content_audio = $audio;
            $message->sender_id = $request->user->id;
            $message->save();

            // // if (!Cache::has('superadmin_online')) {
            // //     $localNotify = new LocalNotification;
            // //     $localNotify->admin_id = $super_admin->id;
            // //     $localNotify->notify_text = "you have unread message from ".$username;
            // //     $localNotify->action_url = url('chat/user/'.$conversation->unique);
            // //     $localNotify->save();
            // // }

            // $notificationBuilder = new PayloadNotificationBuilder('You have a new message.');
            // $notificationBuilder->setBody($username.' sent you a Image message.')
            // 				    ->setSound('default')
            //                     ->setBadge('0');

            // $notification = $notificationBuilder->build();

            // $dataBuilder = new PayloadDataBuilder();
            // $dataBuilder->addData(['image_url' => $image_url,'unique' => $message->conversation_unique, 'type' => 2, 'created_at' => $message->created_at->format('Y-m-d H:i:s')]);
            // $data = $dataBuilder->build();

            // $token = $receiverUser->token;

            // $downstreamResponse = FCM::sendTo($token, null, $notification, $data);

            // $downstreamResponse->numberSuccess();
            // $downstreamResponse->numberFailure();
            // $downstreamResponse->numberModification();
            // $downstreamResponse->tokensToDelete();
            // $downstreamResponse->tokensToModify();
            // $downstreamResponse->tokensToRetry();

            return response()->json(['result' => 'success', 'audio' => $audio], 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function sendVideoMessage(Request $request)
    {
        try {
            $receiverUser = User::find($request->receiver_id);

            $video = 'chat-' . uniqid() . '.' . $request->video->getClientOriginalExtension();
            $request->video->move('public/videos/chat', $video);
            
            $conversation = Conversation::where('user_one', $request->user->id)->where('user_two', $receiverUser->id)->first();

            $message = new Message;
            $message->conversation_unique = $conversation->unique;
            $message->type = 4;
            $message->content_video = $video;
            $message->sender_id = $request->user->id;
            $message->save();

            // // if (!Cache::has('superadmin_online')) {
            // //     $localNotify = new LocalNotification;
            // //     $localNotify->admin_id = $super_admin->id;
            // //     $localNotify->notify_text = "you have unread message from ".$username;
            // //     $localNotify->action_url = url('chat/user/'.$conversation->unique);
            // //     $localNotify->save();
            // // }

            // $notificationBuilder = new PayloadNotificationBuilder('You have a new message.');
            // $notificationBuilder->setBody($username.' sent you a Image message.')
            // 				    ->setSound('default')
            //                     ->setBadge('0');

            // $notification = $notificationBuilder->build();

            // $dataBuilder = new PayloadDataBuilder();
            // $dataBuilder->addData(['image_url' => $image_url,'unique' => $message->conversation_unique, 'type' => 2, 'created_at' => $message->created_at->format('Y-m-d H:i:s')]);
            // $data = $dataBuilder->build();

            // $token = $receiverUser->token;

            // $downstreamResponse = FCM::sendTo($token, null, $notification, $data);

            // $downstreamResponse->numberSuccess();
            // $downstreamResponse->numberFailure();
            // $downstreamResponse->numberModification();
            // $downstreamResponse->tokensToDelete();
            // $downstreamResponse->tokensToModify();
            // $downstreamResponse->tokensToRetry();

            return response()->json(['result' => 'success', 'video' => $video], 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getConversationUsers(Request $request)
    {
        $conversations = Conversation::all();

        $users = array();
        foreach ($conversations as $conversation) {
            $users[] = $conversation->user_one;
        }
        $conversation_users = User::whereIn('id', $users)->get();
        return view('chatUser',compact('conversation_users'));
    }

    public function removeMessage(Request $request)
    {
        try {
            $ids = $request->ids;
            foreach($ids as $id) {
                $messages = Message::where('sender_id', $request->user->id)->where('id', $id)->delete();
            }
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
