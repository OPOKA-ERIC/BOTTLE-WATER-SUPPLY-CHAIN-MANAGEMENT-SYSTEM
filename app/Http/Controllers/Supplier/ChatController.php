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
        // Get all manufacturers
        $manufacturers = User::where('role', 'manufacturer')->get();
        
        // Get chat statistics for each manufacturer
        $manufacturersWithChats = $manufacturers->map(function($manufacturer) {
            $messages = Chat::where(function($query) use ($manufacturer) {
                $query->where('supplier_id', auth()->id())
                      ->where('manufacturer_id', $manufacturer->id);
            })->orWhere(function($query) use ($manufacturer) {
                $query->where('supplier_id', $manufacturer->id)
                      ->where('manufacturer_id', auth()->id());
            })->orderBy('created_at', 'desc')->get();
            
            $unreadCount = $messages->where('manufacturer_id', auth()->id())
                                   ->where('is_read', false)
                                   ->count();
            
            $recentMessage = $messages->first();
            
            return [
                'manufacturer' => $manufacturer,
                'unreadCount' => $unreadCount,
                'recentMessage' => $recentMessage,
                'totalMessages' => $messages->count()
            ];
        });
        
        return view('supplier.chats.index', [
            'manufacturersWithChats' => $manufacturersWithChats,
            'title' => 'Chat with Manufacturers - BWSCMS',
            'activePage' => 'chat',
            'navName' => 'Chat with Manufacturers'
        ]);
    }

    public function show($manufacturerId)
    {
        $manufacturer = User::where('role', 'manufacturer')->findOrFail($manufacturerId);
        
        // Get all messages between supplier and manufacturer
        $messages = Chat::where(function($query) use ($manufacturerId) {
                $query->where('supplier_id', auth()->id())
                      ->where('manufacturer_id', $manufacturerId);
            })
            ->orWhere(function($query) use ($manufacturerId) {
                $query->where('supplier_id', $manufacturerId)
                      ->where('manufacturer_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $messages->where('manufacturer_id', auth()->id())->each(function($message) {
            if (!$message->is_read) {
                $message->markAsRead();
            }
        });

        return view('supplier.chats.show', compact('manufacturer', 'messages'))
            ->with('title', 'Chat with ' . $manufacturer->name . ' - BWSCMS')
            ->with('activePage', 'chat')
            ->with('navName', 'Chat with ' . $manufacturer->name);
    }

    public function store(Request $request)
    {
        $request->validate([
            'manufacturer_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'type' => 'nullable|in:text,image,file',
            'file' => 'nullable|file|max:10240' // 10MB max
        ]);

        $chat = Chat::create([
            'manufacturer_id' => $request->manufacturer_id,
            'supplier_id' => auth()->id(),
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

    public function getMessages($manufacturerId)
    {
        $messages = Chat::where(function($query) use ($manufacturerId) {
                $query->where('supplier_id', auth()->id())
                      ->where('manufacturer_id', $manufacturerId);
            })
            ->orWhere(function($query) use ($manufacturerId) {
                $query->where('supplier_id', $manufacturerId)
                      ->where('manufacturer_id', auth()->id());
            })
            ->with(['manufacturer', 'supplier'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $messages->where('manufacturer_id', auth()->id())->each(function($message) {
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
        $chat = Chat::where('supplier_id', auth()->id())
            ->findOrFail($id);

        $chat->markAsRead();

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $unreadCount = Chat::where('supplier_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount
        ]);
    }
} 