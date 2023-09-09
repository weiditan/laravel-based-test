<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    const table = "documents";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(self::table, function (Blueprint $table) {
            $table->id();
            $table->string("model_type");
            $table->unsignedBigInteger("model_id");
            $table->string("collection_name");
            $table->string("disk");
            $table->string("file_name");
            $table->timestamps();

            $table->index(["model_type", "model_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(self::table);
    }
};
