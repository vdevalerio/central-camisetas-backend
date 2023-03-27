<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
        $user = Route::current()->parameter('user');

        return [
          'name' => [
            'sometimes',
            'required',
            'string',
            'min:3',
            'max:255',
            'regex:/^[A-Za-z\s]+$/'
          ],
          'email' => [
            'sometimes',
            'email',
            Rule::unique('users')->ignore($user)
          ],
          'password' => [
            'sometimes',
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
