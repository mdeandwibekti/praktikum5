<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryApiController extends Controller
{
    // GET semua kategori
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'message' => 'List category',
            'data' => $categories
        ], 200);
    }

    // POST tambah kategori
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

    // PUT update kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:categories,name,$id"
        ]);

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category tidak ditemukan'
            ], 404);
        }

        $category->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Category berhasil diupdate',
            'data' => $category
        ]);
    }

    // DELETE kategori
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category tidak ditemukan'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category berhasil dihapus'
        ], 200);
    }
}