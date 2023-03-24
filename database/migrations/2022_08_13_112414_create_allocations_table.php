<?php

use App\Models\Business;
use App\Models\Participant;
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
        Schema::create('allocations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Business::class);
            $table->foreignIdFor(Participant::class);
            $table->string('support_item');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('price_charged');
            $table->integer('allocated_amount');
            $table->integer('advance_amount')->default(1000_00);
            $table->dateTime('verified_at')->nullable();
            $table->dateTime('participant_verified_at')->nullable();
            $table->foreignIdFor(User::class, 'created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allocations');
    }
};
