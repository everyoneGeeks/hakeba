<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutionCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('execution_cases', function (Blueprint $table) {
            $table->id();


            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('defendant_name');
            $table->string('defendant_address');
            $table->string('civil');
            $table->string('defendant_status');

            $table->string('iban_bank');
            $table->string('start_authorization_date');
            $table->string('end_authorization_date');
            $table->string('order_number');
            $table->string('court_name');
            $table->string('circle');
            $table->string('executive_number');
            $table->string('executive_type');

            $table->string('accept_date');
            $table->string('accept_reminder_date');
            $table->string('43_date');
            $table->string('43_reminder_date');

            $table->string('46_date');
            $table->string('46_reminder_date');

            $table->string('81_date');
            $table->string('81_reminder_date');

            $table->string('pay_date');
            $table->string('pay_reminder_date');

            $table->string('capture_date');
            $table->string('capture_reminder_date');

            $table->string('review_capture_date');
            $table->string('review_capture_reminder_date');

            $table->string('id_card_file'); // بطاقة الاحوال
            $table->string('authorization_file'); // الوكالة الشرعية
            $table->string('executive_file'); // الملف التنفيذي
            $table->string('commercial_register_file'); // السجل التجاري




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
        Schema::dropIfExists('execution_cases');
    }
}
