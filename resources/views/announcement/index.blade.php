<x-app-layout>
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
             class="fixed top-6 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50 transition-all duration-500">
            {{ session('success') }}
        </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Announcements') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4">
        @if(Auth::check() && in_array(Auth::user()->role, ['dean', 'faculty']))
            <div class="mb-6 flex justify-end">
                <a href="{{ route('announcement.create') }}" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-6 rounded shadow">Create Announcement</a>
            </div>
        @endif
        <div x-data="{
            showModal: false,
            selected: null,
            announcement: {},
            setAnnouncement(data) {
                this.announcement = data;
                this.selected = data.id;
                this.showModal = true;
            }
        }">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Course</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Title</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Summary</th>
                        @if(Auth::check() && in_array(Auth::user()->role, ['dean', 'faculty']))
                            <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Target Student</th>
                        @endif
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Author</th>
                        <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Date</th>
                        @if(Auth::check() && in_array(Auth::user()->role, ['dean', 'faculty']))
                            <th class="px-6 py-4 text-left text-lg font-semibold text-gray-700">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($announcements as $announcement)
                        <tr class="cursor-pointer hover:bg-gray-50"
                            @click="setAnnouncement({
                                id: {{ $announcement->id }},
                                title: @js($announcement->title),
                                course: @js($announcement->course->title ?? '-'),
                                author: @js($announcement->user->name),
                                date: @js($announcement->created_at->format('M d, Y H:i')),
                                body: @js($announcement->body),
                                user_id: {{ (int)$announcement->user_id }},
                                targetStudent: @js($announcement->targetStudent ? $announcement->targetStudent->name . ' (' . $announcement->targetStudent->id_number . ')' : null),
                                targetStudentId: {{ $announcement->target_student_id ?? 'null' }}
                            })">
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">{{ $announcement->course->title ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900 font-semibold">{{ $announcement->title }}</td>
                            <td class="px-6 py-4 whitespace-pre-line text-gray-700">
                                {{ Str::limit($announcement->body, 60) }}
                                <span class="text-blue-500 ml-2">(click to expand)</span>
                            </td>
                            @if(Auth::check() && in_array(Auth::user()->role, ['dean', 'faculty']))
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    @if($announcement->targetStudent)
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                            {{ $announcement->targetStudent->name }} ({{ $announcement->targetStudent->id_number }})
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">All Students</span>
                                    @endif
                                </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $announcement->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $announcement->created_at->format('M d, Y H:i') }}</td>
                            @if(Auth::check() && in_array(Auth::user()->role, ['dean', 'faculty']))
                                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                    @if(Auth::check() && Auth::user()->id == $announcement->user_id)
                                        <a href="{{ route('announcement.edit', $announcement) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded" @click.stop> Edit </a>
                                        <form method="POST" action="{{ route('announcement.destroy', $announcement) }}" onsubmit="return confirm('Are you sure?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::check() && in_array(Auth::user()->role, ['dean', 'faculty']) ? '7' : '5' }}" class="px-6 py-8 text-center text-gray-500 text-lg">No announcements yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Single Modal Popup -->
            <template x-if="showModal">
                <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40" @click.self="showModal = false">
                    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-8 relative">
                        <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl font-bold" @click="showModal = false">&times;</button>
                        <h2 class="text-2xl font-bold mb-4" x-text="announcement.title"></h2>
                        <div class="mb-2 text-gray-600 text-base">
                            <span class="font-semibold">Course:</span> <span x-text="announcement.course"></span><br>
                            <span class="font-semibold">Author:</span> <span x-text="announcement.author"></span><br>
                            <span class="font-semibold">Date:</span> <span x-text="announcement.date"></span><br>
                            <template x-if="announcement.targetStudent">
                                <span><span class='font-semibold'>Target Student:</span> <span class='bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm' x-text="announcement.targetStudent"></span></span>
                            </template>
                            <template x-if="!announcement.targetStudent">
                                <span><span class='font-semibold'>Target Student:</span> <span class='bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm'>All Students</span></span>
                            </template>
                        </div>
                        <div class="mb-6 text-gray-800 whitespace-pre-line text-lg" x-text="announcement.body"></div>
                        @if(Auth::check() && in_array(Auth::user()->role, ['dean', 'faculty']))
                            <template x-if="Number({{ Auth::id() }}) === Number(announcement.user_id)">
                                <div class="flex gap-2">
                                    <a :href="'/announcement/' + announcement.id + '/edit'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Edit</a>
                                    <form :action="'/announcement/' + announcement.id" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded">Delete</button>
                                    </form>
                                </div>
                            </template>
                        @endif
                    </div>
                </div>
            </template>
        </div>
    </div>
</x-app-layout> 