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
                    @if(Auth::user()->major)
                        <p class="mt-1 text-sm text-gray-600">Course/Major: {{ Auth::user()->major }}</p>
                    @endif
                    
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
                            <h4 class="text-md font-medium text-gray-900">Student Dashboard</h4>
                            <p class="mt-1 text-sm text-gray-600">
                                Your incomplete grades will appear when your faculty marks any of your courses as Failed, INC, or NFE. 
                                You can also view your curriculum and check the rules and guidelines for grade completion.
                            </p>
                            
                            <div class="mt-4 space-y-2">
                                <div>
                                    <a href="{{ route('incomplete-grades.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        View Incomplete Grades
                                    </a>
                                    
                                    <a href="{{ route('profile.curriculum') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        View My Curriculum
                                    </a>
                                </div>
                                
                                <div>
                                    <a href="{{ route('rules.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        View Rules & Guidelines
                                    </a>
                                    
                                    <a href="{{ route('profile.grade-checklist') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        View Grade Checklist
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
