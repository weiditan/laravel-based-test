<?php

namespace Modules\User\Entities;

use App\Traits\HasDocument;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Database\factories\UserFactory;
use Spatie\ModelStatus\HasStatuses;

class User extends Model
{
    use SoftDeletes, HasStatuses, HasFactory, HasDocument;

    protected $fillable = ["email", "password", "first_name", "last_name", "birthdate"];
    protected $hidden = ["password"];

    public static array $user_status_color_class_list = [
        "pending" => "text-warning",
        "approved" => "text-success",
        "rejected" => "text-danger",
        "terminated" => "text-muted",
    ];

    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    public function address_list(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getAttributeValue("first_name") . " " . $this->getAttributeValue("last_name"),
        )->shouldCache();
    }
}
