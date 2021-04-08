<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('teamid')->default(999999999);
            $table->unsignedInteger('importedbyid')->default(999999999);
            $table->string('importedbyname',50);
            $table->timestamps();
            $table->string('filenameorig',200);
            $table->string('filenamenew',200);
            $table->decimal('linesinfile',12,0)->default(0);
            $table->decimal('linesimported',12,0)->default(0);
            $table->string('validateresult',20);
            $table->string('importresult',20);
            $table->string('validatenotes',4000)->default('');
            $table->string('importnotes',4000)->default('');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imports');
    }
}
