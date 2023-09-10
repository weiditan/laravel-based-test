<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "user_id" => ["exclude_unless:action,update", "required", "exists:users,id"],
            "email" => ["required", Rule::unique("users", "email")->whereNot("id", $this->get("user_id"))],
            "password" => ["required_if:action,create", "nullable", "regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/"],
            "confirm_password" => ["required_with:password", "nullable", "same:password"],
            "first_name" => ["required"],
            "last_name" => ["required"],
            "birthdate" => ["required", "date_format:Y-m-d"],
            "profile_image" => ["nullable", "file", "mimes:jpeg,png"],
            "status" => ["required"],

            "address_list" => ["nullable", "array"],
            "address_list.*.address_type_id" => ["required", "exists:address_types,id"],
            "address_list.*.address" => ["required"],
            "address_list.*.zipcode" => ["required"],
            "address_list.*.city" => ["required"],
            "address_list.*.state" => ["required"],
            "address_list.*.country" => ["required"],
            "address_list.*.proof_document" => ["required_if:action,create", "nullable", "file", "mimes:jpeg,png,pdf"],
        ];
    }

    public function messages(): array
    {
        return [
            "required_if" => "The :attribute field is required.",
        ];
    }

    public function attributes(): array
    {
        return [
            "address_list.*.address" => "address",
            "address_list.*.zipcode" => "zipcode",
            "address_list.*.city" => "city",
            "address_list.*.state" => "state",
            "address_list.*.country" => "country",
            "address_list.*.proof_document" => "proof document",
        ];
    }
}
