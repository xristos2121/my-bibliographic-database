<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFullTextIndexToDocumentsTable extends Migration
{
    public function up()
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->fullText('pdf_text');
        });
    }

    public function down()
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropFullText(['pdf_text']);
        });
    }
}
