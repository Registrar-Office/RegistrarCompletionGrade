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
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Announcement Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $announcement->title) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
                </div>
                <div class="mb-6">
                    <label for="body" class="block text-gray-700 font-semibold mb-2">Summary</label>
                    <textarea id="body" name="body" rows="4" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>{{ old('body', $announcement->body) }}</textarea>
                </div>
                <div class="flex justify-between">
                    <a href="{{ route('announcement.index') }}" class="px-4 py-2 border border-blue-500 text-blue-500 rounded hover:bg-blue-50">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-green-700 text-white rounded hover:bg-green-800">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 