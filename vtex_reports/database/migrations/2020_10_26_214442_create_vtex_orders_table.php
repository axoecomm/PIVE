<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVtexOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vtex_orders', function (Blueprint $table) {
            $table->id();

            $table->string('hostname');
            $table->string('orderId');
            $table->string('sequence');
            $table->dateTime('creationDate');
            $table->string('clientName');
            $table->decimal('totalValue');
            $table->string('paymentNames');
            $table->string('status');
            $table->string('statusDescription');
            $table->integer('totalItems');

            $table->string('items')->nullable();
            $table->string('marketPlaceOrderId')->nullable();
            $table->string('salesChannel');
            $table->string('affiliateId')->nullable();
            $table->string('origin');
            $table->string('workflowInErrorState');
            $table->string('workflowInRetry');

            $table->string('lastMessageUnread');
            $table->dateTime('ShippingEstimatedDate')->nullable();
            $table->dateTime('ShippingEstimatedDateMax')->nullable();
            $table->dateTime('ShippingEstimatedDateMin')->nullable();
            $table->string('orderIsComplete');

            $table->string('listId')->nullable();
            $table->string('listType')->nullable();
            $table->dateTime('authorizedDate')->nullable();
            $table->string('callCenterOperatorName')->nullable();
            $table->string('currencyCode');
            $table->string('invoiceOutput')->nullable();
            $table->string('invoiceInput')->nullable();

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
        Schema::dropIfExists('vtex_orders');
    }
}
