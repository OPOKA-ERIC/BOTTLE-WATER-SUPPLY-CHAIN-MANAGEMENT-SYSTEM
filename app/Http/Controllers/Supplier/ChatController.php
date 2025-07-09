<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
    {
        // Get all chats for the supplier, order by latest
        $chats = Chat::where('supplier_id', auth()->id())
            ->with(['manufacturer', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by recipient and get the latest message per conversation
        $conversations = $chats->groupBy(function($chat) {
            return $chat->manufacturer_id ? 'manufacturer_' . $chat->manufacturer_id : 'admin_' . $chat->admin_id;
        })->map(function($chats) {
            return $chats->sortByDesc('created_at')->first();
        })->sortByDesc('created_at')->take(10);

        // Get manufacturers and admins for the new chat modal
        $manufacturers = User::where('role', 'manufacturer')->get();
        $admins = User::where('role', 'administrator')->get();

        return view('supplier.chats.index', compact('conversations', 'manufacturers', 'admins'))
            ->with('title', 'Supplier Chats - BWSCMS')
            ->with('activePage', 'chat')
            ->with('navName', 'Chat Conversations');
    }

    public function show($id)
    {
        $chat = Chat::where('supplier_id', auth()->id())
            ->with(['manufacturer', 'admin'])
            ->findOrFail($id);

        // Get all messages in this conversation
        $conversationMessages = Chat::where('supplier_id', auth()->id())
            ->where(function($query) use ($chat) {
                if ($chat->manufacturer_id) {
                    $query->where('manufacturer_id', $chat->manufacturer_id);
                } else {
                    $query->where('admin_id', $chat->admin_id);
                }
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read
        if (!$chat->is_read) {
            $chat->update(['is_read' => true]);
        }

        return view('supplier.chats.show', compact('chat', 'conversationMessages'))
            ->with('title', 'Chat Details - BWSCMS')
            ->with('activePage', 'chat')
            ->with('navName', 'Chat Details');
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:manufacturer,admin',
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'type' => 'required|in:text,image,file',
            'file' => 'nullable|file|max:10240' // 10MB max
        ]);

        $data = [
            'supplier_id' => auth()->id(),
            'message' => $request->message,
            'type' => $request->type,
            'is_read' => false,
            'file_path' => $request->hasFile('file') ? $request->file('file')->store('chats') : null
        ];

        if ($request->recipient_type === 'manufacturer') {
            $data['manufacturer_id'] = $request->recipient_id;
        } else {
            $data['admin_id'] = $request->recipient_id;
        }

        Chat::create($data);

        return redirect()->back()->with('success', 'Message sent successfully');
    }

    public function markAsRead($id)
    {
        $chat = Chat::where('supplier_id', auth()->id())
            ->findOrFail($id);

        $chat->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function getConversation($recipientType, $recipientId)
    {
        $query = Chat::where('supplier_id', auth()->id());

        if ($recipientType === 'manufacturer') {
            $query->where('manufacturer_id', $recipientId);
        } else {
            $query->where('admin_id', $recipientId);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:manufacturer,admin',
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $data = [
            'supplier_id' => auth()->id(),
            'message' => $request->message,
            'type' => 'text',
            'is_read' => false,
        ];

        if ($request->recipient_type === 'manufacturer') {
            $data['manufacturer_id'] = $request->recipient_id;
        } else {
            $data['admin_id'] = $request->recipient_id;
        }

        $chat = Chat::create($data);

        return response()->json([
            'success' => true,
            'message' => $chat->load(['manufacturer', 'admin'])
        ]);
    }

    public function getAvailableRecipients()
    {
        $manufacturers = User::where('role', 'manufacturer')
            ->select('id', 'name', 'email')
            ->get();

        $admins = User::where('role', 'administrator')
            ->select('id', 'name', 'email')
            ->get();

        return response()->json([
            'manufacturers' => $manufacturers,
            'administrators' => $admins
        ]);
    }

    public function getUnreadCount()
    {
        $unreadCount = Chat::where('supplier_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }
}
