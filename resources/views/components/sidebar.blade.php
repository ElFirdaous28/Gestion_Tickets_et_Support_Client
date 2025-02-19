<aside class="w-64 h-screen bg-gray-900 text-white fixed p-4">
    <div class="text-xl font-bold mb-6">
        TicketManager
    </div>
    <nav>
        <ul>
            <li>
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="home-outline" class="text-xl"></ion-icon><span>Dashboard</span>
                </a>
            </li>

            @if(auth()->user()->role === 'admin')
            <li>
                <a href="{{ url('/admin/tickets') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="ticket-outline" class="text-xl"></ion-icon><span>Manage Tickets</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/agents') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="person-add-outline" class="text-xl"></ion-icon><span>Manage Agents</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/users') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="people-outline" class="text-xl"></ion-icon><span>Manage Users</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/categories') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="albums-outline" class="text-xl"></ion-icon><span>Manage Categories</span>
                </a>
            </li>

            <li>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="settings-outline" class="text-xl"></ion-icon><span>Profile</span>
                </a>
            </li>

            @elseif(auth()->user()->role === 'agent')
            <li>
                <a href="{{ url('/agent/tickets') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="document-text-outline" class="text-xl"></ion-icon><span>Assigned Tickets</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/agent/messages') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="chatbubble-ellipses-outline" class="text-xl"></ion-icon><span>User Messages</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/agent/history') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="time-outline" class="text-xl"></ion-icon><span>Ticket History</span>
                </a>
            </li>

            @else
            <li>
                <a href="{{ url('/user/tickets/create') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="add-circle-outline" class="text-xl"></ion-icon><span>Create a Ticket</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/user/tickets') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="document-text-outline" class="text-xl"></ion-icon><span>My Tickets</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/agent/history') }}" class="flex items-center gap-4 py-4 px-4 rounded hover:bg-gray-700">
                    <ion-icon name="time-outline" class="text-xl"></ion-icon><span>Ticket History</span>
                </a>
            </li>
            @endif
        </ul>

        <!-- Déconnexion -->
        <ul class="mt-6">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-4 py-4 px-4 w-full rounded hover:bg-red-600">
                        <ion-icon name="log-out-outline" class="text-xl"></ion-icon> Déconnexion
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>