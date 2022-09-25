<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('defendant_name');
            $table->string('defendant_address');
            $table->string('civil');
            $table->string('defendant_status');

            $table->bigInteger('case_type')->unsigned();
            $table->foreign('case_type')->references('id')->on('case_types')->onDelete('cascade');


            $table->string('case_date');
            $table->string('session_date');
            $table->string('file_office_number');
            $table->string('file_court_number');
            $table->string('registration_number');
            $table->string('circle_case');

            $table->string('id_card_file');
            $table->string('commercial_register_file');
            $table->string('establishment_contract_file');
            $table->string('case_document_file');
            $table->string('note_file');
            $table->string('adjust_session_file');
            $table->string('start_authorization_date');
            $table->string('end_authorization_date');


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
        Schema::dropIfExists('cases');
    }
}
