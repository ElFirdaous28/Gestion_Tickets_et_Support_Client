<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full border-collapse border border-gray-700">
                        <thead>
                            <tr class="bg-gray-700 text-white">
                                <th class="border border-gray-600 px-4 py-2">Title</th>
                                <th class="border border-gray-600 px-4 py-2">Status</th>
                                <th class="border border-gray-600 px-4 py-2">Category</th>
                                <th class="border border-gray-600 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr class="border border-gray-600">
                                <td class="border border-gray-600 px-4 py-2">
                                    <a href="" class="text-blue-400 hover:underline">
                                        {{ $ticket->title }}
                                    </a>
                                </td>
                                <td class="border border-gray-600 px-4 py-2">
                                    <span class="px-2 py-1 rounded-full text-white 
                                        {{ $ticket->status === 'pending' ? 'bg-yellow-500' : ($ticket->status === 'in_progress' ? 'bg-blue-500' : 'bg-green-500') }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td class="border border-gray-600 px-4 py-2">{{ $ticket->category->name }}</td>
                                <td class="border border-gray-600 px-4 py-2 flex gap-2">
                                    <!-- Send Message (Client & Agent) -->
                                    @if(auth()->user()->role === ('client') || auth()->user()->role === ('agent'))
                                    <a href="" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        💬 Send Message
                                    </a>
                                    @endif

                                    <!-- Delete (Client only) -->
                                    @if(auth()->user()->role === ('client'))
                                    <form action="" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            🗑 Delete
                                        </button>
                                    </form>
                                    @endif

                                    <!-- Assign (Admin only) -->
                                    @if(auth()->user()->role === ('admin'))
                                    <a href="" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        Assign
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>