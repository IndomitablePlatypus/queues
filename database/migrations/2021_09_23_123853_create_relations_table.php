<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            $table->uuid('relation_id')->primary();
            $table->uuid('collaborator_id')->index();
            $table->uuid('workspace_id')->index();

            $table->string('relation_type')->index();

            $table->dateTime('established_at')->nullable()->index();

            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->index();

            $table->index(['collaborator_id', 'workspace_id']);
            $table->unique(['collaborator_id', 'workspace_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relations');
    }
}
