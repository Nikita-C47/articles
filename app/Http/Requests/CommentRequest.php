<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentRequest extends FormRequest
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
        $rules = [
            'article_id' => 'required|exists:articles,id',
            'content' => 'required'
        ];

        if(!Auth::check()) {
            $rules['author'] = 'required';
            $rules['g-recaptcha-response'] = 'required';
        }

        return $rules;
    }
}
