<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Digital Signature') }}
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
                    
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">Digital Signature</h3>
                        <p class="mb-4">Create or update your digital signature below. This signature will be used when approving incomplete grade applications.</p>
                        
                        <div class="mb-6">
                            <form action="{{ route('dean.signature.store') }}" method="POST" id="signature-form">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Draw Your Signature:
                                    </label>
                                    <div class="border border-gray-300 rounded p-2 bg-white">
                                        <canvas id="signature-pad" class="w-full h-48 border border-gray-200 rounded"></canvas>
                                    </div>
                                    <input type="hidden" name="signature_data" id="signature-data">
                                </div>
                                
                                <div class="flex space-x-4">
                                    <button type="button" id="clear-btn" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                        Clear Signature
                                    </button>
                                    <button type="submit" id="save-btn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                        Save Signature
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        @if ($signature && $signature->signature_data)
                            <div class="mt-6">
                                <h4 class="text-md font-semibold mb-2">Current Signature:</h4>
                                <div class="border border-gray-300 rounded p-4 bg-white">
                                    <img src="{{ $signature->signature_data }}" alt="Your signature" class="max-h-48">
                                </div>
                                <div class="text-sm text-gray-500 mt-2">
                                    Last updated: {{ $signature->updated_at->format('M d, Y H:i:s') }}
                                    @if ($signature->last_used)
                                        <br>Last used: {{ $signature->last_used->format('M d, Y H:i:s') }}
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <a href="{{ route('dean.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });
            
            // Resize canvas to fill its container
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear(); // Clear the canvas after resize
            }
            
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();
            
            // Clear button handler
            document.getElementById('clear-btn').addEventListener('click', function() {
                signaturePad.clear();
            });
            
            // Save button handler
            document.getElementById('signature-form').addEventListener('submit', function(event) {
                if (signaturePad.isEmpty()) {
                    alert('Please provide a signature');
                    event.preventDefault();
                } else {
                    const signatureData = signaturePad.toDataURL();
                    document.getElementById('signature-data').value = signatureData;
                }
            });
            
            @if ($signature && $signature->signature_data)
                // If we want to load the existing signature for editing
                // This is commented out because usually you don't edit an existing signature
                // but rather create a new one
                /*
                const existingSignature = "{{ $signature->signature_data }}";
                const image = new Image();
                image.onload = function() {
                    const context = canvas.getContext('2d');
                    context.drawImage(image, 0, 0);
                };
                image.src = existingSignature;
                */
            @endif
        });
    </script>
</x-app-layout>