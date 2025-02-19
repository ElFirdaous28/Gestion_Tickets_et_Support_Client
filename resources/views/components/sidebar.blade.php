<aside class="w-64 h-screen bg-gray-900 text-white fixed">
    <div class="p-4 text-xl font-bold">
         TicketManager
    </div>
    <nav class="mt-4">
        <ul>
            <!-- Dashboard -->
            <li class="mb-2">
                <a href="" class="flex items-center px-4 py-2 hover:bg-gray-700">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7m-9 9V4m0 14h4m-4 0H7m12 0h2M5 21h14"></path>
                    </svg>
                    Dashboard
                </a>
            </li>

            <!-- Tickets -->
            <li class="mb-2">
                <a href="" class="flex items-center px-4 py-2 hover:bg-gray-700">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"></path>
                    </svg>
                    Mes Tickets
                </a>
            </li>

            @if(auth()->user()->role === 'admin')
            <!-- Gestion des Tickets (Admin) -->
            <li class="mb-2">
                <a href="" class="flex items-center px-4 py-2 hover:bg-gray-700">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 10h11M9 21V3m6 10h6"></path>
                    </svg>
                    Gérer les Tickets
                </a>
            </li>

            <!-- Catégories -->
            <li class="mb-2">
                <a href="" class="flex items-center px-4 py-2 hover:bg-gray-700">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 10h11M9 21V3m6 10h6"></path>
                    </svg>
                    Catégories
                </a>
            </li>
            @endif

            <!-- Déconnexion -->
            <li class="mt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 hover:bg-red-600">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 12H3m12 0l4-4m-4 4l4 4M3 3h18"></path>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>