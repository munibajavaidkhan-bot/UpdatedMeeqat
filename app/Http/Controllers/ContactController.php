<?php
namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller {

    public function index() {
        return view('contact');
    }

    public function send(Request $request) {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|min:10',
        ]);

        ContactMessage::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Message sent successfully! We will reply soon.');
    }
}