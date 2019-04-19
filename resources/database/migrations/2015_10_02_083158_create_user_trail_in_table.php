<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTrailInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('password')->nullable()->change();
            $table->string('username')->nullable()->after('id');
            $table->integer('isAdmin')->nullable()->default(0)->after('status');
            $table->timestamp('lastlogin')->nullable()->after('isAdmin');
            $table->text('photo')->nullable()->after('lastlogin');
            $table->unique('username');
        });

        Schema::create('user_trails', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('person')->nullable();
            $table->integer('type')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_trails');
    }
}
