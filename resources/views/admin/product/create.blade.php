<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow mt-10">
        <h1 class="text-2xl font-bold mb-6">Add Product</h1>

        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <a onclick="document.getElementById('imageInput').click()">
                    <img id="foodImage" src="{{ asset('storage/images/empty/empty.jpg') }}" alt="Empty"
                        class="w-56 h-56 m-auto rounded-lg cursor-pointer">
                </a>
                <input type="file" id="imageInput" name="image" accept="image/*" class="hidden"
                    onchange="changePicture(event)">
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Product Name</label>
                <input type="text" name="name" id="name" value=""
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium">Price</label>
                <input type="number" name="price" id="price" value="" step="0.01"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Category</label>
                <input type="text" name="category" id="category" value="" step="0.01"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"></textarea>
            </div>

            {{-- Add more fields as needed --}}

            <div class="mt-6">
                <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                    Add Product
                </button>
            </div>
        </form>
    </div>
    <script>
        function changePicture(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const imgElement = document.getElementById('foodImage');
                imgElement.src = e.target.result; // Preview the image
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-admin-layout>
