<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Modules\User\Entities\Address;
use Modules\User\Entities\AddressType;
use Modules\User\Entities\User;
use Modules\User\Exports\UsersExport;
use Modules\User\Http\Requests\UserDeleteRequest;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Interfaces\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    private UserRepositoryInterface $user_repository;

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function user_listing(Request $request): View
    {
        $user_list = $this->user_repository->user_builder($request->all())->get();

        return view("user::user_listing", [
            "user_list" => $user_list,
            "user_status_color_class_list" => User::$user_status_color_class_list,
            "user_status_dropdown" => $this->user_repository->user_status_dropdown(true),
        ]);
    }

    public function user_export(Request $request): BinaryFileResponse
    {
        $user_list = $this->user_repository->user_builder($request->all())->get();

        return Excel::download(new UsersExport($user_list), "users.xlsx");
    }

    public function user_detail($user_id): View
    {
        $user = User::query()->findOrFail($user_id);

        return view("user::user", [
            "user" => $user,
            "user_status_color_class_list" => User::$user_status_color_class_list,
        ]);
    }

    public function user_form($user_id = null): View
    {
        $action = "create";
        $user = null;

        if ($user_id) {
            $action = "update";
            $user = User::query()->findOrFail($user_id);

            $user->input_address_list = $user->address_list->keyBy("address_type_id");
        }

        $address_type_list = AddressType::query()
            ->where("is_active", "=", true)
            ->get();

        return view("user::user_form", [
            "action" => $action,
            "user" => $user,
            "address_type_list" => $address_type_list,
            "user_status_dropdown" => $this->user_repository->user_status_dropdown(),
        ]);
    }

    public function user_update_or_create(UserRequest $request): RedirectResponse
    {
        if ($request->validated("user_id")) {
            $success_msg = "Successfully updated user.";

            $user = User::query()->find($request->validated("user_id"));

            $extraUpdateData = [];
            if ($request->validated("password")) {
                $extraUpdateData["password"] = Hash::make($request->validated("password"));
            }

            $user->update([
                "email" => $request->validated("email"),
                "first_name" => $request->validated("first_name"),
                "last_name" => $request->validated("last_name"),
                "birthdate" => $request->validated("birthdate"),
                ...$extraUpdateData,
            ]);
        } else {
            $success_msg = "Successfully created user.";

            $user = User::query()->create([
                "email" => $request->validated("email"),
                "password" => Hash::make($request->validated("password")),
                "first_name" => $request->validated("first_name"),
                "last_name" => $request->validated("last_name"),
                "birthdate" => $request->validated("birthdate"),
            ]);
        }

        if ($request->validated("status") != $user->status) {
            $user->setStatus($request->validated("status"));
        }

        if ($request->hasFile("profile_image")) {
            $user->addDocument($request->file("profile_image"), "profile_image", true);
        }

        if (!empty($request->validated("address_list"))) {
            foreach ($request->validated("address_list") as $address_input) {
                $address = Address::query()->updateOrCreate(
                    [
                        "user_id" => $user->id,
                        "address_type_id" => $address_input["address_type_id"],
                    ],
                    [
                        "address" => $address_input["address"],
                        "zipcode" => $address_input["zipcode"],
                        "city" => $address_input["city"],
                        "state" => $address_input["state"],
                        "country" => $address_input["country"],
                    ],
                );

                if (!empty($address_input["proof_document"])) {
                    $address->addDocument($address_input["proof_document"], "proof_document", true);
                }
            }
        }

        return redirect(route("user.detail", ["user_id" => $user->id]))->with([
            "success_msg" => $success_msg,
        ]);
    }

    public function user_delete(UserDeleteRequest $request): RedirectResponse
    {
        $user = User::query()->find($request->validated("user_id"));
        $user->delete();

        return redirect(route("user.listing"))->with([
            "success_msg" => "Successfully deleted user.",
        ]);
    }
}
