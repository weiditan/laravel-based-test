<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = ["model_id", "model_type", "collection_name", "disk", "file_path", "file_name"];

    protected static function booted()
    {
        static::deleting(function (Document $document) {
            Storage::disk($document->disk)->delete($document->file_path);
        });
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::disk($this->getAttributeValue("disk"))->url($this->getAttributeValue("file_path")),
        )->shouldCache();
    }
}
