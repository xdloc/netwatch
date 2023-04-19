<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspects_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suspect_id');
            $table->integer('customer_code')->comment('Colvir Customer Code e.g. 300000000');
            $table->string('legal_entity_name')->nullable()->comment('Legal Entity Name e.g. ИП Илон Маск');
            $table->string('tax_code')->nullable()->comment('Tax Code (ИНН) 10-12 digits e.g. 4000000000');
            $table->integer('account')->nullable()->unique()->comment('Account Number e.g. 47400000000000000000');
            $table->string('bank_code')->nullable()->comment('Bank Code (БИК) e.g. 044525999');
            $table->string('bank_name')->nullable()->comment('Bank Name e.g. Филиал Точка Банка ФК Открытие');
            $table->integer('correspondent_account')->nullable()->comment('Correspondent Account e.g. 40800000000000000000');
            $table->string('website_url')->nullable()->comment('Website URL e.g. https://tochka.com');
            $table->string('website_credentials_url')->nullable()->comment('Website URL e.g. https://tochka.com/credentials');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suspects_history');
    }
};
