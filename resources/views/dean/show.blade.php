<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-6 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-6 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Incomplete Grade Application</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ $incompleteGrade->status }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Student Information</h4>
                                <div class="bg-gray-50 p-4 rounded border border-gray-200">
                                    <p><span class="font-medium">Name:</span> {{ $incompleteGrade->user->name }}</p>
                                    <p><span class="font-medium">ID Number:</span> {{ $incompleteGrade->user->id_number }}</p>
                                    <p><span class="font-medium">Email:</span> {{ $incompleteGrade->user->email }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Course Information</h4>
                                <div class="bg-gray-50 p-4 rounded border border-gray-200">
                                    <p><span class="font-medium">Code:</span> {{ $incompleteGrade->course->code }}</p>
                                    <p><span class="font-medium">Title:</span> {{ $incompleteGrade->course->title }}</p>
                                    <p><span class="font-medium">Instructor:</span> {{ $incompleteGrade->course->instructor_name }}</p>
                                    <p><span class="font-medium">College:</span> {{ $incompleteGrade->course->college }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Reason for Incompleteness</h4>
                            <div class="bg-gray-50 p-4 rounded border border-gray-200">
                                <p>{{ $incompleteGrade->reason_for_incompleteness }}</p>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Submission Details</h4>
                            <div class="bg-gray-50 p-4 rounded border border-gray-200">
                                <p><span class="font-medium">Submission Deadline:</span> {{ $incompleteGrade->submission_deadline->format('F d, Y') }}</p>
                                <p>
                                    <span class="font-medium">Days Remaining:</span> 
                                    @if($incompleteGrade->submission_deadline->isPast())
                                        <span class="text-red-500">Deadline has passed</span>
                                    @else
                                        <span class="text-green-500">{{ $incompleteGrade->submission_deadline->diffInDays(now()) }} days</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex justify-between mt-8">
                            <div class="flex space-x-4">
                                <a href="{{ route('dean.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                    Back to Dashboard
                                </a>
                            </div>
                            
                            <div class="flex space-x-4">
                                <a href="{{ route('dean.approve', $incompleteGrade->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to approve this application?')">
                                    Approve
                                </a>
                                <button type="button" onclick="showRejectModal()" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                    Reject
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reject Modal -->
    <div id="reject-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-10">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Application</h3>
                <div class="mt-2">
                    <form id="reject-form" method="POST" action="{{ route('dean.reject', $incompleteGrade->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="rejection_reason" class="block text-gray-700 text-sm font-bold mb-2 text-left">
                                Reason for Rejection:
                            </label>
                            <textarea id="rejection_reason" name="rejection_reason" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="button" onclick="hideRejectModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </button>
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Reject
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Show reject modal
        function showRejectModal() {
            const modal = document.getElementById('reject-modal');
            modal.classList.remove('hidden');
        }
        
        // Hide reject modal
        function hideRejectModal() {
            const modal = document.getElementById('reject-modal');
            modal.classList.add('hidden');
            document.getElementById('reject-form').reset();
        }
    </script>
</x-app-layout> 