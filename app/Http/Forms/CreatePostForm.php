<?php

namespace App\Http\Forms;

use App\Rules\SpamFree;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\ThrottleException;
use Illuminate\Foundation\Http\FormRequest;
use App\Notifications\YouWereMentioned;
use App\User;

class CreatePostForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new \App\Reply);
    }

    public function failedAuthorization()
    {
        throw new ThrottleException('Too many posts');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', new SpamFree],
        ];
    }

    public function persist($thread)
    {
        return $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id(),
            ])->load('owner');
    }
}
