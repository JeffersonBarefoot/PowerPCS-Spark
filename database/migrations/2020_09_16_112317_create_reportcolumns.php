<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportcolumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('reportcolumns', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->timestamps();
        $table->unsignedbiginteger('reportid');
        $table->decimal('columnorder',5,0)->default(10);
        $table->string('field',30);
        $table->string('header',100);
        $table->string('sortable',1)->default('Y');
        $table->decimal('sortorder',3,0)->default(0);
        $table->decimal('grouporder',3,0)->default(0);
        $table->string('format',10)->default('');
        $table->string('subtotal',1)->default('N');
        $table->string('total',1)->default('N');
        $table->string('count',1)->default('N');
        $table->string('hidden',1)->default('N');
      });

      // Position Reports
      DB::table('reportcolumns')->insert([['reportid'=>'1000','columnorder'=>'10','field'=>'company','header'=>'Company'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1000','columnorder'=>'20','field'=>'posno','header'=>'Pos #'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1000','columnorder'=>'30','field'=>'descr','header'=>'Position'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1000','columnorder'=>'40','field'=>'level1','header'=>'Department'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1000','columnorder'=>'50','field'=>'curstatus','header'=>'Status'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1000','columnorder'=>'60','field'=>'budgsal','format'=>'R$,2','header'=>'Budg Salary'],]);

      DB::table('reportcolumns')->insert([['reportid'=>'1010','columnorder'=>'10','field'=>'company','header'=>'Company'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1010','columnorder'=>'20','field'=>'posno','header'=>'Pos #'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1010','columnorder'=>'30','field'=>'descr','header'=>'Position'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1010','columnorder'=>'40','field'=>'level1','header'=>'Department'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1010','columnorder'=>'50','field'=>'curstatus','header'=>'Status'],]);

      DB::table('reportcolumns')->insert([['reportid'=>'1020','columnorder'=>'10','field'=>'company','header'=>'Company'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1020','columnorder'=>'20','field'=>'posno','header'=>'Pos #'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1020','columnorder'=>'30','field'=>'descr','header'=>'Position'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1020','columnorder'=>'40','field'=>'level1','header'=>'Department'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'1020','columnorder'=>'50','field'=>'curstatus','header'=>'Status'],]);

      // Incumbent Reports
      DB::table('reportcolumns')->insert([['reportid'=>'3000','columnorder'=>'10','field'=>'company','header'=>'Company'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'3000','columnorder'=>'20','field'=>'posno','header'=>'Pos #'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'3000','columnorder'=>'30','field'=>'lname','header'=>'Last Name'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'3000','columnorder'=>'40','field'=>'level1','header'=>'Department'],]);
      DB::table('reportcolumns')->insert([['reportid'=>'3000','columnorder'=>'50','field'=>'fname','header'=>'First Name'],]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportcolumns');
    }
}
