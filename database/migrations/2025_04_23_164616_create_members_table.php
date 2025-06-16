<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('merchant');
            $table->string('player_id')->nullable();
            $table->string('username')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('member_name')->nullable();
            $table->string('member_group')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('referral')->nullable();
            $table->text('currency')->nullable(); // You might consider normalizing this
            $table->string('kyc_status')->nullable();
            $table->string('status')->nullable();
            $table->date('register_from')->nullable();
            $table->date('register_to')->nullable();
            $table->string('affiliate_code')->nullable();
            $table->string('affiliate_username')->nullable();
            $table->string('risk')->nullable();
            $table->text('vip_level')->nullable(); // Similar normalization as currency
            $table->date('last_login_from')->nullable();
            $table->date('last_login_to')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('referral_site')->nullable();
            $table->string('email')->nullable();
            $table->string('member_tag')->nullable();
            $table->string('referral_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
}
