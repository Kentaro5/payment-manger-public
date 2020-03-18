<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('billing_plan_id');
            $table->string('title');
            $table->string('payment_type');
            $table->string('payment_state');
            $table->longText('desc');
            $table->string('type');
            $table->string('frequency_interval');
            $table->string('frequency');
            $table->string('cycles');
            $table->string('payment_amount');
            $table->string('payment_currency');
            $table->string('cancel_url');
            $table->string('return_url');
            $table->string('max_fail_attempts');
            $table->string('initial_fail_amount_action');
            $table->string('auto_bill_amount');
            $table->string('custom_fields')->nullable();
            $table->timestamp('created_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal_plans');
    }
}
