<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcposithTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hpositions', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedInteger('teamid')->default(999999999);
          $table->unsignedInteger('posid')->default(999999999);
          $table->timestamps();
           $table->string('company',10)->default('SAMPLE');
           $table->string('posno',20)->default('');
           $table->string('descr',75)->default('Sample Position');
           $table->string('active',1)->default('A');
           $table->decimal('annftehour',10,3)->default(2080);
           $table->date('avail_date',)->default('2999-12-31');
           $table->decimal('budgsal',12,2)->default(0);
           $table->string('eeoclass',20)->default('');
           $table->date('enddate',)->default('2999-12-31');
           $table->string('exempt',1)->default('');
           $table->string('ftefreq',15)->default('W');
           $table->decimal('ftehours',13,5)->default(40);
           $table->decimal('fulltimeequiv',8,5)->default(1);
           $table->string('funded',1)->default('');
           $table->string('group1',30)->default('');
           $table->string('group2',30)->default('');
           $table->string('group3',30)->default('');
           $table->string('jobcode',20)->default('');
           $table->string('jobdesc',50)->default('');
           $table->date('lastactdate',)->default('2999-12-31');
           $table->date('last_fil',)->default('2999-12-31');
           $table->date('last_ove',)->default('2999-12-31');
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
           $table->string('reptocomp',10)->default('');
           $table->string('reptodesc',75)->default('');
           $table->string('reptoposno',20)->default('');
           $table->string('salgrade',20)->default('');
           $table->decimal('salupper',12,2)->default(0);
           $table->decimal('sallower',12,2)->default(0);
           $table->string('salfreq',1)->default('');
           $table->string('curstatus',20)->default('');
           $table->date('startdate',)->default('2999-12-31');
           $table->string('supcompany',10)->default('');
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
           $table->string('reptocom2',10)->default('');
           $table->string('reptopos2',20)->default('');
           $table->string('reptodesc2',75)->default('');
           $table->string('historyreason',4000)->default('');
           $table->date('historystart');
           $table->date('historyend');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pcposith');
        Schema::dropIfExists('hpositions');
    }
}
