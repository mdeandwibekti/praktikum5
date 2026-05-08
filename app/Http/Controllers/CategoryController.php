<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Menghitung jumlah produk di setiap kategori
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Category berhasil ditambahkan',
            'data' => $category
        ], 201);
    }

    public function destroy($id)
{
    $category = Category::findOrFail($id);

    // Cek apakah kategori masih memiliki produk (opsional, untuk keamanan data)
    if ($category->products()->count() > 0) {
        return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
    }

    $category->delete();

    return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus.');
}
}