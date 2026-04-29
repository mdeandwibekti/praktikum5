<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('user')
                            ->latest()
                            ->paginate(10);

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'name')
                     ->orderBy('name')
                     ->get();

        return view('product.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        try {
            Product::create($validated);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.');
        } catch (QueryException $e) {
            Log::error('Product store database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while creating product.');
        } catch (\Throwable $e) {
            Log::error('Product store unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unexpected error occurred.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('user')->findOrFail($id);
        return view('product.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ubah pencarian menggunakan ID manual agar terhindar dari error Route Binding
        $product = Product::findOrFail($id);
        $users = User::select('id', 'name')
                     ->orderBy('name')
                     ->get();

        return view('product.edit', compact('product', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Validasi disesuaikan dengan kolom database (title dan stock)
        $validated = $request->validate([
            'title'    => 'sometimes|string|max:255',
            'stock'    => 'sometimes|integer',
            'price'    => 'sometimes|numeric',
            'user_id'  => 'sometimes|exists:users,id',
        ]);

        $product->update($validated);

        return redirect()
            ->route('product.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('success', 'Product berhasil dihapus');
    }

    /**
     * View only untuk user biasa (opsional)
     */
    public function viewOnly()
    {
        $products = Product::with('user')
                            ->latest()
                            ->paginate(10);

        return view('product.view-only', compact('products'));
    }
}