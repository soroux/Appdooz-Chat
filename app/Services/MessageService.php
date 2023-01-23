<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;

class MessageService
{
    public function showAllMessages($service_id, $withRelations, $sender_id,$receiver_id,$type_id, $channel_type_id, $page, $limit = 15, $sortBy = 'created_at')
    {
        $query = Message::query();
        if ($service_id) {
            $query = $query->where('service_id', $service_id);
        }
        if ($sender_id) {
            $query = $query->where('sender_id',$sender_id);
        }
        if ($receiver_id) {
            $query = $query->where('receiver_id',$receiver_id);
        }
        if ($type_id) {
            $query = $query->where('type_id',$type_id);
        }
        if ($channel_type_id) {
            $query = $query->where('channel_type_id', $channel_type_id);
        }

        switch ($sortBy) {
            case 'created_at':
                $query = $query->orderBy("created_at", "desc");
                break;
            default:
                $query = $query->orderBy("created_at", "desc");
                break;
        }
        if ($withRelations) {
            $query = $query->with($withRelations);
        }
        if ($page) {
            return $query->paginate($limit);
        }

        return $query->get();
    }

    public function storeMessage(array $item)
    {
        return Message::create($item);
    }

    public function getMessage($id, $withRelations = null)
    {
        $query = Message::query();
        $query->where('id', $id);
        if ($withRelations) {
            $query = $query->with($withRelations);
        }
        return $query->first();
    }

    public function getMessagesWhereIn(array $ids, $withRelations = null)
    {
        $query = Message::query();
        $query->whereIn('id', $ids);
        if ($withRelations) {
            $query = $query->with($withRelations);
        }
        return $query->get();
    }

    public function updateMessage(array $item, $Message)
    {


        return $Message->update($item);

    }

    public function destroyMessage($Message)
    {
        return $Message->delete($Message);

    }
    public function private_conversation($service_id,$sender_id,$receiver_id,$page, $limit = 15){
        $query = Message::query();
            $query = $query->where('service_id', $service_id);
            $query = $query->where(function (Builder $query) use ($sender_id,$receiver_id) {
                $query->where('sender_id', $sender_id)
                    ->orWhere('receiver_id', $receiver_id);
            });

            $query = $query->orderBy("created_at", "desc");
        if ($page) {
            return $query->paginate($limit);
        }

        return $query->get();

    }

    public function group_conversation($service_id,$sender_id,$group_id,$page, $limit = 15){
        $query = Message::query();
        $query = $query->where('service_id', $service_id);
        $query = $query->where('sender_id', $sender_id);
        $query = $query->where('group_id', $group_id);

        $query = $query->orderBy("created_at", "desc");
        if ($page) {
            return $query->paginate($limit);
        }

        return $query->get();
    }

}
