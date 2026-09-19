<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller {

    public function index() {
        $messages = ContactMessage::latest()->paginate(15);
        $unread   = ContactMessage::where('is_read', false)->count();
        return view('admin.messages.index', compact('messages', 'unread'));
    }

    public function show($id) {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);
        return view('admin.messages.show', compact('message'));
    }

    public function destroy($id) {
        ContactMessage::findOrFail($id)->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted!');
    }
}