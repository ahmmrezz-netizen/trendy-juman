<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $clients = $query->paginate(10);
        
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(ClientRequest $request)
    {
        Client::create($request->validated());
        
        return redirect()->route('admin.clients.index')
            ->with('success', 'Client created successfully!');
    }

    public function show(Client $client)
    {
        $client->load('purchases.product');
        return view('admin.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        
        return redirect()->route('admin.clients.index')
            ->with('success', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        
        return redirect()->route('admin.clients.index')
            ->with('success', 'Client deleted successfully!');
    }
}
