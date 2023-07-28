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
        //
        Schema::create('data_diri', function(Blueprint $table) {
            $table->comment('Table yang berisi data diri');
            // The id method is an alias of the bigIncrements method. By default, the method will create an id column;
            // however, you may pass a column name if you would like to assign a different name to the column
            $table->id();
            $table->string('nama', 100);
            // The date method creates a DATE equivalent column
            $table->date('tanggal_lahir');
            // The year method creates a YEAR equivalent column
            $table->year('tahun_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('data_diri');
    }
};
