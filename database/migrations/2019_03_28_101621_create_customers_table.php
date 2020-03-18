<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('billing_plan_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->timestamp('registerd_date');
            $table->string('payment_state');
            $table->string('mailchimp_tag')->nullable();
            $table->string('member_state')->nullable();
            $table->unsignedInteger('admin_id');
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
        Schema::dropIfExists('customers');
    }
}
