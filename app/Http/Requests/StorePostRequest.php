<?php

namespace App\Http\Requests;

use App\Models\Post;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('post_create');
    }

    public function rules()
    {
        return [
            'pages.*' => [
                'integer',
            ],
            'pages' => [
                'array',
            ],
            'title' => [
                'string',
                'min:1',
                'max:250',
                'required',
            ],
            'categories.*' => [
                'integer',
            ],
            'categories' => [
                'array',
            ],
            'status' => [
                'required',
            ],
            'visibility' => [
                'required',
            ],
            'slug' => [
                'string',
                'min:1',
                'max:250',
                'required',
                'unique:posts',
            ],
        ];
    }
}
