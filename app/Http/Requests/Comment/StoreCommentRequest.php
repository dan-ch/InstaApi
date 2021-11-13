<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'content' => ['required', 'string'],
            'post_id' => ['required', 'integer', 'exists:posts,id'],
            'author_id' => ['required', 'integer'], //'exists:users,id'
            'related_comment_id' => ['nullable', 'integer', 'exists:comments,id'],
        ];
    }
}
