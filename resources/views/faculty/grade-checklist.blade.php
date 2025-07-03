<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-semibold mb-4">Students Checklist</h2>
                    <form method="GET" action="" class="mb-6 flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or ID..." class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-64">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Search</button>
                    </form>
                    <div class="bg-white rounded shadow p-4">
                        <table class="min-w-full bg-white border border-gray-200 rounded">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Number</th>
                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Major</th>
                                </tr>
                            </thead>
                            @php
                                $search = trim(request('search'));
                            @endphp
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($students as $student)
                                    @if($search)
                                        @if(!str_contains(strtolower($student->name), strtolower($search)) && !str_contains(strtolower($student->id_number), strtolower($search)))
                                            @continue
                                        @endif
                                    @endif
                                    <tr>
                                        <td class="py-2 px-4 border-b">
                                            <a href="{{ route('faculty.student-checklist', ['course' => $course->id, 'student' => $student->id]) }}" class="text-green-700 hover:underline font-semibold">
                                                {{ $student->name }}
                                            </a>
                                        </td>
                                        <td class="py-2 px-4 border-b text-gray-800">{{ $student->id_number }}</td>
                                        <td class="py-2 px-4 border-b text-gray-800">{{ $student->major ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-3 text-gray-500 text-center">No students found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>