{{-- resources/views/delivery/form.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Delivery Information
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- <div class="mb-4">
                        <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800">
                            ← Back to Previous Page
                        </a>
                    </div> --}}

                    <h1 class="text-2xl font-bold mb-2">Delivery Information</h1>
                    <p class="text-gray-600 mb-4">We currently deliver within Kuala Lumpur only</p>

                    <form method="POST" action="{{ route('delivery.calculate') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="area" class="block text-gray-700 text-sm font-bold mb-2">
                                Area/Neighborhood:
                            </label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                   name="area" required 
                                   placeholder="e.g., Taman Danau Kota">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="street_number" class="block text-gray-700 text-sm font-bold mb-2">
                                    Street Number:
                                </label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                       name="street_number" required>
                            </div>
                            <div>
                                <label for="house_number" class="block text-gray-700 text-sm font-bold mb-2">
                                    House/Apartment Number:
                                </label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                       name="house_number" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">
                                Delivery Notes (optional):
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                      name="notes" rows="2" 
                                      placeholder="e.g., Building name, landmark"></textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ url()->previous() }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Back
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Confirm Delivery
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


