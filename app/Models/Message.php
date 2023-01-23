<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function sender(){
        return $this->belongsTo(User::class,'sender_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class,'receiver_id');
    }
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function type(){
        return  $this->belongsTo(Type::class);
    }
    public function channelType(){
        return  $this->belongsTo(ChannelType::class);
    }
    public function replyMessage(){
        return $this->belongsTo(Message::class,'reply_id');
    }
}
