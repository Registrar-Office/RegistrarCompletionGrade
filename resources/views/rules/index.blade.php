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
                        <h1 class="text-3xl font-bold text-green-800 mb-4">University Registrar Rules & Guidelines</h1>
                        <p class="text-gray-600 mb-6">Welcome to the UC Registrar system. Please review the following rules and guidelines.</p>
                    </div>

                    <!-- General Guidelines for All Users -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-green-700 mb-4">About Completion of Requirements for Removal of Incomplete (INC) Grades</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p>All INC Grade not completed within a term shall be converted to NG (No Grade) with Zero (0) credit.</p>
                        </div>
                    </div>

                    <!-- Student Guidelines -->
                    @if(Auth::user()->role === null || Auth::user()->role === 'student')
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
                                <li>Detailed plan for completing remaining coursework</li>
                                <li>Faculty member's approval (if applicable)</li>
                            </ul>
                            
                            <h3 class="text-lg font-medium text-blue-800 mb-3">Timeline Requirements</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700">
                                <li>Applications must be submitted within 30 days of the semester end</li>
                                <li>Incomplete grades must be resolved within one academic year</li>
                                <li>Extensions may be granted under exceptional circumstances</li>
                            </ul>
                        </div>
                    </div>
                    @endif

                    <!-- Faculty Guidelines -->
                    @if(Auth::user()->role === 'faculty')
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-purple-700 mb-4">Faculty Guidelines</h2>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-purple-800 mb-3">Application Review Process</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 mb-4">
                                <li>Review all incomplete grade applications within 5 business days</li>
                                <li>Verify the student's academic standing and course performance</li>
                                <li>Assess the validity of the student's request and supporting documentation</li>
                                <li>Provide detailed feedback if rejecting an application</li>
                                <li>Forward approved applications to the Dean's office</li>
                            </ul>
                            
                            <h3 class="text-lg font-medium text-purple-800 mb-3">Approval Criteria</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 mb-4">
                                <li>Student must have completed at least 60% of the course requirements</li>
                                <li>Valid extenuating circumstances must be documented</li>
                                <li>Student must demonstrate ability to complete remaining work</li>
                                <li>Proposed timeline must be reasonable and achievable</li>
                            </ul>
                            
                            <h3 class="text-lg font-medium text-purple-800 mb-3">Responsibilities</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700">
                                <li>Maintain communication with students about their progress</li>
                                <li>Submit final grades once incomplete work is completed</li>
                                <li>Report any issues or concerns to the Dean's office</li>
                                <li>Ensure compliance with university policies and procedures</li>
                            </ul>
                        </div>
                    </div>
                    @endif

                    <!-- Dean Guidelines -->
                    @if(Auth::user()->role === 'dean')
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-red-700 mb-4">Dean Guidelines</h2>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-red-800 mb-3">Final Approval Process</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 mb-4">
                                <li>Review all faculty-approved applications within 3 business days</li>
                                <li>Verify that all university policies and procedures have been followed</li>
                                <li>Ensure proper documentation and justification are provided</li>
                                <li>Make final approval or rejection decisions</li>
                                <li>Generate official approval documents for approved applications</li>
                            </ul>
                            
                            <h3 class="text-lg font-medium text-red-800 mb-3">Policy Enforcement</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 mb-4">
                                <li>Ensure consistent application of university policies</li>
                                <li>Monitor faculty compliance with review timelines</li>
                                <li>Address any policy violations or procedural issues</li>
                                <li>Maintain records of all decisions for audit purposes</li>
                            </ul>
                            
                            <h3 class="text-lg font-medium text-red-800 mb-3">Administrative Duties</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700">
                                <li>Manage digital signature for official documents</li>
                                <li>Generate and distribute approval documents</li>
                                <li>Monitor application statistics and trends</li>
                                <li>Provide guidance to faculty on policy interpretation</li>
                                <li>Handle appeals and exceptional cases</li>
                            </ul>
                        </div>
                    </div>
                    @endif

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