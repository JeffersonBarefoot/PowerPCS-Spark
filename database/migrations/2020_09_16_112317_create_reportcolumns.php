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
        $table->decimal('columnorder',5,0)
        $table->string('field',30);
        $table->string('header',100);
        $table->string('sortable',1)->default('Y');
        $table->decimal('sortorder',3,0);
        $table->string('subtotal',1)->default('N');
        $table->string('total',1)->default('N');
        $table->string('count',1)->default('N');
        $table->string('hidden',1)->default('N');
      });

      DB::table('reportqueries')->insert([
        ['reportid'=>'1'
        ,'columnorder'=>'10'
        ,'field'=>'company'
        ,'header'=>'Company'
        ,'sortorder'=>'1'
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid'=>'1'
        ,'columnorder'=>'20'
        ,'field'=>'posno'
        ,'header'=>'Pos #'
        ,'sortorder'=>'9'
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid'=>'1'
        ,'columnorder'=>'30'
        ,'field'=>'descr'
        ,'header'=>'Pos Name'
        ,'sortorder'=>''
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid'=>'1'
        ,'columnorder'=>'40'
        ,'field'=>'Level1'
        ,'header'=>'Department'
        ,'sortorder'=>'2'
        ],
      ]);

      DB::table('reportqueries')->insert([
        ['reportid'=>'1'
        ,'columnorder'=>'50'
        ,'field'=>'curstatus'
        ,'header'=>'Status'
        ,'sortorder'=>''
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
        Schema::dropIfExists('reportcolumns');
    }
}
