<?php

namespace Modules\User\Entities;

use App\Traits\HasDocument;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasDocument;

    protected $fillable = ["email", "password", "first_name", "last_name", "birthdate"];
    protected $hidden = ["password"];
}
