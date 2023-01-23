<?php

namespace App\Http\Requests\MessageRequests;

use Illuminate\Foundation\Http\FormRequest;

class GetGroupConversationRequest extends FormRequest
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
            'group_id'=>'required|integer',
        ];
    }
}
