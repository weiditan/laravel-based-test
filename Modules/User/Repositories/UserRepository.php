<?php

namespace Modules\User\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\User\Entities\User;
use Modules\User\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function user_builder(array $search = []): Builder
    {
        return User::query()
            ->with(["document_list", "address_list.address_type"])
            ->when(!empty($search["keyword"]), function (Builder $query_keyword) use ($search) {
                $query_keyword
                    ->where("email", "=", $search["keyword"])
                    ->orWhere("first_name", "like", "%" . $search["keyword"] . "%")
                    ->orWhere("last_name", "like", "%" . $search["keyword"] . "%");
            })
            ->orderBy("created_at");
    }
}
