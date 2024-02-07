<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->increments('PropertyID');
            $table->string('Domain');
            $table->string('metaregistrar_id');
            $table->foreign('OrganizationID')->references('OrganizationID')->on('organizations')->onDelete('cascade');
            $table->text('headers')->nullable();
            $table->tinyInteger('headers_last_update')->nullable();
            $table->text('sources')->nullable();
            $table->tinyInteger('sources_last_update')->nullable();
            $table->string('CMS')->nullable();
            $table->string('CMS_version')->nullable();
            $table->tinyInteger('CMS_last_update')->nullable();
            $table->text('SSL_contents')->nullable();
            $table->string('SSL_issuer')->nullable();
            $table->timestamp('SSL_valid_from')->nullable();
            $table->timestamp('SSL_valid_to')->nullable();
            $table->string('SSL_last_update')->nullable();
            $table->string('PHP_VERSION')->nullable();
            $table->tinyInteger('PHP_last_update')->nullable();
            $table->string('PHP_update_method')->nullable();
            $table->string('control_panel')->nullable();
            $table->unsignedInteger('OrganizationID');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('domains');
    }
}
