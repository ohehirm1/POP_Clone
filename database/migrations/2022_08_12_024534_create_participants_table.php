<?php

use App\Models\User;
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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('ndis', 11);
            $table->smallInteger('auth_role');
            $table->string('email');
            $table->string('email1')->nullable();
            $table->string('email2')->nullable();
            $table->foreignIdFor(User::class, 'created_by');
            $table->dateTime('verified_at')->nullable();
            $table->string('xero_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
};
