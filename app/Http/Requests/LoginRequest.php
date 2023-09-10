<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Entities\User;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "email" => ["required", "email"],
            "password" => ["required"],
        ];
    }

    /**
     * @throws ValidationException
     */
    protected function passedValidation()
    {
        $user = User::query()
            ->where("email", "=", $this->get("email"))
            ->first();

        if (!$user || !Hash::check($this->get("password"), $user->password)) {
            throw ValidationException::withMessages(["password" => "Your email or password is incorrect."]);
        }

        if ($user->status != "approved") {
            throw ValidationException::withMessages(["email" => "Your account are $user->status."]);
        }
    }
}
