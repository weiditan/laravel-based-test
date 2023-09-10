<?php

namespace Modules\User\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\User\Entities\User;
use Modules\User\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function user_status_dropdown(bool $with_all = false): array
    {
        if ($with_all) {
            $user_status_dropdown = ["" => "All"];
        } else {
            $user_status_dropdown = [];
        }

        foreach (User::$user_status_color_class_list as $key => $value) {
            $user_status_dropdown[$key] = ucfirst($key);
        }

        return $user_status_dropdown;
    }

    public function user_builder(array $search = []): Builder
    {
        return User::query()
            ->with(["document_list", "address_list.address_type", "statuses"])
            ->when(!empty($search["keyword"]), function (Builder $query_keyword) use ($search) {
                $query_keyword
                    ->where("email", "=", $search["keyword"])
                    ->orWhere("first_name", "like", "%" . $search["keyword"] . "%")
                    ->orWhere("last_name", "like", "%" . $search["keyword"] . "%");
            })
            ->when(!empty($search["status"]), function (Builder $query_status) use ($search) {
                $query_status->currentStatus($search["status"]);
            })
            ->orderBy("created_at");
    }
}
