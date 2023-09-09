<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Modules\User\Entities\Document;

trait HasDocument
{
    public function document(): MorphMany
    {
        return $this->morphMany(Document::class, "model");
    }

    public function getDocument(string $collection_name = "default"): Collection
    {
        return $this->document->where("collection_name", "=", $collection_name)->values();
    }

    public function getFirstDocument(string $collection_name = "default"): ?object
    {
        return $this->getDocument($collection_name)->first();
    }

    public function addDocument(File $file, string $collection_name = "default", bool $single_file = false): void
    {
        Storage::disk();
    }
}
