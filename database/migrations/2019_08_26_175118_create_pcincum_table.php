<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcincumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incumbents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('teamid')->default(999999999);
            $table->unsignedInteger('posid')->default(999999999);
            $table->timestamps();
            $table->string('poscompany',10)->default('SAMPLE');
            $table->string('posno',20)->default('');
            $table->string('company',10)->default('SAMPLE');
            $table->string('empno',9)->default('');
            $table->string('fname',30)->default('');
            $table->string('mi',30)->default('');
            $table->string('lname',30)->default('');
            $table->decimal('annual',12,5)->default(0);
            $table->decimal('salary',12,5)->default(0);
            $table->decimal('unitrate',12,5)->default(0);
            $table->decimal('normunit',12,5)->default(0);
            $table->string('payfreq',1)->default('');
            $table->date('posstart',)->default('2999-12-31');
            $table->date('posstop',)->default('2999-12-31');
            $table->decimal('fulltimeequiv',10,5)->default(0);
            $table->string('active',1)->default('A');
            $table->decimal('lsalary',12,5)->default(0);
            $table->date('nextpay',)->default('2999-12-31');
            $table->decimal('nextincr',7,3)->default(0);
            $table->date('lasthire',)->default('2999-12-31');
            $table->string('active_pos',1)->default('A');
            $table->date('trans_date',)->default('2999-12-31');
            $table->string('reason',10)->default('');
            $table->string('userdef1',50)->default('');
            $table->string('userdef2',50)->default('');
            $table->string('userdef3',50)->default('');
            $table->string('userdef4',50)->default('');
            $table->decimal('ann_cost',12,2)->default(0);
            $table->string('userdef5',50)->default('');
            $table->string('userdef6',50)->default('');
            $table->string('level1',20)->default('');
            $table->string('level2',20)->default('');
            $table->string('level3',20)->default('');
            $table->string('level4',20)->default('');
            $table->string('level5',20)->default('');
            $table->date('lastact',)->default('2999-12-31');
            $table->string('hrmsreas',8)->default('');
            $table->date('hrmsdate',)->default('2999-12-31');
            $table->string('jobcode',15)->default('');
            $table->string('jobtitle',30)->default('a');
            $table->string('race',20)->default('');
            $table->string('sex',10)->default('');
            $table->string('education',30)->default('');
        });

        DB::table('incumbents')->insert([
          ['posno'=>'10275', 'poscompany'=>'SAMPLE', 'posid'=>'1', 'empno'=>'10321', 'company'=>'SAMPLE', 'lname'=>'Bandana'],
          ['posno'=>'10275', 'poscompany'=>'SAMPLE', 'posid'=>'1', 'empno'=>'10322', 'company'=>'SAMPLE', 'lname'=>'Daniels'],
          ['posno'=>'10275', 'poscompany'=>'SAMPLE', 'posid'=>'1', 'empno'=>'10323', 'company'=>'SAMPLE', 'lname'=>'Smith'],
          ['posno'=>'10275', 'poscompany'=>'SAMPLE', 'posid'=>'1', 'empno'=>'10324', 'company'=>'SAMPLE', 'lname'=>'Jones'],
        ]);

        Schema::table('incumbents', function (Blueprint $table) {
            $table->index(['poscompany']);
        });

        Schema::table('incumbents', function (Blueprint $table) {
            $table->index(['posno']);
        });

        Schema::table('incumbents', function (Blueprint $table) {
            $table->index(['company']);
        });

        Schema::table('incumbents', function (Blueprint $table) {
            $table->index(['empno']);
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incumbents');
    }
}
