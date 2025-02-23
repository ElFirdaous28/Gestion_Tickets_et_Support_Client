<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div x-data="{ open: false, currentTicket: null }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        @if(session('success'))
                        <div class=" text-green-500 p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                        @endif
                        <table class="w-full border-collapse border border-gray-700">
                            <thead>
                                <tr class="bg-gray-700 dark:text-white">
                                    <th class="border border-gray-600 px-4 py-2">Title</th>
                                    <th class="border border-gray-600 px-4 py-2">Client</th>
                                    <th class="border border-gray-600 px-4 py-2">Agent</th>
                                    <th class="border border-gray-600 px-4 py-2">Status</th>
                                    <th class="border border-gray-600 px-4 py-2">Category</th>
                                    <th class="border border-gray-600 px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                <tr class="border border-gray-600">
                                    <td class="border border-gray-600 px-4 py-2">
                                        <a href="{{ route('ticket.details',$ticket->id) }}" class="dark:text-white hover:underline">
                                            {{ $ticket->title }}
                                        </a>
                                    </td>
                                    <td class="border border-gray-600 px-4 py-2">{{ $ticket->user->name ?? '----' }}</td>
                                    <td class="border border-gray-600 px-4 py-2">{{ $ticket->agent->name ?? '----' }}</td>

                                    <td class="border-gray-600 px-4 py-2 flex justify-center">
                                        <span class="px-2 rounded-full border-2 min-w-24 text-center {{ $ticket->status === 'pending' ? 'border-red-500 text-red-500' : ($ticket->status === 'in_progress' ? 'border-yellow-500 text-yellow-500' : ($ticket->status === 'resolved' ? 'border-green-500 text-green-500':'border-blue-500 text-blue-500')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-600 px-4 py-2">{{ $ticket->category->name }}</td>
                                    <td class="border-gray-600 flex gap-2 justify-center">
                                        @if(auth()->user()->role === 'agent')
                                        <form action="{{ route('tickets.changeStatus', ['ticket' => $ticket->id, 'newStatus' => 'resolved']) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this ticket as resolved?');">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" title="Resolve Ticket">
                                                <ion-icon name="checkmark-circle-outline" class="text-xl text-green-500"></ion-icon>
                                            </button>
                                        </form>
                                        @endif

                                        @if(auth()->user()->role === 'client')
                                        <a href="{{ route('tickets.edit', $ticket->id) }}" title="Edit Ticket"
                                            class="{{ $ticket->status === 'closed' ? 'cursor-not-allowed' : '' }}"
                                            @disabled($ticket->status === 'closed')>
                                            <ion-icon name="create-outline" class="text-xl text-yellow-500"></ion-icon>
                                        </a>

                                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Ticket">
                                                <ion-icon name="trash-outline" class="text-xl text-red-500"></ion-icon>
                                            </button>
                                        </form>
                                        @endif

                                        @if(auth()->user()->role === 'admin')
                                        <button type="button" @click="open = true; currentTicket = {{ $ticket->id }}"
                                            class="{{ $ticket->assigned_to ? 'cursor-not-allowed' : '' }}"
                                            @disabled($ticket->assigned_to) title="Assign Ticket">
                                            <ion-icon name="person-add-outline" class="text-xl text-yellow-500"></ion-icon>
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

        @if(auth()->user()->role === 'admin')
        <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96" @click.outside="open = false">
                <h2 class="text-xl mb-4 dark:text-white font-semibold">Assign Ticket #<span x-text="currentTicket"></span></h2>
                <form action="{{ route('tickets.assign', $ticket->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="agent">Select Agent</label>
                        <select name="agent_id" id="agent" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="">-- Select an agent --</option>
                            @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-between mt-6">
                        <button type="button" @click="open = false" class="bg-gray-500 dark:text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
                        <button type="submit" class="bg-blue-500 dark:text-white px-4 py-2 rounded hover:bg-blue-600">Assign Ticket</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>