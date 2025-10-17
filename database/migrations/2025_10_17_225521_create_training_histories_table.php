<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_histories', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('slug')->unique();
            $table->string('biodata_id', 18)->index()->nullable();
            $table->foreignId('type_id');
            $table->foreignId('register_id');
            $table->foreignId('cluster_id')->nullable();

            $table->text('decree_number')->nullable()->index();
            $table->date('decree_date')->nullable()->index();
            $table->unsignedInteger('decree_year')->nullable()->index();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedInteger('number_of_hours')->default(0);
            $table->text('organizer')->nullable();

            $table->jsonb('meta')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('training_histories');
    }
};
