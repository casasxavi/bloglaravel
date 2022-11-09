<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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

            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $this->route('post')->id,
            'category_id' => 'required|integer|exists:categories,id',
            'summary' => 'required|string',
            'content' => 'required|string',
            'is_published' => 'required|boolean',
        ];
    }
}
