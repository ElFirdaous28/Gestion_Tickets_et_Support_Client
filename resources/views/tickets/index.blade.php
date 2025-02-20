<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <!-- Wrap everything in a single Alpine component -->
    <div x-data="{ open: false, currentTicket: null }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <table class="w-full border-collapse border border-gray-700">
                            <thead>
                                <tr class="bg-gray-700 dark:text-white">
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
                                        <a href="" class="dark:text-white hover:underline">
                                            {{ $ticket->title }}
                                        </a>
                                    </td>
                                    <td class="border border-gray-600 px-4 py-2">
                                        <span class="px-2 py-1 rounded-full dark:text-white 
                                            {{ $ticket->status === 'pending' ? 'bg-yellow-500' : ($ticket->status === 'in_progress' ? 'bg-blue-500' : 'bg-green-500') }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-600 px-4 py-2">{{ $ticket->category->name }}</td>
                                    <td class="border border-gray-600 px-4 py-2 flex gap-2 justify-evenly">
                                        <!-- Send Message (Client & Agent) -->
                                        @if(auth()->user()->role === ('client') || auth()->user()->role === ('agent'))
                                        <a href="" class="bg-blue-500 dark:text-white px-3 py-1 rounded hover:bg-blue-600">
                                            Send Message
                                        </a>
                                        @endif

                                        @if(auth()->user()->role === ('agent'))
                                        <form action="" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="bg-green-500 dark:text-white px-3 py-1 rounded hover:bg-green-600">
                                                Resolu
                                            </button>
                                        </form>
                                        @endif

                                        <!-- Delete (Client only) -->
                                        @if(auth()->user()->role === ('client'))
                                        <form action="{{ route('ticket.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="bg-yellow-500 dark:text-white px-3 py-1 rounded hover:bg-yellow-600">
                                                Edit
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 dark:text-white px-3 py-1 rounded hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                        @endif

                                        <!-- Assign (Admin only) -->
                                        @if(auth()->user()->role === 'admin')
                                        <button @click="if (!{{ $ticket->assigned_to ? 'true' : 'false' }}) { open = true; currentTicket = {{ $ticket->id }} }"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 @if($ticket->assigned_to) cursor-not-allowed @endif"
                                            @if($ticket->assigned_to) disabled @endif>
                                            {{ $ticket->assigned_to ? 'Assigned' : 'Assign' }}
                                        </button>
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

        <!-- Modal (list of agents) - Now within the same Alpine component -->
        <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96" @click.outside="open = false">
                <h2 class="text-xl mb-4 dark:text-white font-semibold">Assign Ticket #<span x-text="currentTicket"></span></h2>

                <form action="{{ route('tickets.assign', $ticket->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="agent">
                            Select Agent
                        </label>
                        <select name="agent_id" id="agent" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 
                                dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none 
                                focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="">-- Select an agent --</option>
                            @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="button" @click="open = false"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Assign Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>