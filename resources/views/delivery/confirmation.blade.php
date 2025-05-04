<!-- Add this section after Order Summary -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Delivery Confirmation') }}
        </h2>
    </x-slot>

    <!-- Google Maps Section -->
<div class="mt-6 p-4 bg-white border rounded-lg">
    <h3 class="text-lg font-semibold mb-4">Delivery Location Map</h3>
    <div id="map" class="w-full h-64 rounded-lg border border-gray-300"></div>
    <p class="mt-2 text-sm text-gray-600" id="map-address"></p>
</div>

@push('scripts')
<script>
    // 添加错误处理
    window.gm_authFailure = function() {
        alert('Google Maps authentication failed. Please check your billing account.');
    };
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsKey }}&callback=initMap" async defer></script>
@endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">Order Summary</h1>
                    <p class="text-gray-600 mb-4">Your order has been successfully placed!</p>
                </div>
            </div>
        </div>
    </div>
<div class="mt-6 p-4 bg-gray-50 rounded-lg">
    {!! $xmlSummary !!}
    
    <!-- XPath Example -->
    @php
        $xml = simplexml_load_file($xmlPath);
        $area = $xml->xpath('//area')[0];
    @endphp
    <p class="mt-2 text-sm">
        Delivery Location: <span class="font-medium">{{ $area }}</span>
    </p>
</br>
    <a href="{{ route('home') }}" 
   class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg
          transition-colors duration-200">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
    </svg>
    back to Home
</a>

</div>
</x-app-layout>

