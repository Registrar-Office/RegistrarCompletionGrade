<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
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
                        <h3 class="text-lg font-semibold mb-2">Student Information</h3>
                        <div class="bg-gray-50 p-4 rounded border border-gray-200">
                            <p><span class="font-medium">Name:</span> {{ $incompleteGrade->user->name }}</p>
                            <p><span class="font-medium">ID Number:</span> {{ $incompleteGrade->user->id_number }}</p>
                            <p><span class="font-medium">Email:</span> {{ $incompleteGrade->user->email }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Course Information</h3>
                        <div class="bg-gray-50 p-4 rounded border border-gray-200">
                            <p><span class="font-medium">Code:</span> {{ $incompleteGrade->course->code }}</p>
                            <p><span class="font-medium">Title:</span> {{ $incompleteGrade->course->title }}</p>
                            <p><span class="font-medium">Instructor:</span> {{ $incompleteGrade->course->instructor_name }}</p>
                            <p><span class="font-medium">College:</span> {{ $incompleteGrade->course->college }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Reason for Incompleteness</h3>
                        <div class="bg-gray-50 p-4 rounded border border-gray-200">
                            <p>{{ $incompleteGrade->reason_for_incompleteness }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Submission Details</h3>
                        <div class="bg-gray-50 p-4 rounded border border-gray-200">
                            <p><span class="font-medium">Submission Deadline:</span> {{ $incompleteGrade->submission_deadline->format('F d, Y') }}</p>
                            <p><span class="font-medium">Status:</span> {{ $incompleteGrade->status }}</p>
                            @if($incompleteGrade->status === 'Rejected' && $incompleteGrade->rejection_reason)
                                <p><span class="font-medium">Rejection Reason:</span> {{ $incompleteGrade->rejection_reason }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <a href="{{ route('faculty.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Back to Dashboard
                        </a>
                        <div class="flex space-x-4">
                            <!-- Forward to Dean Form -->
                            <form method="POST" action="{{ route('faculty.forward', $incompleteGrade->id) }}">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to forward this application to the dean?')">
                                    Forward to Dean
                                </button>
                            </form>
                            <!-- Reject Form -->
                            <form method="POST" action="{{ route('faculty.reject', $incompleteGrade->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="text" name="rejection_reason" placeholder="Reason for rejection" class="border rounded px-2 py-1 mr-2" required minlength="10">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to reject this application?')">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 