<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header --}}
                    <div class="flex items-center gap-3 mb-6">
                        <a href="{{ route('product.index') }}"
                           class="p-1.5 rounded-md text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            ←
                        </a>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                Add Product
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Fill in the details to add a new product
                            </p>
                        </div>
                    </div>

                    {{-- Munculkan error database jika ada --}}
                    @if(session('error'))
                        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('product.store') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Update: Name -> Title --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                   placeholder="e.g. Wireless Headphones"
                                   class="w-full px-4 py-2.5 rounded-lg border text-sm
                                   @error('title') border-red-400 bg-red-50 dark:bg-red-900/20 @else border-gray-300 dark:border-gray-600 @enderror
                                   bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('title')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Update: Quantity -> Stock --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Stock <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="stock" value="{{ old('stock') }}" min="0"
                                       class="w-full px-4 py-2.5 rounded-lg border text-sm
                                       @error('stock') border-red-400 bg-red-50 dark:bg-red-900/20 @else border-gray-300 dark:border-gray-600 @enderror
                                       bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                       focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                @error('stock')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Price (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="price" value="{{ old('price') }}" step="0.01"
                                       class="w-full px-4 py-2.5 rounded-lg border text-sm
                                       @error('price') border-red-400 bg-red-50 dark:bg-red-900/20 @else border-gray-300 dark:border-gray-600 @enderror
                                       bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                       focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                @error('price')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- User --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Owner <span class="text-red-500">*</span>
                            </label>
                            <select name="user_id"
                                    class="w-full px-4 py-2.5 rounded-lg border text-sm
                                    @error('user_id') border-red-400 bg-red-50 dark:bg-red-900/20 @else border-gray-300 dark:border-gray-600 @enderror
                                    bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                    focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Select Owner</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('product.index') }}"
                               class="px-4 py-2.5 rounded-lg border text-sm text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                                Save Product
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>