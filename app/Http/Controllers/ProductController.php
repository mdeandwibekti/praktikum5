<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        // Gunakan paginate agar tidak error di View
        $products = Product::with('user')->paginate(10);
        return view('product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price'    => 'required|numeric',
        ]);

        // Simpan dengan mencocokkan kolom database: title dan stock
        Product::create([
            'title'       => $validated['name'],
            'stock'       => $validated['quantity'],
            'price'       => $validated['price'],
            'description' => $request->description ?? '-',
            'user_id'     => auth()->id(), // Simpan ID user agar Owner tidak kosong
        ]);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function create()
    {
        $users = User::orderBy('name')->get();

        return view('product.create', compact('users'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('product.view', compact('product'));
    }

    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validated = $request->validate([   
        'name'     => 'sometimes|string|max:255',
        'quantity' => 'sometimes|integer',
        'price'    => 'sometimes|numeric',
        'user_id'  => 'sometimes|exists:users,id',
    ]);

    // Mapping manual agar data tersimpan ke kolom yang benar
    $product->update([
        'title'   => $validated['name'] ?? $product->title,
        'stock'   => $validated['quantity'] ?? $product->stock,
        'price'   => $validated['price'] ?? $product->price,
        'user_id' => $validated['user_id'] ?? $product->user_id,
    ]);

    return redirect()->route('product.index')->with('success', 'Product updated successfully.');
}

    public function edit(Product $product)
    {
        Gate::authorize('update', $product); // Cek Policy update
        
        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        
        Gate::authorize('delete', $product); // Cek Policy delete
        
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}