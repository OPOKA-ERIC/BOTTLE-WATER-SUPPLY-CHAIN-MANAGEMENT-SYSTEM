<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
    {
        // Get all suppliers
        $suppliers = User::where('role', 'supplier')->get();
        
        // Get chat statistics for each supplier
        $suppliersWithChats = $suppliers->map(function($supplier) {
            $messages = Chat::where(function($query) use ($supplier) {
                $query->where('manufacturer_id', auth()->id())
                      ->where('supplier_id', $supplier->id);
            })->orWhere(function($query) use ($supplier) {
                $query->where('manufacturer_id', $supplier->id)
                      ->where('supplier_id', auth()->id());
            })->orderBy('created_at', 'desc')->get();
            
            $unreadCount = $messages->where('supplier_id', auth()->id())
                                   ->where('is_read', false)
                                   ->count();
            
            $recentMessage = $messages->first();
            
            return [
                'supplier' => $supplier,
                'unreadCount' => $unreadCount,
                'recentMessage' => $recentMessage,
                'totalMessages' => $messages->count()
            ];
        });
        
        return view('manufacturer.chats.index', [
            'suppliersWithChats' => $suppliersWithChats,
            'title' => 'Chat with Suppliers - BWSCMS',
            'activePage' => 'chat',
            'activeButton' => 'manufacturer',
            'navName' => 'Chat with Suppliers'
        ]);
    }

    public function show($supplierId)
    {
        $supplier = User::where('role', 'supplier')->findOrFail($supplierId);
        
        // Get all messages between manufacturer and supplier
        $messages = Chat::where(function($query) use ($supplierId) {
                $query->where('manufacturer_id', auth()->id())
                      ->where('supplier_id', $supplierId);
            })
            ->orWhere(function($query) use ($supplierId) {
                $query->where('manufacturer_id', $supplierId)
                      ->where('supplier_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $messages->where('supplier_id', auth()->id())->each(function($message) {
            if (!$message->is_read) {
                $message->markAsRead();
            }
        });

        return view('manufacturer.chats.show', compact('supplier', 'messages'))
            ->with('title', 'Chat with ' . $supplier->name . ' - BWSCMS')
            ->with('activePage', 'chat')
            ->with('activeButton', 'manufacturer')
            ->with('navName', 'Chat with ' . $supplier->name);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'type' => 'nullable|in:text,image,file',
            'file' => 'nullable|file|max:10240' // 10MB max
        ]);

        $chat = Chat::create([
            'manufacturer_id' => auth()->id(),
            'supplier_id' => $request->supplier_id,
            'message' => $request->message,
            'type' => $request->type ?? 'text',
            'file_path' => $request->hasFile('file') ? $request->file('file')->store('chats') : null
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $chat->load(['manufacturer', 'supplier'])
            ]);
        }

        return redirect()->back()->with('success', 'Message sent successfully');
    }

    public function getMessages($supplierId)
    {
        $messages = Chat::where(function($query) use ($supplierId) {
                $query->where('manufacturer_id', auth()->id())
                      ->where('supplier_id', $supplierId);
            })
            ->orWhere(function($query) use ($supplierId) {
                $query->where('manufacturer_id', $supplierId)
                      ->where('supplier_id', auth()->id());
            })
            ->with(['manufacturer', 'supplier'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $messages->where('supplier_id', auth()->id())->each(function($message) {
            if (!$message->is_read) {
                $message->markAsRead();
            }
        });

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    public function markAsRead($id)
    {
        $chat = Chat::where('manufacturer_id', auth()->id())
            ->findOrFail($id);

        $chat->markAsRead();

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $unreadCount = Chat::where('manufacturer_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount
        ]);
    }
} 