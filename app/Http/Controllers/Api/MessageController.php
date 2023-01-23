<?php

namespace App\Http\Controllers\Api;

use App\Events\GroupMessageEvent;
use App\Events\PrivateMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequests\GetGroupConversationRequest;
use App\Http\Requests\MessageRequests\GetPrivateConversationRequest;
use App\Http\Requests\MessageRequests\StoreMessageRequest;
use App\Http\Requests\MessageRequests\UpdateMessageRequest;
use App\Http\Resources\MessageResources\MessageCollection;
use App\Http\Resources\MessageResources\MessageResource;
use App\Models\Message;
use App\Services\MessageService;
use Exception;
use Illuminate\Http\Request;

/**
 * @group Message management
 *
 * APIs for managing messages
 */
class MessageController extends Controller
{

    /**
     * @var MessageService
     */
    private $MessageService;

    public function __construct(MessageService $MessageService)
    {
        $this->MessageService = $MessageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @bodyParam name string The name of the application. Example: test
     * @bodyParam user_id int The id of the user. Example: 1
     * @bodyParam service_id int The id of the service. Example: 1
     * @bodyParam withRelations array The array of the requested relations. Example: creator
     * @bodyParam page int page number. Example: 1
     * @bodyParam limit int per page results. Example: 15
     * @bodyParam sortBy string requested sort by. Example: created_at
     * @return MessageCollection
     */
    public function index(Request $request)
    {
        //
        $Messages = $this->MessageService->showAllMessages($request->service_id, $request->withRelations, $request->sender_id, $request->receiver_id, $request->type_id, $request->channel_type_id, $request->page, $request->limit, $request->sortBy);
        return new MessageCollection($Messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MessageRequests\StoreMessageRequest  $request
     * @return MessageResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreMessageRequest $request)
    {
        //
        $input = $request->all();
        $message = $this->MessageService->storeMessage($input);

        if ($message){
            try {
                $sender = $message->sender;
                $receiver = $message->receiver;
                $group = $message->group;
                $data = [];

                if ($message->channel_type_id==1){

                    $data['sender_id'] = $message->sender_id;
                    $data['sender_name'] = $sender->first_name;
                    $data['receiver_id'] = $receiver->id;
                    $data['reply'] = $message->replyMessage;
                    $data['message'] = $message->message;
                    $data['attachment_file'] = $message->attachment_file;
                    $data['created_at'] = $message->created_at;
                    $data['message_id'] = $message->id;

                    event(new PrivateMessageEvent($data));
                }

                if ($message->channel_type_id==2){
                    $data['sender_id'] = $message->sender_id;
                    $data['sender_name'] = $sender->first_name;
                    $data['group_id'] = $group->id;
                    $data['reply'] = $message->replyMessage;
                    $data['message'] = $message->message;
                    $data['attachment_file'] = $message->attachment_file;
                    $data['created_at'] = $message->created_at;
                    $data['message_id'] = $message->id;
                    event(new GroupMessageEvent($data));

                }
                return new MessageResource($message);
            }catch (Exception $e) {
                $message->delete();
            }
            return  response()->json('failed',400);


        }

    }

    /**
     * Display the specified resource.
     *
     * @bodyParam withRelations array The array of the requested relations. Example: creator
     *
     * @param \App\Models\Service $service
     * @return MessageResource
     */
    public function show(Message $Message, Request $request)
    {
        //
        $Message = $this->MessageService->getMessage($Message->id, $request->withRelations);
        return new MessageResource($Message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MessageRequests\UpdateMessageRequest  $request
     * @param  \App\Models\Message  $Message
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMessageRequest $request, Message $Message)
    {
        //
        $input = $request->all();

        $this->MessageService->updateMessage($input, $Message);
        return  response()->json('success',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $Message
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Message $Message)
    {
        //
        $this->MessageService->destroyMessage($Message);
        return response()->json('success', 200);
    }
    /**
     * get private conversation the specified resource in storage.
     *
     * @param  \App\Http\Requests\MessageRequests\GetPrivateConversationRequest  $request
     * @return MessageCollection
     */
    public function privateConversation(GetPrivateConversationRequest $request){
    $messages = $this->MessageService->private_conversation($request->service_id,$request->sender_id,$request->recever_id,$request->page,$request->limit);

        return new MessageCollection($messages);

    }
    /**
     * get group conversation the specified resource in storage.
     *
     * @param  \App\Http\Requests\MessageRequests\GetGroupConversationRequest  $request
     * @return MessageCollection
     */
    public function groupConversation(GetGroupConversationRequest $request){
        $messages = $this->MessageService->group_conversation($request->service_id,$request->sender_id,$request->group_id,$request->page,$request->limit);

        return new MessageCollection($messages);

    }
}
