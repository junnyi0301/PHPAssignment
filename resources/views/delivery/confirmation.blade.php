<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Confirmation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">Order Confirmation</h1>
                    
                    <!-- Delivery Time Information -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold">Delivery Time Guarantee</h3>
                        </div>
                        <p class="text-gray-600">
                            Order placed at: 
                            <span class="font-medium">{{ $currentTime->format('h:i A') }}</span>
                        </p>
                        <p class="text-gray-600">
                            Guaranteed delivery by: 
                            <span class="font-medium text-green-600">
                                {{ $estimatedTime->format('h:i A') }} 
                                (within 60 minutes)
                            </span>
                        </p>
                    </div>

                    <!-- Delivery Address Card -->
                    <div class="mb-6 p-4 border rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">Delivery Details</h3>
                        <p class="text-gray-600">
                            {{ $deliveryData['street_number'] }}, 
                            {{ $deliveryData['house_number'] }},<br>
                            {{ $deliveryData['area'] }},<br>
                            Kuala Lumpur
                        </p>
                        @if($deliveryData['notes'])
                            <p class="mt-2 text-gray-600">
                                <span class="font-medium">Delivery Notes:</span><br>
                                {{ $deliveryData['notes'] }}
                            </p>
                        @endif
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cartItems as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['name'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['quantity'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">RM {{ number_format($item['price'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <th colspan="2" class="px-6 py-3 text-left text-sm font-medium text-gray-700">Total</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">RM {{ number_format($totalPrice, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="mt-8">
                            <a href="{{ route('home') }}" 
                               class="inline-block px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg 
                                      transition-colors duration-200">
                                Home
                            </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>