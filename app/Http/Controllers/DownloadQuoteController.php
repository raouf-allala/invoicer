<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class DownloadQuoteController extends Controller
{
    use AuthorizesRequests;

    public function __invoke(Quote $quote)
    {
        // Authorize the user to view the quote
        // $this->authorize('view', $quote); // TODO: Implement Policy

        // Get user settings
        $settings = Auth::user()->settings;

        // Return the view directly for browser printing
        return view('quotes.pdf', compact('quote', 'settings'));
    }
}
