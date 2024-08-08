<?php

namespace App\Http\Controllers\Api;

use FCM;
use Auth;
use Cache;
use App\User;
use App\Address;
use App\Image;
use App\Message;
use App\Product;
use App\UserFollow;
use App\Conversation;
use App\RetailSale;
use App\IrregularComment;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class ConversationApiController extends Controller
{
    public function receiver(Request $request)
    {
        try {
            $conv = Conversation::where('status', 1)->where('user_one', $request->user->id)->first();
            if (!$conv) {
                return response()
                ->json(['message'=>'Receiver No','unique'=>NULL, 'address'=>NULL],200);
            }
            $unique = $conv ? $conv->unique : NULL;
            $address = Address::where('id', $conv->address_id)->first();
            return response()
                   ->json(['message'=>'Receiver Get Successful','unique'=>$unique, 'address'=>$address],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getClientChat(Request $request)
    {
        try {
            $conv = Conversation::where('status', 1)->where('user_one', $request->user->id)->first();
            if (!$conv) {
                return response()->json(['message'=>'Receiver No','unique'=>NULL],200);
            }
            $unique = $conv ? $conv->unique : NULL;
            return response()->json(['message'=>'Receiver Get Successful','unique'=>$unique],200);
        } catch (Exception $err) {
            return response()->json($err, 300);
        }
    }

    public function update(Request $request)
    {
        try {
            $conv = Conversation::where('unique', $request->unique)->first();
            if (!$conv) {
                return response()->json(['message'=>'No Unique'], 500);
            }

            $fieldsToUpdate = [
                'packed', 'payable', 'status', 'delivery_fee',
                'address_id', 'payment_id', 'user_one', 'user_two'
            ];

            foreach ($fieldsToUpdate as $field) {
                if ($request->has($field)) {
                    $conv->$field = $request->$field;
                }
            }

            $conv->save();
            return response()
                   ->json(['message'=>'Conv update successful','conv'=>$conv],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function create(Request $request) {
        try {
            $conv = Conversation::where('status', 1)
                ->where('user_one', $request->user->id)
                ->firstOr(function () use ($request) {
                    $unique = Str::random(16);

                    $conv = new Conversation();
                    $conv->unique = $unique;
                    $conv->user_one = $request->user->id;
                    $conv->address_id = $request->address_id;
                    $conv->user_two = 0;
                    $conv->save();

                    Cart::where('status', 0)
                        ->where('deleted_at', NULL)
                        ->where('user_id', $request->user->id)
                        ->update(['conversation_id' => $unique]);

                    return $conv;
                });
            $address = Address::where('id', $conv->address_id)->first();
            $idUserCommentArray = $request['comments'];

            foreach ($idUserCommentArray as $entry) {
                IrregularComment::create([
                    'cart_id' => $entry['id'], // Assuming 'id' in 'idUserCommentArray' is the 'cart_id'
                    'comment' => $entry['userComment'],
                ]);
            }
            // $conv = Conversation::select('user_two')->where('user_one', $request->user->id)->first();
            return response()->json(['message' => 'Receiver Get Successful', 'unique' => $conv->unique, 'address'=>$address], 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 500);
        }
    }

    public function list(Request $request)
    {
        $date = date_create(date("Y-m-d H:i:s"));
        date_sub($date, date_interval_create_from_date_string('7 days'));
        Message::where('is_show', '1')->where('created_at','<',$date)->delete();

        try {
            $receiverUser = User::find($request->receiver_id);
            if ($request->user->type == 0) {
                $conversation = Conversation::where('user_one', $request->user->id)->where('user_two', $receiverUser->id)->first();
            } elseif ($request->user->type == 2) {
                $conversation = Conversation::where('user_two', $request->user->id)->where('user_one', $receiverUser->id)->first();
            }

            $messages = Message::where('conversation_unique', $conversation->unique)->orderBy('created_at', 'ASC')->get();

            foreach ($messages as $message) {
                if ($message->sender_id == $request->receiver_id) {
                    $message->is_show = 1;
                    $message->save();
                }
            }
            return response()
                   ->json(['message'=>'Receiver Get Successful','messages'=>$messages],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function sendTextMessage(Request $request)
    {
        try {
            $message = new Message;
            $message->conversation_unique = $request->receiver_id;
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

    public function moveToMyChat(Request $request) {
        Conversation::where('unique', $request->unique)
            ->update(['user_two' => $request->user->id]);
        try {
            return response()->json(['message'=>'OK'],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getAdminChats(Request $request)
    {
        $convs = Conversation::join('users', 'conversations.user_one', '=', 'users.id')
            ->leftJoin('address', 'conversations.address_id', '=', 'address.id')
            ->select('conversations.*', 'users.profile_image', 'address.delivery_type','address.phone')
            ->where('conversations.status', '<>', '3')
            ->get();
        try {
            return response()->json(['message'=>'OK','data'=>$convs],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getServiceChats(Request $request)
    {
        $convs = Conversation::join('users', 'conversations.user_one', '=', 'users.id')
            ->leftJoin('address', 'conversations.address_id', '=', 'address.id')
            ->select('conversations.*', 'users.profile_image', 'address.delivery_type','address.phone')
            ->where('conversations.user_two', 0)
            ->where('conversations.status', 1)
            ->get();
        try {
            return response()->json(['message'=>'OK','data'=>$convs],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getMyChats(Request $request)
    {
        $convs = Conversation::join('users', 'conversations.user_one', '=', 'users.id')
            ->leftJoin('address', 'conversations.address_id', '=', 'address.id')
            ->select('conversations.*', 'users.profile_image', 'address.delivery_type','address.phone')
            ->where('conversations.user_two', $request->user->id)
            ->where('conversations.status', '<', 3)
            ->get();
        try {
            return response()->json(['message'=>'OK','data'=>$convs],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getChatItem(Request $request)
    {
        try {
            $conv = Conversation::join('users', 'conversations.user_one', '=', 'users.id')
                ->leftJoin('address', 'conversations.address_id', '=', 'address.id')
                ->select('conversations.*', 'users.profile_image', 'users.name', 'address.delivery_type','address.phone')
                ->where('unique', $request->unique)
                ->first();

            if (!$conv) {
                return response()->json(['message' => 'Conversation not found'], 404);
            }

            $items = Cart::join('products', 'carts.product_id', '=', 'products.id')
                ->where('conversation_id', $request->unique)
                ->select('carts.*', 'products.name')
                ->get();

            foreach ($items as $item) {
                $images = Image::where('product_id', $item->product_id)->get();
                $price = RetailSale::select('retailsale')->where('is_available', 1)->where('product_id', $item->product_id)->first();
                $comment = IrregularComment::where('cart_id', $item->id)->first();
                $item->comment = $comment ? $comment : NULL;
                $item->sellPrice = $price ? $price->retailsale : 0;
                $item->images = $images ? $images : [];
            }

            $conv->items = $items;

            return response()->json(['message' => 'Cart Item Fetch Okay!', 'data' => $conv, 'userId' => $request->user->id], 200);
        } catch (Exception $err) {
            return response()->json(['message' => 'Internal Server Error', 'error' => $err->getMessage()], 500);
        }
    }


    public function sendImageMessage(Request $request)
    {
        try {
            $image = 'chat-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('public/images/chat', $image);

            $message = new Message;
            $message->conversation_unique = $request->receiver_id;
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

    public function deleteChat($id)
    {
        try {
            $conv = Conversation::where('unique', $id)->delete();
            $cart=Cart::where('conversation_id', $id)->delete();

            if($conv) {
                return response()->json(['message'=>'Conversation has been deleted'],200);
            } else {
                return response()->json(['message'=>'Somethig went wrong'],400);
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function sendAudioMessage(Request $request)
    {
        try {
            $audio = 'chat-' . uniqid() . '.' . $request->audio->getClientOriginalExtension();
            $request->audio->move('public/audios/chat', $audio);

            $message = new Message;
            $message->conversation_unique = $request->receiver_id;
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
            $video = 'chat-' . uniqid() . '.' . $request->video->getClientOriginalExtension();
            $request->video->move('public/videos/chat', $video);

            $message = new Message;
            $message->conversation_unique = $request->receiver_id;
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
        $conversations = Conversation::where('user_two', $request->user->id)->orderBy('created_at', 'asc')->get();

        $users = array();
        foreach ($conversations as $conversation) {
            $users[] = $conversation->user_one;
        }
        $conversation_users = User::whereIn('id', $users)->get();
        return response()->json(['result' => 'success', 'users' => $conversation_users], 200);
    }

    public function removeMessage(Request $request)
    {
        try {
            $ids = $request->ids;
            foreach($ids as $id) {
                $messages = Message::where('id', $id)->delete();
            }
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getuserinfo(Request $request){
        return response()->json(['result' => 'success', 'user_id' => $request->user->id], 200);
    }

}
