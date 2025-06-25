<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-semibold mb-4">My Grade Checklist</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Course</th>
                                    <th class="py-2 px-4 border-b">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($checklists as $checklist)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $checklist->course->code }} - {{ $checklist->course->title }}</td>
                                    <td class="py-2 px-4 border-b">{{ $checklist->grade ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-2 px-4 text-center text-gray-500">No grade checklist entries found.</td>
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