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
        Schema::create('college_schedules', function (Blueprint $table) {
            $table->char('kode', 9)->primary();
            $table->string('mata_kuliah', 100);
            $table->integer('sks', unsigned:true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('college_schedules');
    }
};
