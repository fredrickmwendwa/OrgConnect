<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustryTypesTable extends Migration
{
    public function up()
    {
        Schema::create('industry_types', function (Blueprint $table) {
            $table->id();
            $table->string('type', 150);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('industry_types');
    }
}
