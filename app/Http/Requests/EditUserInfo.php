<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class EditUserInfo extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(User $user)
    {
        if (!$user) {
            return false;

        } else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //validation
            'name' => 'required|string|max:50|alpha_spaces',
            'tel' => 'required|digits:10',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:20',
            'state' => 'required|string|size:2',
            'zip' => 'required|string|min:5',
        ];
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'zip' => 'zip code',
            'tel' => 'Phone Number'
        ];
    }
}
