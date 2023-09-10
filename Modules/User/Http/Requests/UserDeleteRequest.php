<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "user_id" => ["required", Rule::exists("users", "id")->whereNot("id", $this->user()?->id)],
        ];
    }
}
