<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
          'name' => [
            'required',
            'string',
            'min:3',
            'max:255',
            'regex:/^[A-Za-z\s]+$/'
          ],
          'email' => [
            'required',
            'email',
            'unique:users'
          ],
          'password' => [
            'required',
            'string',
            'confirmed',
            Password::min(6)
              ->letters()
              ->mixedCase()
              ->numbers()
              ->symbols()
              ->uncompromised()
          ],
        ];
    }
}
