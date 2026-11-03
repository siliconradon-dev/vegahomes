<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:190'],
        ]);

        NewsletterSubscriber::firstOrCreate(['email' => strtolower($data['email'])]);

        return back()->with('status', 'Thanks for subscribing!');
    }
}
