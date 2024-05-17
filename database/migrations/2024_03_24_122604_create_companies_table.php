<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('industry')->nullable();
            $table->enum('company_size', ['маленькая', 'средняя', 'большая']);
            $table->string('logo')->nullable();
            $table->string('city');
            $table->enum('company_type', ['организация', 'проект', 'частное лицо', 'самозанятый', 'частный рекрутер', 'кадровое агентство']);
            $table->string('email')->unique();
            $table->string('password');
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
        Schema::dropIfExists('companies');
    }
}
