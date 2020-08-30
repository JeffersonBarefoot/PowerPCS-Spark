<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('company',10)->default('SAMPLE');
            $table->string('active',1)->default('A');
            $table->string('group1',30)->default('');
            $table->string('group2',30)->default('');
            $table->string('sortorder',10)->default('');
            $table->string('descr',75)->default('');
            $table->string('notes',250)->default('');
            $table->binary('sqlselect');
        });

        DB::table('reports')->insert([
          ['active' => 'A'
          ,'group1' => 'POS'
          ,'group2'=>'1'
          ,'sortorder'=>'1'
          ,'descr'=>'Position Listing'
          ,'notes'=>'Summary listing of positions'
          ,'sqlselect'=>'Select Posno,company'
          ],
        ]);

        DB::table('reports')->insert([
          ['active' => 'A'
          ,'group1' => 'INC'
          ,'group2'=>'1'
          ,'sortorder'=>'1'
          ,'descr'=>'Incumbent Listing'
          ,'notes'=>'Summary listing of incumbents'
          ,'sqlselect'=>'Select Empno,company'
          ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
