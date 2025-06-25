<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rules & Guidelines') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-green-800 mb-4">UC Registrar Grade Completion System</h1>
                        <p class="text-gray-600 mb-6">Welcome to the UC Registrar Grade Completion Page. Please review the following rules and guidelines.</p>
                    </div>

                    <!-- General Guidelines for All Users -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-green-700 mb-4">About Completion of Requirements for Removal of Incomplete (INC) Grades</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p>All INC Grade not completed within a term shall be converted to NG (No Grade) with Zero (0) credit.</p>
                        </div>
                    </div>

                    <!-- Student Guidelines -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-blue-700 mb-4">Rules for Completion of Requirements</h2>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-blue-800 mb-3">The following shall be observed for completion of requirements for removal of INC Grade:</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 mb-4">
                                <li>Courses of all programs, with  an INC Grade may be completed within one term after an INC Grade.</li>
                                <li>Thesis 1, Dissertation Writing 1, and Project Study 1 may be completed within one term after an INC Grade.</li>
                                <li>Thesis Research Writing 1 of BS Architecture may be completed one school year after enrolment term.</li>
                                <li>All INC Grade not completed within a term shall be converted to NG (No Grade) with Zero (0) credit.</li>
                                <li>Thesis 2, Dissertation Writing 2, and Project Study 2 shall be defended within the term the student is enrolled in the said course.</li>
                            </ul>
                            
                            <h3 class="text-lg font-medium text-blue-800 mb-3">Required Documents</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 mb-4">
                                <li>Completed application form</li>
                                <li>Supporting documentation (medical certificates, etc.)</li>
                                <li>Faculty member's approval</li>
                            </ul>
                            
                            <h3 class="text-lg font-medium text-blue-800 mb-3">Timeline Requirements</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700">
                                <li>Applications must be submitted within 30 days of the semester end</li>
                                <li>Incomplete grades must be resolved within one term</li>
                                <li>Extensions may be granted under exceptional circumstances</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mt-8 p-4 bg-green-50 rounded-lg">
                        <h2 class="text-xl font-semibold text-green-800 mb-3">Need Help?</h2>
                        <p class="text-gray-700 mb-2">If you have questions about these rules and guidelines, please contact:</p>
                        <ul class="text-gray-700">
                            <li><strong>Registrar's Office:</strong> registrar@university.edu</li>
                            <li><strong>Technical Support:</strong> support@university.edu</li>
                            <li><strong>Phone:</strong> (555) 123-4567</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 