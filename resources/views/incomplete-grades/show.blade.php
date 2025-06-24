<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Incomplete Grade') }}
            </h2>
            <a href="{{ route('incomplete-grades.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Course Information</h3>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Course Code</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $incompleteGrade->course->code }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Course Title</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $incompleteGrade->course->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Instructor</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $incompleteGrade->course->instructor_name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Incomplete Grade Details</h3>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if ($incompleteGrade->status == 'Pending') bg-yellow-100 text-yellow-800
                                        @elseif ($incompleteGrade->status == 'Submitted') bg-blue-100 text-blue-800
                                        @elseif ($incompleteGrade->status == 'Approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $incompleteGrade->status }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Submission Deadline</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $incompleteGrade->submission_deadline->format('F d, Y') }}</p>
                                <p class="text-xs text-gray-500">
                                    @if ($incompleteGrade->submission_deadline->isPast())
                                        <span class="text-red-500">Overdue</span>
                                    @else
                                        {{ $incompleteGrade->submission_deadline->diffForHumans() }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Reason for Incompleteness</h3>
                        <div class="mt-2 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-900">{{ $incompleteGrade->reason_for_incompleteness }}</p>
                        </div>
                    </div>

                    @if($incompleteGrade->attachment_path)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Supporting Document</h3>
                        <div class="mt-2">
                            <a href="{{ route('incomplete-grades.download-attachment', $incompleteGrade) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-medium text-sm text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Download Attachment
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('incomplete-grades.edit', $incompleteGrade) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit
                        </a>
                        
                        @if ($incompleteGrade->status == 'Pending')
                            <form action="{{ route('incomplete-grades.update-status', $incompleteGrade) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Submitted">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Submit for Approval
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('incomplete-grades.destroy', $incompleteGrade) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 