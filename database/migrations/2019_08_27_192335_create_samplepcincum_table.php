<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplepcincumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samplepcincum', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->boolean('sample');
            $table->string('empno',9);
            $table->string('fname',30);
            $table->string('mi',30);
            $table->string('lname',30);
            $table->string('posno',20);
            $table->decimal('annual',12,5);
            $table->decimal('salary',12,5);
            $table->decimal('unitrate',12,5);
            $table->decimal('normunit',12,5);
            $table->string('payfreq',1);
            $table->string('company',3);
            $table->date('posstart',);
            $table->date('posstop',);
            $table->decimal('fulltimeequiv',10,5);
            $table->string('active',1);
            $table->decimal('lsalary',12,5);
            $table->date('nextpay',);
            $table->decimal('nextincr',7,3);
            $table->string('jobtitle',30);
            $table->date('lasthire',);
            $table->string('active_pos',1);
            $table->date('trans_date',);
            $table->string('reason',10);
            $table->string('userdef1',50);
            $table->string('userdef2',50);
            $table->string('userdef3',50);
            $table->string('userdef4',50);
            $table->decimal('ann_cost',12,2);
            $table->string('userdef5',50);
            $table->string('userdef6',50);
            $table->string('level1',20);
            $table->string('level2',20);
            $table->string('level3',20);
            $table->string('level4',20);
            $table->string('level5',20);
            $table->date('lastact',);
            $table->string('hrmsreas',8);
            $table->date('hrmsdate',);
            $table->string('jobcode',15);
            $table->string('poscompany',3);
            $table->string('race',20);
            $table->string('sex',10);
            $table->string('education',30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('samplepcincum');
    }
}
