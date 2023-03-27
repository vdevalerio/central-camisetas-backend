<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        'name'      => ['sometimes', 'required', 'string'],
        'price'     => ['sometimes', 'required', 'numeric', 'min:0'],
        'size'      => ['sometimes', 'required', 'string'],
        'type'      => ['sometimes', 'required', 'integer'],
        'model'     => ['sometimes', 'required', 'string'],
        'tissue'    => ['sometimes', 'required', 'string'],
        'color'     => ['sometimes', 'required', 'string'],
        'pocket'    => ['sometimes', 'required', 'boolean'],
        'collar'    => ['sometimes', 'integer'],
        'cuff'      => ['sometimes', 'integer'],
        'vivo'      => ['sometimes', 'boolean'],
        'faixa'     => ['sometimes', 'integer'],
    ];
}

}
