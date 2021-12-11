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
        $rules =  [
            'content' => ['required', 'string'],
            'post_id' => ['required_without:parent_comment_id', 'integer', 'exists:posts,id'],
            ];
            if(!$this->request->get('post_id')){
                $rules['parent_comment_id'] = ['required_without:post_id', 'integer', 'exists:comments,id'];
            }
            return $rules;

    }
}
