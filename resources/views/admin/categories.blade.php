<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div x-data="{ showModal: false, mode: 'add', categoryId: null, categoryName: '' }" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Add Category Button -->
                <div class="flex justify-between items-center mb-4">
                    <button @click="showModal = true; mode = 'add'; categoryId = null; categoryName = ''"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        + Add Category
                    </button>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-4 p-3 text-green-800 bg-green-200 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Categories Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($categories as $category)
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                {{ $category->name }}
                            </h4>
                            <div class="flex justify-between mt-3">
                                <!-- Edit Button -->
                                <button @click="showModal = true; mode = 'edit'; categoryId = {{ $category->id }}; categoryName = '{{ $category->name }}'"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                    Edit
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($categories->isEmpty())
                    <p class="text-center text-gray-500 dark:text-gray-400 mt-4">No categories found.</p>
                @endif
            </div>
        </div>

        <!-- Modal -->
        <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4"
                    x-text="mode === 'add' ? 'Add Category' : 'Edit Category'"></h2>

                <form :action="mode === 'add' ? '{{ route('categories.store') }}' : '/categories/' + categoryId"
                    method="POST">
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <label for="category_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                    <input type="text" id="category_name" name="name" x-model="categoryName"
                        class="mt-1 p-2 w-full border rounded-md dark:bg-gray-700 dark:text-white" required>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <span x-text="mode === 'add' ? 'Add' : 'Update'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
