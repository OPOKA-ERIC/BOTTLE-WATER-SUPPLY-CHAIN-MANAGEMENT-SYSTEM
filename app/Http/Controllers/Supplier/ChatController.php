<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::where('supplier_id', auth()->id())
            ->with('manufacturer')
            ->latest()
            ->paginate(10);

        return view('supplier.chats.index', compact('chats'));
    }

    public function show($id)
    {
        $chat = Chat::where('supplier_id', auth()->id())
            ->with('manufacturer')
            ->findOrFail($id);

        // Mark as read
        if (!$chat->is_read) {
            $chat->update(['is_read' => true]);
        }

        return view('supplier.chats.show', compact('chat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'manufacturer_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'type' => 'required|in:text,image,file',
            'file' => 'nullable|file|max:10240' // 10MB max
        ]);

        $chat = Chat::create([
            'manufacturer_id' => $request->manufacturer_id,
            'supplier_id' => auth()->id(),
            'message' => $request->message,
            'type' => $request->type,
            'file_path' => $request->hasFile('file') ? $request->file('file')->store('chats') : null
        ]);

        return redirect()->back()->with('success', 'Message sent successfully');
    }

    public function markAsRead($id)
    {
        $chat = Chat::where('supplier_id', auth()->id())
            ->findOrFail($id);

        $chat->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
} 