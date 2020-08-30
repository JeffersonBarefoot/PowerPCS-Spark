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
        });

        DB::table('reports')->insert([
          ['active' => 'A'
          ,'group1' => '1'
          ,'group2'=>'1'
          ,'sortorder'=>'1'
          ,'descr'=>'Position Listing'
          ,'notes'=>'Summary listing of positions'
          ],
        ]);

        DB::table('reports')->insert([
          ['active' => 'A'
          ,'group1' => '2'
          ,'group2'=>'1'
          ,'sortorder'=>'1'
          ,'descr'=>'Incumbent Listing'
          ,'notes'=>'Summary listing of incumbents'
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
