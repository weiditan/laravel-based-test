<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Address extends Model
{
    protected $fillable = ["user_id", "address_type_id", "address", "zipcode", "city", "state", "country"];

    public function address_proof_document_list(): MorphOne
    {
        return $this->morphOne(Document::class, "model")->where("type", "=", "address_proof_document");
    }
}
