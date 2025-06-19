<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Announcements') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(Auth::check() && in_array(Auth::user()->role, ['dean', 'faculty']))
            <div class="mb-6 flex justify-end">
                <a href="{{ route('announcement.create') }}" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-6 rounded shadow">Create Announcement</a>
            </div>
        @endif
        <div class="bg-white shadow-lg rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-pastel-blue">
                    <tr>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Course</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Title</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Summary</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Author</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Date</th>
                        @if(Auth::check() && in_array(Auth::user()->role, ['dean', 'faculty']))
                            <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($announcements as $announcement)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">{{ $announcement->course->title ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900 font-semibold">{{ $announcement->title }}</td>
                            <td class="px-6 py-4 whitespace-pre-line text-gray-700">{{ $announcement->body }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $announcement->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $announcement->created_at->format('M d, Y H:i') }}</td>
                            @if(Auth::check() && in_array(Auth::user()->role, ['dean', 'faculty']))
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('announcement.edit', $announcement) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Edit</a>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-lg">No announcements yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 