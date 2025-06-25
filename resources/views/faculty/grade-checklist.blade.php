<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-semibold mb-4">Grade Checklist for {{ $course->code }} - {{ $course->title }}</h2>
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Student</th>
                                    <th class="py-2 px-4 border-b">Grade</th>
                                    <th class="py-2 px-4 border-b">Course</th>
                                    <th class="py-2 px-4 border-b">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                @php
                                    $checklist = $checklists->firstWhere('student_id', $student->id);
                                @endphp
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $student->name }} ({{ $student->id_number }})</td>
                                    <form method="POST" action="{{ route('faculty.grade-checklist.update', [$course->id, $student->id]) }}">
                                        @csrf
                                        <td class="py-2 px-4 border-b">
                                            <select name="grade" class="border-gray-300 rounded">
                                                <option value="" disabled selected>Select grade</option>
                                                @foreach(['Passed', 'Failed', 'INC', 'NFE'] as $grade)
                                                    <option value="{{ $grade }}" @if(optional($checklist)->grade == $grade) selected @endif>{{ $grade }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <select name="course_id" class="border-gray-300 rounded w-full">
                                                @foreach($courses as $c)
                                                    <option value="{{ $c->id }}" @if((optional($checklist)->course_id ?? $course->id) == $c->id) selected @endif>{{ $c->code }} - {{ $c->title }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Save</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 