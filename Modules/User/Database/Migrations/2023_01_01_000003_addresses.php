<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    const table = "addresses";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(self::table, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("address_type_id");
            $table->string("address");
            $table->string("zipcode");
            $table->string("city");
            $table->string("state");
            $table->string("country");
            $table->timestamps();

            // Relations
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users");
            $table
                ->foreign("address_type_id")
                ->references("id")
                ->on("address_types");
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
