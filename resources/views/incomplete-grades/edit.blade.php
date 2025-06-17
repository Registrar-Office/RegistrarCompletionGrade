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
                    <form method="POST" action="{{ route('incomplete-grades.update', $incompleteGrade) }}">
                        @csrf
                        @method('PUT')

                        <!-- Course Selection -->
                        <div class="mb-4">
                            <label for="course_id" class="block font-medium text-sm text-gray-700">Course</label>
                            <select id="course_id" name="course_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select a course</option>
                                @foreach ($courses as $course)
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

                        <!-- Current Status Display (non-editable) -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Current Status</label>
                            <div class="mt-1">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if ($incompleteGrade->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif ($incompleteGrade->status == 'Submitted') bg-blue-100 text-blue-800
                                    @elseif ($incompleteGrade->status == 'Approved') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $incompleteGrade->status }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-6 flex space-x-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Request
                            </button>
                            
                            @if ($incompleteGrade->status == 'Pending')
                                <a href="#" onclick="event.preventDefault(); document.getElementById('submit-form').submit();" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Submit for Approval
                                </a>
                                
                                <form id="submit-form" action="{{ route('incomplete-grades.update-status', $incompleteGrade) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="Submitted">
                                </form>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 