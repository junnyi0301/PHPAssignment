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
                    <h1 class="text-2xl font-bold mb-2">Delivery Information</h1>
                    <p class="text-gray-600 mb-4">We currently deliver within Kuala Lumpur only</p>

                    <form method="POST" action="{{ route('delivery.calculate') }}" id="deliveryForm">
                        @csrf

                        <!-- 修改区域选择为下拉菜单 -->
                        <div class="mb-4">
                            <label for="area" class="block text-gray-700 text-sm font-bold mb-2">
                                Select Area in Kuala Lumpur:
                            </label>
                            <select name="area" id="area" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="" disabled selected>Select your area</option>
                                <option value="Kuala Lumpur City Centre">Kuala Lumpur City Centre</option>
                                <option value="Bangsar">Bangsar</option>
                                <option value="Damansara">Damansara</option>
                                <option value="Cheras">Cheras</option>
                                <option value="Ampang">Ampang</option>
                                <option value="Setapak">Setapak</option>
                                <option value="Taman Danau Kota">Taman Danau Kota</option>
                                <option value="Taman Melati">Taman Melati</option>
                                <option value="Taman Tun Dr Ismail (TTDI)">Taman Tun Dr Ismail (TTDI)</option>
                                <option value="Wangsa Maju">Wangsa Maju</option>
                                <!-- 添加更多吉隆坡区域 -->
                            </select>
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

    @push('scripts')
    <script>
        // 前端验证确保只接受吉隆坡区域
        document.getElementById('deliveryForm').addEventListener('submit', function(e) {
            const areaInput = document.getElementById('area');
            const selectedArea = areaInput.value.toLowerCase();
            const $klAreas = [
    'Kuala Lumpur City Centre',
    'Bangsar',
    'Brickfields',
    'Bukit Bintang',
    'Cheras',
    'Damansara',
    'Desa ParkCity',
    'Hartamas',
    'KL Sentral',
    'Mont Kiara',
    'Pudu',
    'Setapak',
    'Sri Petaling',
    'Taman Danau Kota',
    'Taman Melati',
    'Taman Tun Dr Ismail (TTDI)',
    'Wangsa Maju'
            ];
            
            if (!klAreas.includes(selectedArea)) {
                e.preventDefault();
                alert('We only deliver to areas within Kuala Lumpur. Please select a valid area.');
                areaInput.focus();
            }
        });
    </script>
    @endpush
</x-app-layout>