<!-- filepath: resources/views/profile/curriculum.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curriculum') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-600">ID Number: {{ $user->id_number }}</p>
                        <p class="text-sm text-gray-600">Major: {{ $user->major }}</p>
                        <p class="text-sm text-gray-600">Track: {{ $track }}</p>
                    </div>

                    @if($curriculumData->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No curriculum found for your track.</p>
                        </div>
                    @else
                        @foreach($curriculumData as $year => $yearData)
                            <div class="mb-8">
                                <h4 class="text-lg font-semibold text-blue-800 mb-4">
                                    {{ $year == 1 ? '1st' : ($year == 2 ? '2nd' : ($year == 3 ? '3rd' : '4th')) }} Year
                                    @if($year == 4)
                                        <span class="text-sm font-normal text-gray-600">(OJT/Internship - No Trimester System)</span>
                                    @endif
                                </h4>
                                
                                @if($year == 4)
                                    {{-- 4th Year: No trimester grouping, show all subjects in one table --}}
                                    <div class="mb-6">
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                                            Subject Code
                                                        </th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                                            Subject Name
                                                        </th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                                            Units
                                                        </th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Prerequisite
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @php
                                                        $totalUnits = 0;
                                                        // Get all subjects for 4th year (they don't have trimester grouping)
                                                        $fourthYearSubjects = isset($yearData[null]) ? $yearData[null] : collect();
                                                    @endphp
                                                    @foreach($fourthYearSubjects as $subject)
                                                        @php
                                                            $totalUnits += $subject->units;
                                                        @endphp
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r">
                                                                {{ $subject->subject_code }}
                                                            </td>
                                                            <td class="px-4 py-3 text-sm text-gray-900 border-r">
                                                                {{ $subject->subject_name }}
                                                            </td>
                                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border-r text-center">
                                                                {{ $subject->units }}
                                                            </td>
                                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $subject->prerequisite ?? 'None' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr class="bg-blue-50 font-semibold">
                                                        <td colspan="2" class="px-4 py-3 text-sm text-gray-900 border-r text-right">
                                                            Total Units:
                                                        </td>
                                                        <td class="px-4 py-3 text-sm text-gray-900 border-r text-center">
                                                            {{ $totalUnits }}
                                                        </td>
                                                        <td class="px-4 py-3"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    {{-- 1st-3rd Year: Show trimester grouping --}}
                                    @foreach($yearData as $trimester => $subjects)
                                        @if($trimester !== null) {{-- Skip null trimester for years 1-3 --}}
                                            <div class="mb-6">
                                                <h5 class="text-md font-medium text-gray-700 mb-3">
                                                    {{ $trimester == 1 ? '1st' : ($trimester == 2 ? '2nd' : '3rd') }} Trimester
                                                </h5>
                                                
                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                                                        <thead class="bg-gray-50">
                                                            <tr>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                                                    Subject Code
                                                                </th>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                                                    Subject Name
                                                                </th>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                                                    Units
                                                                </th>
                                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                    Prerequisite
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            @php
                                                                $totalUnits = 0;
                                                            @endphp
                                                            @foreach($subjects as $subject)
                                                                @php
                                                                    $totalUnits += $subject->units;
                                                                @endphp
                                                                <tr class="hover:bg-gray-50">
                                                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r">
                                                                        {{ $subject->subject_code }}
                                                                    </td>
                                                                    <td class="px-4 py-3 text-sm text-gray-900 border-r">
                                                                        {{ $subject->subject_name }}
                                                                    </td>
                                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border-r text-center">
                                                                        {{ $subject->units }}
                                                                    </td>
                                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                                        {{ $subject->prerequisite ?? 'None' }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <tr class="bg-blue-50 font-semibold">
                                                                <td colspan="2" class="px-4 py-3 text-sm text-gray-900 border-r text-right">
                                                                    Total Units:
                                                                </td>
                                                                <td class="px-4 py-3 text-sm text-gray-900 border-r text-center">
                                                                    {{ $totalUnits }}
                                                                </td>
                                                                <td class="px-4 py-3"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endforeach

                        <!-- Summary -->
                        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                            <h5 class="text-md font-semibold text-blue-800 mb-2">Curriculum Summary</h5>
                            @php
                                $grandTotal = 0;
                                $totalSubjects = 0;
                                foreach($curriculumData as $year => $yearData) {
                                    if($year == 4) {
                                        // 4th year subjects (no trimester)
                                        if(isset($yearData[null])) {
                                            foreach($yearData[null] as $subject) {
                                                $grandTotal += $subject->units;
                                                $totalSubjects++;
                                            }
                                        }
                                    } else {
                                        // 1st-3rd year subjects (with trimesters)
                                        foreach($yearData as $trimester => $subjects) {
                                            if($trimester !== null) {
                                                foreach($subjects as $subject) {
                                                    $grandTotal += $subject->units;
                                                    $totalSubjects++;
                                                }
                                            }
                                        }
                                    }
                                }
                            @endphp
                            <p class="text-sm text-blue-700">
                                <strong>Total Subjects:</strong> {{ $totalSubjects }} |
                                <strong>Total Units:</strong> {{ $grandTotal }} |
                                <strong>Duration:</strong> 4 Years (Trimester System: Years 1-3, OJT/Internship: Year 4)
                            </p>
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>