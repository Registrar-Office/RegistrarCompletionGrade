<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dean Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-6 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-6 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <!-- Submitted Applications Section -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Applications Awaiting Review</h3>
                            <a href="{{ route('dean.signature') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Manage Signature
                            </a>
                        </div>
                        
                        @if($submittedApplications->isEmpty())
                            <div class="text-center py-4 bg-gray-50 rounded-lg">
                                <p>No applications awaiting your review at this time.</p>
                            </div>
                        @else
                            <form action="{{ route('dean.bulk-approve') }}" method="POST">
                                @csrf
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    <input type="checkbox" id="select-all" class="form-checkbox h-4 w-4">
                                                </th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    Student
                                                </th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    Course
                                                </th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    Instructor
                                                </th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    Deadline
                                                </th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($submittedApplications as $application)
                                                <tr class="bg-blue-50">
                                                    <td class="py-2 px-4 border-b border-gray-200">
                                                        <input type="checkbox" name="selected_applications[]" value="{{ $application->id }}" class="application-checkbox form-checkbox h-4 w-4">
                                                    </td>
                                                    <td class="py-2 px-4 border-b border-gray-200">
                                                        {{ $application->user->name }} ({{ $application->user->id_number }})
                                                    </td>
                                                    <td class="py-2 px-4 border-b border-gray-200">
                                                        {{ $application->course->code }} - {{ $application->course->title }}
                                                    </td>
                                                    <td class="py-2 px-4 border-b border-gray-200">
                                                        {{ $application->course->instructor_name }}
                                                    </td>
                                                    <td class="py-2 px-4 border-b border-gray-200">
                                                        {{ $application->submission_deadline->format('M d, Y') }}
                                                    </td>
                                                    <td class="py-2 px-4 border-b border-gray-200">
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('dean.show', $application->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded text-xs">
                                                                View
                                                            </a>
                                                            <a href="{{ route('dean.approve', $application->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-xs" onclick="return confirm('Are you sure you want to approve this application?')">
                                                                Approve
                                                            </a>
                                                            <button type="button" onclick="showRejectModal({{ $application->id }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs">
                                                                Reject
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-4">
                                    <button type="submit" id="bulk-approve-btn" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded disabled:opacity-50" disabled>
                                        Bulk Approve Selected
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                    
                    <!-- All Applications Section -->
                    <div class="mt-8">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">All Grade Completion Applications</h3>
                        </div>
                        
                        @if($allApplications->isEmpty())
                            <div class="text-center py-4">
                                <p>No applications found for your college.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Student
                                            </th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Course
                                            </th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Instructor
                                            </th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Deadline
                                            </th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allApplications as $application)
                                            <tr>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    {{ $application->user->name }} ({{ $application->user->id_number }})
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    {{ $application->course->code }} - {{ $application->course->title }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    {{ $application->course->instructor_name }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    {{ $application->submission_deadline->format('M d, Y') }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    @if($application->status === 'Pending')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Pending
                                                        </span>
                                                    @elseif($application->status === 'Approved')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Approved
                                                        </span>
                                                    @elseif($application->status === 'Rejected')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Rejected
                                                        </span>
                                                    @elseif($application->status === 'Submitted')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Submitted
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            {{ $application->status }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('dean.show', $application->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded text-xs">
                                                            View
                                                        </a>
                                                        @if($application->status === 'Approved')
                                                            <a href="{{ route('dean.approval-document', $application->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-xs">
                                                                Approval Doc
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4">
                                {{ $allApplications->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reject Modal -->
    <div id="reject-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-10">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Application</h3>
                <div class="mt-2">
                    <form id="reject-form" method="POST" action="">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="rejection_reason" class="block text-gray-700 text-sm font-bold mb-2 text-left">
                                Reason for Rejection:
                            </label>
                            <textarea id="rejection_reason" name="rejection_reason" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="button" onclick="hideRejectModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </button>
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Reject
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Handle select all checkbox
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.application-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkApproveButton();
        });
        
        // Handle individual checkboxes
        document.querySelectorAll('.application-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkApproveButton);
        });
        
        // Update bulk approve button state
        function updateBulkApproveButton() {
            const checkboxes = document.querySelectorAll('.application-checkbox');
            const checkedCount = document.querySelectorAll('.application-checkbox:checked').length;
            const bulkApproveBtn = document.getElementById('bulk-approve-btn');
            
            bulkApproveBtn.disabled = checkedCount === 0;
        }
        
        // Show reject modal
        function showRejectModal(applicationId) {
            const modal = document.getElementById('reject-modal');
            const form = document.getElementById('reject-form');
            form.action = `/dean/applications/${applicationId}/reject`;
            modal.classList.remove('hidden');
        }
        
        // Hide reject modal
        function hideRejectModal() {
            const modal = document.getElementById('reject-modal');
            modal.classList.add('hidden');
            document.getElementById('reject-form').reset();
        }
    </script>
</x-app-layout> 