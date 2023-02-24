<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameRecordsUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'event_id' => 'required|numeric|max:9999',
            'got_money' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'event_id.required' => 'event_id是必填的',
            'event_id.numeric' => 'event_id必須是數字',
            'event_id.max' => '無效的event_id', // test
            'got_money.required' => 'got_money是必填的',
            'got_money.numeric' => 'event_id必須是數字',
        ];
    }
}
