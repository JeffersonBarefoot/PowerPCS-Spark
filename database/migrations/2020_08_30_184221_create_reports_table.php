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
            $table->unsignedbiginteger('reportid');
            $table->string('company',10)->default('SAMPLE');
            $table->string('active',1)->default('A');
            $table->string('group1',30)->default('');
            $table->string('group2',30)->default('');
            $table->string('sortorder',10)->default('');
            $table->string('descr',75)->default('');
            $table->string('notes',250)->default('');
            $table->binary('sqlselect');
        });

        //Position Reports
        DB::table('reports')->insert([['active' => 'A','group1' => 'POS','group2'=>'1','ReportID'=>'1000','sortorder'=>'1000','descr'=>'Position Listing','notes'=>'Positions by Vacant, Partially Filled, Filled, Overfilled','sqlselect'=>'Select Posno,company'],]);
        DB::table('reports')->insert([['active' => 'A','group1' => 'POS','group2'=>'1','ReportID'=>'1010','sortorder'=>'1010','descr'=>'Position Reports To','notes'=>'','sqlselect'=>'Select Posno,company'],]);
        DB::table('reports')->insert([['active' => 'A','group1' => 'POS','group2'=>'1','ReportID'=>'1020','sortorder'=>'1020','descr'=>'Position Direct Reports','notes'=>'Summary Listing of Incumbents','sqlselect'=>'Select Posno,company'],]);
        DB::table('reports')->insert([['active' => 'A','group1' => 'POS','group2'=>'1','ReportID'=>'1030','sortorder'=>'1030','descr'=>'Positions by Filled Status','notes'=>'','sqlselect'=>'Select Posno,company'],]);

        //Position History Reports


        //Incumbent Reports
        DB::table('reports')->insert([['active' => 'A','group1' => 'INC','group2'=>'1','ReportID'=>'3000','sortorder'=>'3000','descr'=>'Incumbent Listing','notes'=>'','sqlselect'=>'Select Posno,company'],]);

        //Incumbent History Reports


        //Budget Reports
        DB::table('reports')->insert([['active' => 'A','group1' => 'BUDG','group2'=>'1','ReportID'=>'5000','sortorder'=>'5000','descr'=>'Budget Listing','notes'=>'','sqlselect'=>'Select Posno,company'],]);

        //Vacancy Reports


        // Recruiting Reports








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
