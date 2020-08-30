<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportqueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('reportqueries', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->timestamps();
          $table->string('reportid',20);
          $table->string('company',10)->default('SAMPLE');
          $table->string('active',1)->default('A');
          $table->string('sortorder',10)->default('');
          $table->string('descr',75)->default('');
          $table->string('table',75)->default('');
          $table->string('field',75)->default('');
          $table->string('datatype',10)->default('');
          $table->string('options',250)->default('');
      });

      DB::table('reportqueries')->insert([
        ['reportid' => '1'
        ,'sortorder'=>'1'
        ,'descr'=>'Position Number'
        ,'table' => 'positions'
        ,'field'=>'posno'
        ,'datatype' => 'STRING'
        ,'options' => ''
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid' => '1'
        ,'sortorder'=>'2'
        ,'descr'=>'Position Status'
        ,'table' => 'positions'
        ,'field'=>'active'
        ,'datatype' => 'STRING'
        ,'options' => 'A;I;'
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
        Schema::dropIfExists('reportqueries');
    }
}
