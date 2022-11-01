<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOfficeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'            => ['required', 'string'],
            'description'      => ['required', 'string'],
            'lat'              => ['required', 'numeric'],
            'lng'              => ['required', 'numeric'],
            'address_line_1'   => ['required', 'string'],
            'address_line_2'   => ['nullable', 'string'],
            'hidden'           => ['bool'],
            'price_per_day'    => ['required', 'numeric', 'min:100'],
            'monthly_discount' => ['nullable', 'integer', 'min:0'],
            'tags'             => ['array'],
            'approval_status'  => ['integer'],
            'user_id'          => ['required', 'exists:users,id'],
            'tags.*'           => ['integer', Rule::exists('tags', 'id')],
        ];
    }
}
