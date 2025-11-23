<?php

use App\Models\Customer;
use App\Models\Invoice;
use App\Enums\QuoteStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->foreignIdFor(Invoice::class, 'converted_to_invoice_id')->nullable()->constrained('invoices');
            $table->json('customer_details');
            $table->json('issuer_details');
            $table->string('quote_number')->unique();
            $table->date('quote_date');
            $table->date('due_date')->nullable(); // Validity date
            $table->json('items');
            $table->decimal('total', 10, 2);
            $table->text('remarks')->nullable();
            $table->string('status')->default(QuoteStatus::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
