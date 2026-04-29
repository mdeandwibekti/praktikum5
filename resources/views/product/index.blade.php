<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8">

                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">Product List
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your product inventory</p>
                        </div>
                        @can('manage-products')
                            <x-add-product :url="route('product.create')" :name="'Product'"/>
                        @endcan
                    </div>

                    {{-- Flash Message --}}
                    <div class="max-w-md mb-6"> {{-- Ukuran dibatasi agar tidak kepanjangan --}}
                        @if (session('success'))
                            <div class="flex items-center p-4 text-sm rounded-lg border shadow-sm transition-all duration-300 
                                {{ session('success') == 'Product berhasil dihapus' 
                                    ? 'bg-red-50 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800' 
                                    : 'bg-green-50 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800' }}">
                                
                                {{-- Ikon --}}
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                </svg>
                                
                                <span class="font-bold">{{ session('success') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Table Card --}}
                    <div class="relative overflow-hidden shadow-inner rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200/50 dark:bg-gray-700 dark:text-gray-300 font-black">
                                <tr>
                                    <th class="px-6 py-4">#</th>
                                    <th class="px-6 py-4">Product Name</th>
                                    <th class="px-6 py-4">Stock Status</th>
                                    <th class="px-6 py-4">Price (IDR)</th>
                                    <th class="px-6 py-4">Created By</th>
                                    
                                    {{-- Kolom Action dengan Tombol Add Product --}}
                                    <th class="px-6 py-3 text-center">
                                        @can('manage-product')
                                            <a href="{{ route('product.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-md transition-all duration-200 active:scale-95 border border-indigo-500">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Add Product
                                            </a>
                                        @else
                                            <span class="tracking-widest">Actions</span>
                                        @endcan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($products as $product)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-400">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white text-base">
                                            {{ $product->title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($product->stock > 10)
                                                <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-xs font-black uppercase">
                                                    In Stock ({{ $product->stock }})
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-xs font-black uppercase">
                                                    Low Stock ({{ $product->stock }})
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-mono text-gray-700 dark:text-gray-300">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                            {{ $product->user->name ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-4">
                                                <a href="{{ route('product.show', $product->id) }}" class="font-bold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">View</a>
                                                
                                                @can('manage-product')
                                                    <a href="{{ route('product.edit', $product) }}" class="font-bold text-amber-500 hover:text-amber-700 dark:text-amber-400 transition-colors">Edit</a>
                                                    <form action="{{ route('product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="font-bold text-red-500 hover:text-red-700 dark:text-red-400 transition-colors">Delete</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-20 text-center text-gray-500 dark:text-gray-400 italic">
                                            Inventory is empty.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($products->hasPages())
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>