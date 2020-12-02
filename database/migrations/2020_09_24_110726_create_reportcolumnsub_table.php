<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportcolumnsubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportcolumnsubs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedbiginteger('reportid');
            $table->decimal('columnorder',5,0)->default(10);
            $table->string('field',30);
            $table->string('header',100);
            $table->string('sortable',1)->default('Y');
            $table->decimal('sortorder',3,0)->default(0);
            $table->decimal('grouporder',3,0)->default(0);
            $table->string('subtotal',1)->default('N');
            $table->string('total',1)->default('N');
            $table->string('count',1)->default('N');
            $table->string('hidden',1)->default('N');
        });

        DB::table('reportcolumnsubs')->insert([['reportid'=>'1','columnorder'=>'10','field'=>'company','header'=>'Company'],]);
        DB::table('reportcolumnsubs')->insert([['reportid'=>'1','columnorder'=>'20','field'=>'level1','header'=>'Location'],]);
        DB::table('reportcolumnsubs')->insert([['reportid'=>'1','columnorder'=>'30','field'=>'level2','header'=>'Department'],]);
        DB::table('reportcolumnsubs')->insert([['reportid'=>'1','columnorder'=>'40','field'=>'count','header'=>'Count'],]);
        DB::table('reportcolumnsubs')->insert([['reportid'=>'1','columnorder'=>'50','field'=>'sumbudgsal','header'=>'Budgeted Salary'],]);

        DB::table('reportcolumnsubs')->insert([['reportid'=>'2','columnorder'=>'10','field'=>'company','header'=>'Company'],]);
        DB::table('reportcolumnsubs')->insert([['reportid'=>'2','columnorder'=>'20','field'=>'posno','header'=>'Pos #'],]);
        DB::table('reportcolumnsubs')->insert([['reportid'=>'2','columnorder'=>'30','field'=>'descr','header'=>'Pos Name'],]);
        DB::table('reportcolumnsubs')->insert([['reportid'=>'2','columnorder'=>'40','field'=>'Level1','header'=>'Department'],]);
        DB::table('reportcolumnsubs')->insert([['reportid'=>'2','columnorder'=>'50','field'=>'curstatus','header'=>'Status'],]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportcolumnsubs');
    }
}
