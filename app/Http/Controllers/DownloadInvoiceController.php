<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class DownloadInvoiceController extends Controller
{
    use AuthorizesRequests;

    public function __invoke(Invoice $invoice)
    {
        // Authorize the user to view the invoice
        $this->authorize('view', $invoice);

        // Get user settings
        $settings = Auth::user()->settings;

        // Return the view directly for browser printing
        return view('invoices.pdf', compact('invoice', 'settings'));
    }
}
