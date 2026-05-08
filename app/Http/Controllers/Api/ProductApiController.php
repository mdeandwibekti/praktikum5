<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductRequest;

class ProductApiController extends Controller
{
    // Method GET: Menampilkan semua produk
    public function index()
    {
        try {
            $products = Product::with('category')->get();
            return response()->json([
                'message' => 'Data produk berhasil diambil',
                'data' => $products
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Terjadi kesalahan pada server'], 500);
        }
    }

    // Method POST: Menyimpan data produk baru
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['user_id'] = Auth::id();

            $product = Product::create($validated);

            Log::info('Menambah data produk', [
                'list' => $product
            ]);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan!!',
                'data' => $product,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah product', [
                'message' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan pada server'], 500);
        }
    }

    // Method GET: Menampilkan data produk berdasarkan ID
    public function show(int $id)
    {
        try {
            $product = Product::with('category')->find($id);

            if (!$product)
            {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'data' => $product
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', [
                'message' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan pada server'], 500);
        }
    }

    // Method PUT: Mengubah data produk
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'category_id' => 'required|exists:categories,id'
            ]);

            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan'
                ], 404);
            }

            $product->update([
                'title' => $request->title,   // 🔥 PENTING
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category_id
            ]);

            return response()->json([
                'message' => 'Product berhasil diupdate',
                'data' => $product
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Method DELETE: Menghapus data produk
    public function destroy(int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product tidak ditemukan'], 404);
            }

            $product->delete();

            Log::info('Menghapus data produk', ['id' => $id]);

            return response()->json([
                'message' => 'Produk berhasil dihapus!'
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat menghapus produk', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Terjadi kesalahan pada server'], 500);
        }
    }
}