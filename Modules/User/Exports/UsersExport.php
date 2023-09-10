<?php

namespace Modules\User\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Modules\User\Entities\AddressType;

class UsersExport implements FromArray
{
    private Collection $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $address_type_array = AddressType::query()
            ->where("is_active", "=", true)
            ->pluck("name", "id")
            ->toArray();

        $header = [
            "Id",
            "Email",
            "First Name",
            "Last Name",
            "Birthdate",
            "Created At",
            "Status",
            ...$address_type_array,
        ];
        $data = $this->data
            ->map(function ($user) use ($address_type_array) {
                $address_array = [];
                foreach ($address_type_array as $address_type_id => $address_type_name) {
                    $address = $user->address_list->where("address_type_id", "=", $address_type_id)->first();
                    if ($address) {
                        $address_array[] = "$address->address, $address->zipcode $address->city, $address->state, $address->country.";
                    } else {
                        $address_array[] = "";
                    }
                }

                return [
                    $user->id,
                    $user->email,
                    $user->first_name,
                    $user->last_name,
                    $user->birthdate,
                    $user->created_at,
                    $user->status,
                    ...$address_array,
                ];
            })
            ->toArray();

        return [$header, ...$data];
    }
}
