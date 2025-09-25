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
    $id = $this->route('id') ?? null;

    if ($id) {
       
        return [
            'name'     => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|email|unique:users,email,' . $id,
            'phone'    => 'sometimes|required|numeric|unique:users,phone,' . $id,
            'password' => 'nullable|min:8|max:15',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role'     => 'sometimes|required|in:admin,manager,user',
        ];
    }

    
    return [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'phone'    => 'required|numeric|unique:users,phone',
        'password' => 'required|min:8|max:15',
        'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'role'     => 'required|in:admin,manager,user',
    ];
}

}
