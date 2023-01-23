<?php

namespace App\Http\Requests\GroupRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
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
            'service_id'=>'nullable|integer|exists:App\Models\Service,id',
            'user_id'=>'nullable|integer',
            'name'=>'nullable|string',
        ];
    }
}
