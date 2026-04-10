<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">Product List</h2>
                            <p class="text-sm text-gray-400 mt-1">Manage your product inventory</p>
                        </div>
                        
                        {{-- Tombol Add Product Hanya untuk Admin --}}
                        @can('manage-product')
                        <a href="{{ route('product.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm">
                            Add Product
                        </a>
                        @endcan
                    </div>

                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase">#</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase">Price</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase">Owner</th>
                                    <th class="px-6 py-3 text-center font-semibold text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 font-medium">{{ $product->title }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->stock }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">{{ $product->user->name ?? 'No Owner' }}</td>

                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- Semua user bisa melihat detail --}}
                                                <a href="{{ route('product.show', $product->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View</a>

                                                {{-- Tombol Edit & Delete Hanya untuk Admin --}}
                                                @can('manage-product')
                                                    <span class="text-gray-300">|</span>
                                                    <a href="{{ route('product.edit', $product) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">Edit</a>
                                                    
                                                    <form action="{{ route('product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($products->hasPages())
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>