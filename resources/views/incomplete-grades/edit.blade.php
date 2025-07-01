<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Incomplete Grade Request') }}
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
                    @if($failedCourses->isEmpty())
                        <div class="text-center py-8">
                            <div class="text-gray-500 mb-4">
                                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Failed Subjects</h3>
                            <p class="text-gray-600">You don't have any subjects marked as Failed, INC, or NFE by faculty. You can only create requests for subjects that have been marked as failed.</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('incomplete-grades.update', $incompleteGrade) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Course Selection -->
                            <div class="mb-4">
                                <label for="course_id" class="block font-medium text-sm text-gray-700">Course</label>
                                <select id="course_id" name="course_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select a course</option>
                                    @foreach ($failedCourses as $course)
                                        <option value="{{ $course->id }}" {{ (old('course_id', $incompleteGrade->course_id) == $course->id) ? 'selected' : '' }}>
                                            {{ $course->code }} - {{ $course->title }} ({{ $course->instructor_name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Reason for Incompleteness -->
                            <div class="mb-4">
                                <label for="reason_for_incompleteness" class="block font-medium text-sm text-gray-700">Reason for Incompleteness</label>
                                <textarea id="reason_for_incompleteness" name="reason_for_incompleteness" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('reason_for_incompleteness', $incompleteGrade->reason_for_incompleteness) }}</textarea>
                                @error('reason_for_incompleteness')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- File Attachment -->
                            <div class="mb-4">
                                <label for="attachment" class="block font-medium text-sm text-gray-700">Supporting Document</label>
                                
                                @if($incompleteGrade->attachment_path)
                                    <div class="mb-2 p-3 bg-gray-50 rounded-md">
                                        <p class="text-sm text-gray-600">Current file: 
                                            <a href="{{ Storage::url($incompleteGrade->attachment_path) }}" 
                                               target="_blank" 
                                               class="text-blue-600 hover:underline">
                                                {{ basename($incompleteGrade->attachment_path) }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                                
                                <input type="file" id="attachment" name="attachment" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($incompleteGrade->attachment_path)
                                        Upload a new file to replace the current one. 
                                    @endif
                                    Accepted file types: PDF, DOC, DOCX, JPG, JPEG, PNG (max 10MB)
                                </p>
                                @error('attachment')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6 flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <strong>Status:</strong> 
                                    @if($incompleteGrade->status === 'Pending')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $incompleteGrade->status }}
                                        </span>
                                    @elseif($incompleteGrade->status === 'Submitted')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                            {{ $incompleteGrade->status }}
                                        </span>
                                    @elseif($incompleteGrade->status === 'Approved')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            {{ $incompleteGrade->status }}
                                        </span>
                                    @elseif($incompleteGrade->status === 'Rejected')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                            {{ $incompleteGrade->status }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                            {{ $incompleteGrade->status }}
                                        </span>
                                    @endif
                                </div>
                                
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Update Request
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>