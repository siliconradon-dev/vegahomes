<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:190'],
            'phone'   => ['required', 'string', 'max:40'],
            'message' => ['nullable', 'string', 'max:3000'],
        ]);

        ContactMessage::create($data + ['ip' => $request->ip()]);

        // The template's AJAX handler (js/function.js) expects the literal text "success".
        if ($request->ajax() || $request->expectsJson()) {
            return response('success');
        }

        return back()->with('status', 'Thank you! Your message has been sent. We will contact you soon.');
    }
}
