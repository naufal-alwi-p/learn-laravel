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
        /*
            To create a new database table, use the create method on the Schema facade. The create method accepts two arguments: the first
            is the name of the table, while the second is a closure which receives a Blueprint object that may be used to define the new table

            When creating the table, you may use any of the schema builder's column methods to define the table's columns.

            The schema builder blueprint offers a variety of methods that correspond to the different types of columns you can add to your
            database tables.
        */
        Schema::create('percobaan_buat', function(Blueprint $table) {
            // If you would like to add a "comment" to a database table, you may invoke the comment method on the table instance. Table
            // comments are currently only supported by MySQL and Postgres
            $table->comment('Percobaan Membuat Migration Table Laravel');
            // The bigIncrements method creates an auto-incrementing UNSIGNED BIGINT (primary key) equivalent column
            $table->bigIncrements('list');
            // The string method creates a VARCHAR equivalent column of the given length
            $table->string('nama', 100);
            // The bigInteger method creates a BIGINT equivalent column
            $table->bigInteger('uang', unsigned: true);
            // The boolean method creates a BOOLEAN equivalent column
            $table->boolean('status');
            // The char method creates a CHAR equivalent column with of a given length
            $table->char('npm', 9)->nullable();
            // The decimal method creates a DECIMAL equivalent column with the given precision (total digits) and scale (decimal digits)
            $table->decimal('ipk', 3, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('percobaan_buat');
    }
};
