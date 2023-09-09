<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = ["model_id", "model_type", "collection_name", "disk", "file_name"];

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::disk($this->getAttributeValue("disk"))->temporaryUrl(
                $this->getAttributeValue("file_name"),
                now()->addMinutes(15),
            ),
        )->shouldCache();
    }
}
