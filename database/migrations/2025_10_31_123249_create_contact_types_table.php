<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactTypesTable extends Migration
{
    public function up()
    {
        Schema::create('contact_types', function (Blueprint $table) {
            $table->id();
            $table->string('type', 150)->index();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_types');
    }
}
