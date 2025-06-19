<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-pastel-blue">
        <div class="min-h-screen bg-pastel-blue flex">
            <!-- Sidebar -->
            <div class="bg-green-700 w-64 shadow-md hidden sm:block">
                <div class="p-4 border-b border-green-800">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                        <span class="ml-3 text-xl font-semibold text-white">UC Registrar</span>
                    </a>
                </div>
                <nav class="mt-5 px-2">
                    <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-600 hover:text-white' }}">
                        <svg class="mr-3 h-6 w-6 {{ request()->routeIs('dashboard') ? 'text-green-300' : 'text-green-200 group-hover:text-green-100' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    
                    @if(Auth::check() && Auth::user()->role === 'dean')
                        <a href="{{ route('dean.dashboard') }}" class="mt-1 group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dean.*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-600 hover:text-white' }}">
                            <svg class="mr-3 h-6 w-6 {{ request()->routeIs('dean.*') ? 'text-green-300' : 'text-green-200 group-hover:text-green-100' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Dean Dashboard
                        </a>
                        <a href="{{ route('dean.signature') }}" class="mt-1 group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dean.signature') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-600 hover:text-white' }}">
                            <svg class="mr-3 h-6 w-6 {{ request()->routeIs('dean.signature') ? 'text-green-300' : 'text-green-200 group-hover:text-green-100' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Manage Signature
                        </a>
                    @elseif(Auth::check() && Auth::user()->role === 'faculty')
                        <a href="{{ route('faculty.dashboard') }}" class="mt-1 group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('faculty.*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-600 hover:text-white' }}">
                            <svg class="mr-3 h-6 w-6 {{ request()->routeIs('faculty.*') ? 'text-green-300' : 'text-green-200 group-hover:text-green-100' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Faculty Dashboard
                        </a>
                    @else
                        <a href="{{ route('incomplete-grades.index') }}" class="mt-1 group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('incomplete-grades.*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-600 hover:text-white' }}">
                            <svg class="mr-3 h-6 w-6 {{ request()->routeIs('incomplete-grades.*') ? 'text-green-300' : 'text-green-200 group-hover:text-green-100' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Grade Completion
                        </a>
                    @endif
                    
                    <a href="{{ route('profile.edit') }}" class="mt-1 group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('profile.*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-600 hover:text-white' }}">
                        <svg class="mr-3 h-6 w-6 {{ request()->routeIs('profile.*') ? 'text-green-300' : 'text-green-200 group-hover:text-green-100' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                    <a href="{{ route('announcement.index') }}" class="mt-1 group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('announcement.*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-600 hover:text-white' }}">
                        <svg class="mr-3 h-6 w-6 {{ request()->routeIs('announcement.*') ? 'text-green-300' : 'text-green-200 group-hover:text-green-100' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m4 0h-1v4h-1m-4 0h-1v-4h-1m4 0h-1v4h-1" />
                        </svg>
                        Announcements
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-green-100 hover:bg-green-600 hover:text-white">
                            <svg class="mr-3 h-6 w-6 text-green-200 group-hover:text-green-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Log Out
                        </a>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-pastel-blue">
                    <div class="py-6">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
