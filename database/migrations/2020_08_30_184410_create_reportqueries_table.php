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
          $table->unsignedbiginteger('reportid');
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
        ,'descr'=>'Company Code'
        ,'table' => 'positions'
        ,'field'=>'company'
        ,'datatype' => 'STRING'
        ,'options' => ''
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid' => '1'
        ,'sortorder'=>'2'
        ,'descr'=>'Position #'
        ,'table' => 'positions'
        ,'field'=>'posno'
        ,'datatype' => 'STRING'
        ,'options' => ''
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid' => '1'
        ,'sortorder'=>'3'
        ,'descr'=>'Position Active Status'
        ,'table' => 'positions'
        ,'field'=>'active'
        ,'datatype' => 'STRING'
        ,'options' => 'A;I;'
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid' => '1'
        ,'sortorder'=>'4'
        ,'descr'=>'Position Filled Status'
        ,'table' => 'positions'
        ,'field'=>'curstatus'
        ,'datatype' => 'STRING'
        ,'options' => 'V(acant); P(artially Filled); F(illed); O(verfilled)'
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid' => '1'
        ,'sortorder'=>'5'
        ,'descr'=>'Position Start Date'
        ,'table' => 'positions'
        ,'field'=>'startdate'
        ,'datatype' => 'DATE'
        ,'options' => ''
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid' => '2'
        ,'sortorder'=>'1'
        ,'descr'=>'Company Code'
        ,'table' => 'positions'
        ,'field'=>'company'
        ,'datatype' => 'STRING'
        ,'options' => ''
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid' => '2'
        ,'sortorder'=>'2'
        ,'descr'=>'Position #'
        ,'table' => 'positions'
        ,'field'=>'posno'
        ,'datatype' => 'STRING'
        ,'options' => ''
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid' => '2'
        ,'sortorder'=>'3'
        ,'descr'=>'Position Active Status'
        ,'table' => 'positions'
        ,'field'=>'active'
        ,'datatype' => 'STRING'
        ,'options' => 'A;I;'
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid' => '2'
        ,'sortorder'=>'4'
        ,'descr'=>'Position Filled Status'
        ,'table' => 'positions'
        ,'field'=>'curstatus'
        ,'datatype' => 'STRING'
        ,'options' => 'V(acant); P(artially Filled); F(illed); O(verfilled)'
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid' => '2'
        ,'sortorder'=>'5'
        ,'descr'=>'Position Start Date'
        ,'table' => 'positions'
        ,'field'=>'startdate'
        ,'datatype' => 'DATE'
        ,'options' => ''
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
