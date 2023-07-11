<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnlineMemberForm extends FormRequest
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
            //
            'member_no' => 'required|integer',
            'password' => 'required|max:8|alpha_num',
            // 'name' => 'required',
            // 'age' => 'required',
            // 'sex' => 'required',
            // 'zip' => 'required',
            // 'address' => 'required',
        ];
    }
}
