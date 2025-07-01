<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-semibold mb-4">Grade Checklist for {{ $course->code }} - {{ $course->title }}</h2>
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="overflow-x-auto">
                        @foreach($students as $student)
                            @if(isset($curriculumCourses[$student->id]) && $curriculumCourses[$student->id]->isNotEmpty())
                                <div class="mb-8 border border-gray-200 rounded-lg p-4">
                                    <h3 class="text-lg font-medium mb-4 text-gray-800">
                                        {{ $student->name }} ({{ $student->id_number }})
                                        <span class="text-sm font-normal text-gray-600">
                                            - {{ $student->major ?? 'No major specified' }}
                                        </span>
                                    </h3>
                                    
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white border border-gray-200 rounded">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Code</th>
                                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Name</th>
                                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trimester</th>
                                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Status</th>
                                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Update Grade</th>
                                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($curriculumCourses[$student->id] as $curriculumCourse)
                                                    @php
                                                        // Find existing grade for this student and curriculum course
                                                        $existingCourse = \App\Models\Course::where('code', $curriculumCourse->subject_code)->first();
                                                        $checklist = null;
                                                        if ($existingCourse) {
                                                            $checklist = $checklists->where('student_id', $student->id)
                                                                                  ->where('course_id', $existingCourse->id)
                                                                                  ->first();
                                                        }
                                                        $currentGrade = optional($checklist)->grade;
                                                    @endphp
                                                    <tr class="hover:bg-gray-50">
                                                        <form method="POST" action="{{ route('faculty.grade-checklist.update', [$course->id, $student->id]) }}">
                                                            @csrf
                                                            <input type="hidden" name="subject_code" value="{{ $curriculumCourse->subject_code }}">
                                                            <input type="hidden" name="subject_name" value="{{ $curriculumCourse->subject_name }}">
                                                            
                                                            <td class="py-2 px-4 border-b text-sm font-medium text-gray-900">
                                                                {{ $curriculumCourse->subject_code }}
                                                            </td>
                                                            <td class="py-2 px-4 border-b text-sm text-gray-900">
                                                                {{ $curriculumCourse->subject_name }}
                                                            </td>
                                                            <td class="py-2 px-4 border-b text-sm text-gray-900">
                                                                {{ $curriculumCourse->year }}
                                                                @if($curriculumCourse->year == 4)
                                                                    <span class="text-xs text-gray-500">(OJT/Internship)</span>
                                                                @endif
                                                            </td>
                                                            <td class="py-2 px-4 border-b text-sm text-gray-900">
                                                                {{ $curriculumCourse->trimester ? 'Trimester ' . $curriculumCourse->trimester : 'N/A' }}
                                                            </td>
                                                            <td class="py-2 px-4 border-b text-sm text-gray-900">
                                                                {{ $curriculumCourse->units }}
                                                            </td>
                                                            <td class="py-2 px-4 border-b text-sm">
                                                                @if($currentGrade)
                                                                    @if($currentGrade === 'Passed')
                                                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                                            {{ $currentGrade }}
                                                                        </span>
                                                                    @elseif($currentGrade === 'Failed')
                                                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                                            {{ $currentGrade }}
                                                                        </span>
                                                                    @elseif($currentGrade === 'INC')
                                                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                                            {{ $currentGrade }}
                                                                        </span>
                                                                    @elseif($currentGrade === 'NFE')
                                                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                                                                            {{ $currentGrade }}
                                                                        </span>
                                                                    @else
                                                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                                                            {{ $currentGrade }}
                                                                        </span>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td class="py-2 px-4 border-b">
                                                                <select name="grade" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                                    <option value="" disabled {{ !$currentGrade ? 'selected' : '' }}>Select grade</option>
                                                                    <option value="Passed" {{ $currentGrade == 'Passed' ? 'selected' : '' }} class="text-green-600">Passed</option>
                                                                    <option value="Failed" {{ $currentGrade == 'Failed' ? 'selected' : '' }} class="text-red-600">Failed</option>
                                                                    <option value="INC" {{ $currentGrade == 'INC' ? 'selected' : '' }} class="text-red-600">INC</option>
                                                                    <option value="NFE" {{ $currentGrade == 'NFE' ? 'selected' : '' }} class="text-red-600">NFE</option>
                                                                </select>
                                                            </td>
                                                            <td class="py-2 px-4 border-b">
                                                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm transition-colors duration-200">
                                                                    Save
                                                                </button>
                                                            </td>
                                                        </form>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Progress Summary -->
                                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                        @php
                                            $totalSubjects = $curriculumCourses[$student->id]->count();
                                            $gradedSubjects = 0;
                                            $passedSubjects = 0;
                                            $failedSubjects = 0;
                                            $incompleteSubjects = 0;
                                            $nfeSubjects = 0;
                                            
                                            foreach($curriculumCourses[$student->id] as $curriculumCourse) {
                                                $existingCourse = \App\Models\Course::where('code', $curriculumCourse->subject_code)->first();
                                                if ($existingCourse) {
                                                    $checklist = $checklists->where('student_id', $student->id)
                                                                          ->where('course_id', $existingCourse->id)
                                                                          ->first();
                                                    if ($checklist && $checklist->grade) {
                                                        $gradedSubjects++;
                                                        switch($checklist->grade) {
                                                            case 'Passed': $passedSubjects++; break;
                                                            case 'Failed': $failedSubjects++; break;
                                                            case 'INC': $incompleteSubjects++; break;
                                                            case 'NFE': $nfeSubjects++; break;
                                                        }
                                                    }
                                                }
                                            }
                                            
                                            $notTakenSubjects = $totalSubjects - $gradedSubjects;
                                        @endphp
                                        
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Progress Summary:</h4>
                                        <div class="grid grid-cols-2 md:grid-cols-6 gap-2 text-xs">
                                            <div class="text-center">
                                                <div class="font-medium text-gray-900">{{ $totalSubjects }}</div>
                                                <div class="text-gray-500">Total</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="font-medium text-green-600">{{ $passedSubjects }}</div>
                                                <div class="text-gray-500">Passed</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="font-medium text-red-600">{{ $failedSubjects }}</div>
                                                <div class="text-gray-500">Failed</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="font-medium text-yellow-600">{{ $incompleteSubjects }}</div>
                                                <div class="text-gray-500">INC</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="font-medium text-orange-600">{{ $nfeSubjects }}</div>
                                                <div class="text-gray-500">NFE</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="font-medium text-gray-500">{{ $notTakenSubjects }}</div>
                                                <div class="text-gray-500">Blank</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-yellow-800">
                                        <strong>{{ $student->name }} ({{ $student->id_number }})</strong> - 
                                        No curriculum found. Please ensure the student has a valid major assigned 
                                        (Web Technology or Network Security track).
                                    </p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>