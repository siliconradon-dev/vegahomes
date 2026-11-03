<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index', [
            'messages' => ContactMessage::latest()->paginate(15),
        ]);
    }

    public function toggle(ContactMessage $message)
    {
        $message->update(['is_read' => !$message->is_read]);

        return back();
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return back()->with('status', 'Message deleted.');
    }
}
