<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('positions', function (Blueprint $table) {
      $table->bigIncrements('id')->comment('Record ID');
      $table->unsignedInteger('teamid')->default(999999999)->comment('Team ID');
      $table->timestamps();
      $table->string('company',10)->default('SAMPLE')->comment('Employer Name');
      $table->string('posno',20)->default('')->comment('Position Number');
      $table->string('descr',75)->default('Sample Position')->comment('Description/name');
      $table->string('active',1)->default('A')->comment('Current Active Status');
       $table->decimal('annftehour',10,3)->default(2080)->comment('FTE Calc Annual Basis');
       $table->date('avail_date',)->default('2999-12-31')->comment('Position Available Date');
       $table->decimal('budgsal',12,2)->default(0)->comment('Budgeted Salary');
       $table->string('eeoclass',20)->default('')->comment('EEO Classification');
       $table->date('enddate',)->default('2999-12-31')->comment('Position Ending Date');
       $table->string('exempt',1)->default('')->comment('Exempt Status');
       $table->string('ftefreq',15)->default('W')->comment('FTE Calc Frequency');
       $table->decimal('ftehours',13,5)->default(40)->comment('FTE Calc Hours');
       $table->decimal('fulltimeequiv',8,5)->default(1)->comment('FTEs Calculated');
       $table->string('funded',1)->default('')->comment('Position Funded?');
       $table->string('group1',30)->default('');
       $table->string('group2',30)->default('');
       $table->string('group3',30)->default('');
       $table->string('jobcode',20)->default('');
       $table->string('jobdesc',50)->default('');
       $table->date('lastactdate',)->default('2999-12-31');
       $table->date('last_fil',)->default('2999-12-31');
       $table->date('last_fpl',)->default('2999-12-31');
       $table->date('last_par',)->default('2999-12-31');
       $table->date('last_vac',)->default('2999-12-31');
       $table->string('level1',20)->default('');
       $table->string('level2',20)->default('');
       $table->string('level3',20)->default('');
       $table->string('level4',20)->default('');
       $table->string('level5',20)->default('');
       $table->boolean('linktoabra',)->default(0);
       $table->boolean('multincumb',1)->default(0);
       $table->string('payfreq',12)->default('');
       $table->decimal('payrate',10,2)->default(0);
       $table->string('paytype',10)->default('');
       $table->string('reason',10)->default('');
       $table->string('reptocomp',3)->default('');
       $table->string('reptodesc',75)->default('');
       $table->string('reptoposno',20)->default('');
       $table->string('salgrade',20)->default('');
       $table->decimal('salupper',12,2)->default(0);
       $table->decimal('sallower',12,2)->default(0);
       $table->string('salfreq',1)->default('');
       $table->string('curstatus',20)->default('VACANT');
       $table->date('startdate',)->default('2999-12-31');
       $table->string('supcompany',3)->default('');
       $table->string('supempno',9)->default('');
       $table->string('supname',50)->default('');
       $table->date('trans_date',)->default('2999-12-31');
       $table->string('userdef1',50)->default('');
       $table->string('userdef2',50)->default('');
       $table->string('userdef3',50)->default('');
       $table->string('userdef4',50)->default('');
       $table->string('userdef5',50)->default('');
       $table->string('userdef6',50)->default('');
       $table->decimal('vac_times',10,0)->default(0);
       $table->decimal('vac_months',10,2)->default(0);
       $table->string('reptocom2',3)->default('');
       $table->string('reptopos2',20)->default('');
       $table->string('reptodesc2',75)->default('');
    });

    DB::table('positions')->insert([
      ['posno' => '10275','descr' => 'CEO','fulltimeequiv'=>'1','ftefreq'=>'B','ftehours'=>'80','annftehour'=>'2080','budgsal'=>'260000',
      'payrate'=>'10000','payfreq'=>'B','exempt'=>'Y','level1'=>'NY','level2'=>'ADMIN','multincumb'=>0,'curstatus'=>'FILLED'],
    ]);

    DB::table('positions')->insert([
      ['posno' => '10321','descr' => 'VP Operations','fulltimeequiv'=>'1','ftefreq'=>'B','ftehours'=>'80','annftehour'=>'2080','budgsal'=>'130000',
      'payrate'=>'5000','payfreq'=>'B','exempt'=>'Y','level1'=>'CHI','level2'=>'ADMIN','multincumb'=>0,'curstatus'=>'FILLED'],
    ]);

    DB::table('positions')->insert([
      ['posno' => '27116','descr' => 'VP Sales','fulltimeequiv'=>'1','ftefreq'=>'B','ftehours'=>'80','annftehour'=>'2080','budgsal'=>'150000',
      'payrate'=>'5769.23077','payfreq'=>'B','exempt'=>'Y','level1'=>'CHI','level2'=>'ADMIN','multincumb'=>0,'curstatus'=>'FILLED'],
    ]);


    DB::table('positions')->insert([
      ['posno' => '10321','descr' => 'VP Operations'],
      ['posno' => '27116','descr' => 'VP Sales'],
      ['posno' => '28451','descr' => 'Controller'],
      ['posno' => '85881','descr' => 'AP Clerk'],
      ['posno' => '13227','descr' => 'AR Clerk'],
      ['posno' => '17651','descr' => 'Inside Sales'],
      ['posno' => '44583','descr' => 'Inside Sales'],
      ['posno' => '25339','descr' => 'Outside Sales'],
      ['posno' => '12286','descr' => 'Warehouse Supervisor'],
      ['posno' => '62253','descr' => 'Receptionist'],
    ]);

}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
