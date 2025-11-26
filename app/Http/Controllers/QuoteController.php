<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceStatus;
use App\Enums\QuoteStatus;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quote;
use App\Models\Settings;
use App\Services\QuoteService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $filterStatus = $request->query('status', 'all');
        $sortBy = $request->query('sort', 'created_at');

        $customerIds = Auth::user()->customers()->pluck('id');

        $quotes = Quote::whereIn('customer_id', $customerIds)
            ->when($filterStatus !== 'all', fn ($q) => $q->where('status', $filterStatus))
            ->orderBy($sortBy, 'desc')
            ->with('customer')
            ->latest()
            ->simplePaginate(10)
            ->withQueryString();

        return view('quotes.index', compact('quotes'));
    }

    public function show(Quote $quote)
    {
        // $this->authorize('view', $quote); // TODO: Implement Policy
        $settings = Auth::user()->settings;

        return view('quotes.show', compact('quote', 'settings'));
    }

    public function create()
    {
        $settings = Auth::user()->settings;
        if (! $settings) {
            return redirect()
                ->route('settings.edit')
                ->with('alert', alertify('Let\'s set up your information first!', 'info'));
        }

        $customers = Auth::user()->customers;
        if ($customers->count() === 0) {
            return redirect()
                ->route('customers.create')
                ->with('alert', alertify('Add a customer and you can create quotes.', 'info'));
        }

        $quote_date = now()->format('Y-m-d');
        // Default validity 30 days?
        $due_date = now()->addDays(30)->format('Y-m-d');

        return view('quotes.create', compact('customers', 'quote_date', 'due_date'));
    }

    public function store(Request $request)
    {
        // Decode the items JSON string to an array
        $request->merge(['items' => json_decode($request->input('items'), true)]);

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quote_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:quote_date',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        $customerIds = Auth::user()->customers()->pluck('id')->toArray();

        if (! in_array($validated['customer_id'], $customerIds)) {
            return redirect()->back()->withErrors(['customer_id' => 'Invalid customer selected.']);
        }

        $customer = Customer::findOrFail($validated['customer_id']);
        $settings = Auth::user()->settings;

        if (! $settings) {
            abort(403, 'Settings not found');
        }

        $customerDetails = QuoteService::composeCustomerDetails($customer);
        $issuerDetails = QuoteService::composeIssuerDetails($settings);

        $quote = Quote::create([
            'customer_id' => $customer->id,
            'customer_details' => $customerDetails,
            'issuer_details' => $issuerDetails,
            'quote_number' => QuoteService::generateUniqueQuoteNumber(),
            'quote_date' => $validated['quote_date'],
            'due_date' => $validated['due_date'],
            'status' => QuoteStatus::PENDING,
            'items' => $request->input('items'),
        ]);

        return redirect()
            ->route('quotes.show', $quote->quote_number)
            ->with('alert', alertify('Quote created successfully!'));
    }

    public function edit(Quote $quote)
    {
        // $this->authorize('update', $quote);

        $settings = Auth::user()->settings;
        $customers = Auth::user()->customers;

        return view('quotes.edit', compact('quote', 'settings', 'customers'));
    }

    public function update(Request $request, Quote $quote)
    {
        // $this->authorize('update', $quote);

        $request->merge(['items' => json_decode($request->input('items'), true)]);

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quote_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:quote_date',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:65535',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);
        $customerDetails = QuoteService::composeCustomerDetails($customer);

        // Update issuer details to current settings? Or keep original?
        // Let's update to current settings as per InvoiceController logic
        $settings = Auth::user()->settings;
        $issuerDetails = QuoteService::composeIssuerDetails($settings);

        $quote->update([
            'customer_id' => $customer->id,
            'customer_details' => $customerDetails,
            'issuer_details' => $issuerDetails,
            'quote_date' => $validated['quote_date'],
            'due_date' => $validated['due_date'],
            'items' => $request->input('items'),
        ]);

        return redirect()
            ->route('quotes.show', $quote->quote_number)
            ->with('alert', alertify('Quote updated successfully!'));
    }

    public function convertToInvoice(Quote $quote)
    {
        // $this->authorize('update', $quote);

        if ($quote->status === QuoteStatus::CONVERTED) {
            return redirect()
                ->route('invoices.show', $quote->convertedInvoice->invoice_number)
                ->with('alert', alertify('This quote is already converted.', 'info'));
        }

        // Create Invoice from Quote
        $invoice = Invoice::create([
            'customer_id' => $quote->customer_id,
            'customer_details' => $quote->customer_details,
            'issuer_details' => $quote->issuer_details,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(30)->format('Y-m-d'), // Default due date
            'status' => InvoiceStatus::ISSUED,
            'items' => $quote->items,
            'total' => $quote->total,
        ]);

        // Update Quote status
        $quote->update([
            'status' => QuoteStatus::CONVERTED,
            'converted_to_invoice_id' => $invoice->id,
        ]);

        return redirect()
            ->route('invoices.show', $invoice->invoice_number)
            ->with('alert', alertify('Quote converted to Invoice successfully!'));
    }

    public function destroy(Quote $quote)
    {
        // $this->authorize('delete', $quote);
        $quote->delete();

        return redirect()->route('quotes.index')->with('alert', alertify('Quote deleted successfully!'));
    }
}
