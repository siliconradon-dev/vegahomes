<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;

class SubscriberController extends Controller
{
    public function index()
    {
        return view('admin.subscribers.index', [
            'subscribers' => NewsletterSubscriber::latest()->paginate(25),
        ]);
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('status', 'Subscriber removed.');
    }
}
