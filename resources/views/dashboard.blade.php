<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-sm text-gray-600">ID Number: {{ Auth::user()->id_number }}</p>
                    
                    @if(Auth::check() && Auth::user()->role === 'dean')
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900">Dean Dashboard</h4>
                            <p class="mt-1 text-sm text-gray-600">
                                As a Dean of {{ Auth::user()->college }}, you can review and approve incomplete grade applications from your college.
                            </p>
                            
                            <div class="mt-4">
                                <a href="{{ route('dean.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Go to Dean Dashboard
                                </a>
                                
                                <a href="{{ route('dean.signature') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Manage Digital Signature
                                </a>
                            </div>
                        </div>
                    @elseif(Auth::check() && Auth::user()->role === 'faculty')
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900">Faculty Dashboard</h4>
                            <p class="mt-1 text-sm text-gray-600">
                                As a faculty member, you can view and manage incomplete grades for your courses.
                            </p>
                            
                            <div class="mt-4">
                                <a href="{{ route('faculty.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Faculty Dashboard
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900">Grade Completion</h4>
                            <p class="mt-1 text-sm text-gray-600">View and manage your incomplete grades and completion requirements. Please note that grade completion has specific <a href="{{ route('rules.index') }}" class="text-blue-600 hover:text-blue-800 underline font-medium">rules and guidelines</a> that must be followed.</p>
                            
                            <div class="mt-4">
                                <a href="{{ route('incomplete-grades.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Incomplete Grades
                                </a>
                                
                                <a href="{{ route('rules.index') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Rules & Guidelines
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
