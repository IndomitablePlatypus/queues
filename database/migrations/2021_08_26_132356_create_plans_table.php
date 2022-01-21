<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->uuid('plan_id')->primary();
            $table->uuid('workspace_id')->index();

            $table->jsonb('profile')->nullable();

            $table->dateTime('added_at')->nullable()->index();
            $table->dateTime('launched_at')->nullable()->index();
            $table->dateTime('stopped_at')->nullable()->index();
            $table->dateTime('archived_at')->nullable()->index();
            $table->dateTime('expiration_date')->nullable()->index();

            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
