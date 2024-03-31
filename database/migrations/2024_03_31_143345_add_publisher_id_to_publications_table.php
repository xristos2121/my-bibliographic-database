<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            if (!Schema::hasColumn('publications', 'publisher_id')) {
                $table->unsignedBigInteger('publisher_id')->nullable(); // or just unsignedBigInteger if it should not be nullable
            }

            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            //
        });
    }
};
