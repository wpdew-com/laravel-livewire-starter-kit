<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'My Website' }}</title>
    <meta name="description" content="{{ $description ?? 'My Website' }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

    <header class="bg-white shadow-md py-4 p-4">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <!-- Logo end home -->
            <h1 class="text-2xl font-bold">
                <a href="{{ route('home') }}" class="text-gray-900 hover:text-blue-600">My Website</a>
            </h1>

            <!-- Navigation menu -->
            <nav class="md:flex space-x-6">
                @if(isset($pages) && $pages->count())
                    @foreach ($pages as $page)
                        <a href="{{ route('page.show', ['slug' => $page->slug]) }}"
                           class="text-gray-700 py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                            {{ $page->title }}
                        </a>
                    @endforeach
                @endif
            </nav>

            <!-- Navigation menu without home page
            <nav class="md:flex space-x-6">
                @if(isset($pages) && $pages->count())
                    @foreach ($pages->where('slug', '!=', 'home') as $page)
                        <a href="{{ route('page.show', ['slug' => $page->slug]) }}"
                           class="text-gray-700 py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                            {{ $page->title }}
                        </a>
                    @endforeach
                @endif
            </nav>
            -->



            <!-- Authorization / User Dropdown Menu -->
            @if (Route::has('login'))
                <div class="relative">
                    @auth
                        <button id="user-menu-button" class="flex items-center space-x-2 text-gray-900 hover:text-blue-600 focus:outline-none">
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-md">
                            <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 text-gray-900 border border-gray-300 hover:border-gray-500 rounded-md">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-md">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- Burger Menu Button for Mobile -->
            <button id="mobile-menu-button" class="md:hidden px-3 py-2 rounded-lg text-gray-900 focus:outline-none">
                ☰
            </button>
        </div>

        <!-- Mobile menu -->
        <nav id="mobile-menu" class="hidden md:hidden bg-gray-100 p-4 absolute left-0 top-0 w-full z-50">
            @if(isset($pages) && $pages->count())
                @foreach ($pages as $page)
                    <a href="{{ route('page.show', ['slug' => $page->slug]) }}"
                       class="block text-gray-700 hover:text-blue-500 py-2">
                        {{ $page->title }}
                    </a>
                @endforeach
            @endif

            @if (Route::has('login'))
                <div class="mt-4 border-t pt-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="block px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md text-center">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="block w-full text-center px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="block px-4 py-2 text-gray-900 border border-gray-300 hover:border-gray-500 rounded-md text-center">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="block px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-md text-center">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </nav>

        <!-- JS for burger menu and user dropdown menu -->
        <script>
            // Open/Close User Dropdown Menu
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            if (userMenuButton) {
                userMenuButton.addEventListener('click', () => {
                    userMenu.classList.toggle('hidden');
                });
            }

            // Opening/closing the mobile menu
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        </script>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-6 flex-grow">
        {{ $slot }}
    </main>

    <!-- Fooer -->
    <footer class="bg-gray-200 text-center py-4 mt-auto">
        <p>© {{ date('Y') }} My Website</p>
    </footer>

    @livewireScripts <!-- Connecting Livewire Scripts -->
</body>
</html>
