<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('sms_logs',function(Blueprint $table){
            $table->id();
            $table->string('to');
            $table->text('message');
            $table->string('status')->nullable();
            $table->string('statusmsg')->nullable();
            $table->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('sms_logs'); }
};
