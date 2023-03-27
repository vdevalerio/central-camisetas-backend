<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name'      => ['required', 'string', 'max:255'],
            'price'     => ['required', 'numeric', 'min:0'],
            'size'      => ['required', 'string', 'max:255'],
            'type'      => ['required', 'integer'],
            'model'     => ['required', 'string', 'max:255'],
            'tissue'    => ['required', 'string', 'max:255'],
            'color'     => ['required', 'string', 'max:255'],
            'pocket'    => ['required', 'boolean'],
            'collar'    => ['nullable', 'integer'],
            'cuff'      => ['nullable', 'integer'],
            'vivo'      => ['nullable', 'boolean'],
            'faixa'     => ['nullable', 'integer'],
        ];
    }
}
