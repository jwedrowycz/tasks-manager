<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => ['required', 'min:3', 'max:35',],
            'description' => ['required', 'min:3', 'max:100'],
            'expected_end' => ['date', 'after:yesterday'],
            'is_private' => ['required'],
            'start' => ['required']
        ];
    }
}
