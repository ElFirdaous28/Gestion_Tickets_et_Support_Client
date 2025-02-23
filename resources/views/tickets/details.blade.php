<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col" x-data="{ showForm: false }">

                @if(session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Ticket Details -->
                <p class="text-gray-900 dark:text-white"><strong>Title:</strong> {{ $ticket->title }}</p>
                <p class="text-gray-900 dark:text-white"><strong>Description:</strong> {{ $ticket->description }}</p>
                <p class="text-gray-900 dark:text-white"><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
                <p class="text-gray-900 dark:text-white"><strong>Category:</strong> {{ $ticket->category->name }}</p>
                <p class="text-gray-900 dark:text-white"><strong>Assigned Agent:</strong> {{ $ticket->agent->name ?? '----' }}</p>

                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-4">Messages:</h3>
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($ticket->messages as $message)
                    <li class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white p-3 rounded-md mb-2 shadow-sm">
                        <div class="font-semibold">
                            <span>{{ $message->user->name }}</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">({{ $message->user->role }})</span>
                        </div>
                        <p><strong>{{ $message->created_at->format('Y-m-d H:i') }}:</strong></p>
                        <p class="mt-1">{{ $message->content }}</p>
                    </li>
                    @endforeach
                </ul>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center gap-4 mt-4">
                    @if(auth()->user()->id === $ticket->user_id || auth()->user()->role === 'agent')
                    <!-- Send Message Button -->
                    <button type="button" title="Send Message"
                        class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md flex items-center space-x-2"
                        @click="showForm = !showForm">
                        <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                        <span>Send Message</span>
                    </button>
                    @endif

                    @if($ticket->status !== 'closed' && (auth()->user()->role === 'admin' || auth()->user()->role === 'client'))
                    <form action="{{ route('tickets.close', $ticket->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to close this ticket?');">
                        @csrf
                        @method('POST')
                        <button type="submit" title="Close Ticket"
                            class="bg-red-600 text-white hover:bg-red-700 px-4 py-2 rounded-md flex items-center space-x-2">
                            <ion-icon name="close-circle-outline" class="text-xl"></ion-icon>
                            <span>Close</span>
                        </button>
                    </form>
                    @endif
                </div>

                <!-- Message Form (Initially Hidden) -->
                <div x-show="showForm" class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-md shadow-md">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Send a Message</h3>
                    <form action="{{ route('messages.store', $ticket->id) }}" method="POST" class="mt-2">
                        @csrf
                        <textarea name="content" class="w-full p-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white" rows="3" placeholder="Write your message..." required></textarea>
                        <button type="submit" class="mt-2 bg-green-600 text-white hover:bg-green-700 px-4 py-2 rounded-md">
                            Send
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>