<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('publications', function (Blueprint $table) {
            // Ensure the collection_id column allows null values if a publication might not have a collection
            $table->unsignedBigInteger('collection_id')->nullable()->after('id');
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropForeign(['collection_id']);
            $table->dropColumn('collection_id');
        });
    }
};
