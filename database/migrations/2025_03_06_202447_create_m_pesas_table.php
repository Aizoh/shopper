<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_pesas', function (Blueprint $table) {
            
            $table->increments('id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('reference')->nullable();
            $table->decimal('amount', 10,2);
            $table->integer('user_id')->default(0);
            $table->integer('cons_id')->nullable();
            $table->string('status')->nullable();
            $table->string('MerchantRequestID')->nullable();
            $table->string('CheckoutRequestID')->nullable();
            $table->string('PhoneNumber')->nullable();
            $table->string('MpesaReceiptNumber')->nullable();
            $table->integer('ResultCode')->nullable();
            $table->string('ResultDesc')->nullable();
            $table->string('CustomerMessage')->nullable();
            $table->string('description')->nullable();
            $table->date('TransactionDate')->nullable(); // Making grace_date nullable
            // $table->text('description')->nullable(); // Making description nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_pesas');
    }
};
