<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class AddressType extends Model
{
    protected $fillable = ["name", "is_active"];

    protected $casts = ["is_active" => "boolean"];
}
