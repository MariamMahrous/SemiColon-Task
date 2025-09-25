<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required',
            'email'=>'required|email|unique:users,email'.$this->user?->id,
            'phone'=>'required|numeric|unique:users,phone'.$this->user?->id,
            'password'=>'required|min:8|max:15',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role'=>'required|in:admin,manager,user',

        ];
    }
  
}
