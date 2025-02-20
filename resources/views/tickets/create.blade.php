<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($ticket) ? __('Edit Ticket') : __('Create Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ isset($ticket) ? route('tickets.update', $ticket->id) : route('tickets.store') }}" method="POST">
                    @csrf
                    @if(isset($ticket))
                        @method('PUT')
                    @endif


                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 dark:text-gray-200">Title:</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $ticket->title ?? '') }}" required
                            class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 dark:text-gray-200">Description:</label>
                        <textarea id="description" name="description" required rows="4"
                            class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">{{ old('description', $ticket->description ?? '') }}</textarea>
                        @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 dark:text-gray-200">Category:</label>
                        <select id="category" name="category_id" required
                            class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                            <option value="">-----</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ isset($ticket) && $ticket->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>


                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        {{ isset($ticket) ? 'Update Ticket' : 'Create Ticket' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>