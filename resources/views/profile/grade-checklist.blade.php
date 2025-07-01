<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold">My Grade Checklist</h2>
                        @if($track)
                            <span class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                Track: {{ $track }}
                            </span>
                        @endif
                    </div>
                    
                    @if(!$track)
                        <div class="text-center py-8">
                            <div class="text-gray-500 mb-4">
                                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Track Information</h3>
                            <p class="text-gray-600">Unable to determine your track. Please contact the registrar to update your major information.</p>
                        </div>
                    @elseif($curriculumCourses->isEmpty())
                        <div class="text-center py-8">
                            <div class="text-gray-500 mb-4">
                                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Curriculum Found</h3>
                            <p class="text-gray-600">No curriculum data found for your track ({{ $track }}).</p>
                        </div>
                    @else
                        @php
                            $groupedByYear = $curriculumCourses->groupBy('year');
                            $totalSubjects = $curriculumCourses->count();
                            $gradedSubjects = 0;
                            $passedSubjects = 0;
                            $failedSubjects = 0;
                            $incompleteSubjects = 0;
                            $nfeSubjects = 0;
                            
                            foreach($curriculumCourses as $course) {
                                $grade = $existingGrades->get($course->subject_code);
                                if ($grade && $grade->grade) {
                                    $gradedSubjects++;
                                    switch($grade->grade) {
                                        case 'Passed': $passedSubjects++; break;
                                        case 'Failed': $failedSubjects++; break;
                                        case 'INC': $incompleteSubjects++; break;
                                        case 'NFE': $nfeSubjects++; break;
                                    }
                                }
                            }
                            
                            $notTakenSubjects = $totalSubjects - $gradedSubjects;
                        @endphp
                        
                        <!-- Progress Summary -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-700 mb-3">Academic Progress Summary</h3>
                            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ $totalSubjects }}</div>
                                    <div class="text-sm text-gray-500">Total Subjects</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">{{ $passedSubjects }}</div>
                                    <div class="text-sm text-gray-500">Passed</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-red-600">{{ $failedSubjects }}</div>
                                    <div class="text-sm text-gray-500">Failed</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-yellow-600">{{ $incompleteSubjects }}</div>
                                    <div class="text-sm text-gray-500">Incomplete</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-orange-600">{{ $nfeSubjects }}</div>
                                    <div class="text-sm text-gray-500">NFE</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-500">{{ $notTakenSubjects }}</div>
                                    <div class="text-sm text-gray-500">Not Taken</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Curriculum by Year -->
                        @foreach($groupedByYear as $year => $yearCourses)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800">
                                    Year {{ $year }}
                                    @if($year == 4)
                                        <span class="text-sm font-normal text-gray-600">(OJT/Internship)</span>
                                    @endif
                                </h3>
                                
                                @if($year != 4)
                                    @php $groupedByTrimester = $yearCourses->groupBy('trimester'); @endphp
                                    @foreach($groupedByTrimester as $trimester => $trimesterCourses)
                                        <div class="mb-6">
                                            <h4 class="text-md font-medium mb-3 text-gray-700">Trimester {{ $trimester }}</h4>
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Code</th>
                                                            <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Name</th>
                                                            <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                                            <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prerequisite</th>
                                                            <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach($trimesterCourses as $course)
                                                            @php
                                                                $grade = $existingGrades->get($course->subject_code);
                                                                $gradeStatus = optional($grade)->grade;
                                                            @endphp
                                                            <tr class="hover:bg-gray-50">
                                                                <td class="py-3 px-4 text-sm font-medium text-gray-900">{{ $course->subject_code }}</td>
                                                                <td class="py-3 px-4 text-sm text-gray-900">{{ $course->subject_name }}</td>
                                                                <td class="py-3 px-4 text-sm text-gray-900">{{ $course->units }}</td>
                                                                <td class="py-3 px-4 text-sm text-gray-900">{{ $course->prerequisite ?: 'None' }}</td>
                                                                <td class="py-3 px-4 text-sm">
                                                                    @if($gradeStatus)
                                                                        @if($gradeStatus === 'Passed')
                                                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                                                {{ $gradeStatus }}
                                                                            </span>
                                                                        @elseif($gradeStatus === 'Failed')
                                                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                                                {{ $gradeStatus }}
                                                                            </span>
                                                                        @elseif($gradeStatus === 'INC')
                                                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                                                {{ $gradeStatus }}
                                                                            </span>
                                                                        @elseif($gradeStatus === 'NFE')
                                                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                                                                                {{ $gradeStatus }}
                                                                            </span>
                                                                        @else
                                                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                                                                {{ $gradeStatus }}
                                                                            </span>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- 4th Year subjects without trimester grouping -->
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Code</th>
                                                    <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Name</th>
                                                    <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                                    <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prerequisite</th>
                                                    <th class="py-3 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($yearCourses as $course)
                                                    @php
                                                        $grade = $existingGrades->get($course->subject_code);
                                                        $gradeStatus = optional($grade)->grade;
                                                    @endphp
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="py-3 px-4 text-sm font-medium text-gray-900">{{ $course->subject_code }}</td>
                                                        <td class="py-3 px-4 text-sm text-gray-900">{{ $course->subject_name }}</td>
                                                        <td class="py-3 px-4 text-sm text-gray-900">{{ $course->units }}</td>
                                                        <td class="py-3 px-4 text-sm text-gray-900">{{ $course->prerequisite ?: 'None' }}</td>
                                                        <td class="py-3 px-4 text-sm">
                                                            @if($gradeStatus)
                                                                @if($gradeStatus === 'Passed')
                                                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                                        {{ $gradeStatus }}
                                                                    </span>
                                                                @elseif($gradeStatus === 'Failed')
                                                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                                        {{ $gradeStatus }}
                                                                    </span>
                                                                @elseif($gradeStatus === 'INC')
                                                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                                        {{ $gradeStatus }}
                                                                    </span>
                                                                @elseif($gradeStatus === 'NFE')
                                                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                                                                        {{ $gradeStatus }}
                                                                    </span>
                                                                @else
                                                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                                                        {{ $gradeStatus }}
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>