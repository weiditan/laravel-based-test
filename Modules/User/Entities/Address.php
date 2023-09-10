<?php

namespace Modules\User\Entities;

use App\Traits\HasDocument;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Database\factories\AddressFactory;

class Address extends Model
{
    use HasFactory, HasDocument;

    protected $fillable = ["user_id", "address_type_id", "address", "zipcode", "city", "state", "country"];

    public function address_type(): BelongsTo
    {
        return $this->belongsTo(AddressType::class);
    }

    protected static function newFactory(): Factory
    {
        return AddressFactory::new();
    }
}
