<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-semibold mb-4">Students Checklist</h2>
                    <form method="GET" action="" class="mb-6 flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search student name or ID number..." class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-64">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Search</button>
                    </form>
                    <div class="bg-white rounded shadow p-4">
                        <ul>
                            @forelse($students as $student)
                                <li class="border-b last:border-b-0 py-3">
                                    <a href="{{ route('faculty.student-checklist', ['course' => $course->id, 'student' => $student->id]) }}" class="text-blue-700 hover:underline font-medium">
                                        {{ $student->name }} <span class="text-gray-500">({{ $student->id_number }})</span>
                                    </a>
                                </li>
                            @empty
                                <li class="py-3 text-gray-500">No students found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>