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
                    
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900">Grade Completion</h4>
                        <p class="mt-1 text-sm text-gray-600">View and manage your incomplete grades and completion requirements.</p>
                        
                        <div class="mt-4">
                            <a href="{{ route('incomplete-grades.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                View Incomplete Grades
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
