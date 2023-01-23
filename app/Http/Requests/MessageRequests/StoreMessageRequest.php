<?php

namespace App\Http\Requests\MessageRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'service_id'=>'required|integer|exists:App\Models\Service,id',
            'sender_id'=>'required|integer',
            'receiver_id'=>'nullable|integer',
            'group_id'=>'nullable|integer|exists:App\Models\Group,id',
            'message'=>'nullable|string',
            'attachment_file'=>'nullable|file',
            'reply_id'=>'nullable|integer|exists:App\Models\Message,id',
            'type_id'=>'nullable|integer|exists:App\Models\Type,id',
            'channel_type_id'=>'nullable|integer|exists:App\Models\ChannelType,id',
        ];
    }
}
