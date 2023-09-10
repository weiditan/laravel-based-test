<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\User\Entities\Document;

trait HasDocument
{
    public function document_list(): MorphMany
    {
        return $this->morphMany(Document::class, "model");
    }

    public function getDocument(string $collection_name = "default"): Collection
    {
        return $this->document_list->where("collection_name", "=", $collection_name)->values();
    }

    public function getFirstDocument(string $collection_name = "default"): ?object
    {
        return $this->getDocument($collection_name)->first();
    }

    public function addDocument(
        UploadedFile $file,
        string $collection_name = "default",
        bool $single_file = false,
    ): void {
        $disk = "document";
        $file_name = $collection_name . "_" . time() . "." . $file->extension();
        $file_path = "$this->table/{$this->{$this->primaryKey}}/$file_name";

        Storage::disk($disk)->put($file_path, $file->getContent());

        if ($single_file) {
            $old_document_list = $this->document_list->where("collection_name", "=", $collection_name);

            if ($old_document_list->isNotEmpty()) {
                foreach ($old_document_list as $old_document) {
                    $old_document->delete();
                }
            }
        }

        $this->document_list()->create([
            "collection_name" => $collection_name,
            "disk" => $disk,
            "file_path" => $file_path,
            "file_name" => $file_name,
        ]);
    }
}
