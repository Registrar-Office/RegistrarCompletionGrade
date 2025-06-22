<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Announcement') }}
        </h2>
    </x-slot>

    <div class="flex justify-center items-center min-h-screen bg-pastel-blue">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-8">
            <form method="POST" action="{{ route('announcement.update', $announcement) }}">
                @csrf
                @method('PUT')
                <h3 class="text-2xl font-bold mb-6">Edit Announcement</h3>
                <div class="mb-4">
                    <label for="course_id" class="block text-gray-700 font-semibold mb-2">Select Course</label>
                    <select id="course_id" name="course_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
                        <option value="">Select a course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $announcement->course_id == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="student_search" class="block text-gray-700 font-semibold mb-2">Search Student by ID Number</label>
                    <input type="text" id="student_search" placeholder="Enter student ID number (e.g., 22-2014-166)" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 mb-2">
                    <button type="button" onclick="searchStudent()" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm">Search</button>
                </div>
                <div class="mb-4">
                    <label for="target_student_id" class="block text-gray-700 font-semibold mb-2">Target Audience</label>
                    <select id="target_student_id" name="target_student_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="">Send to all students (General Announcement)</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" data-id-number="{{ $student->id_number }}" {{ $announcement->target_student_id == $student->id ? 'selected' : '' }}>{{ $student->name }} ({{ $student->id_number }})</option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-600 mt-1">By default, this announcement will be sent to all students. Select a student below to send only to that student.</p>
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Announcement Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $announcement->title) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
                </div>
                <div class="mb-6">
                    <label for="body" class="block text-gray-700 font-semibold mb-2">Summary</label>
                    <textarea id="body" name="body" rows="4" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>{{ old('body', $announcement->body) }}</textarea>
                </div>
                <div class="flex justify-between">
                    <a href="{{ route('announcement.index') }}" class="px-4 py-2 border border-blue-500 text-blue-500 rounded hover:bg-blue-50">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function searchStudent() {
            const searchTerm = document.getElementById('student_search').value.trim();
            const select = document.getElementById('target_student_id');
            const options = select.querySelectorAll('option');
            
            if (!searchTerm) {
                // Reset all options to visible
                options.forEach(option => {
                    option.style.display = '';
                });
                return;
            }
            
            let found = false;
            options.forEach(option => {
                const idNumber = option.getAttribute('data-id-number');
                if (idNumber && idNumber.toLowerCase().includes(searchTerm.toLowerCase())) {
                    option.style.display = '';
                    if (!found) {
                        select.value = option.value;
                        found = true;
                    }
                } else if (option.value === '') {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
            
            if (!found) {
                alert('No student found with ID number: ' + searchTerm);
            }
        }
        
        // Allow Enter key to trigger search
        document.getElementById('student_search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchStudent();
            }
        });
    </script>
</x-app-layout> 