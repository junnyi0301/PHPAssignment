<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu') }}
        </h2>
    </x-slot>
    <div class="container flex flex-row m-auto">
        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12 w-3/4 h-auto m-auto">
            @foreach ($products as $product)
                <div class="xl:w-1/3"
                    style="display: flex; flex-flow: column; justify-content: center; align-items: center; padding-bottom: 48px; padding: 16px;">
                    <img class="w-32 h-32 md:w-48 md:h-48 xl:w-64 xl:h-64 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:grow hover:shadow-lg rounded-lg"
                        src="{{ asset($product->image) }}">
                    <p class="font-semibold pt-1">{{ $product->name }}</p>
                    <p class="pt-1 text-center w-2/3 text-gray-500 h-20">{{ $product->description }}</p>
                    <p class="pt-1 text-gray-900">RM{{ $product->price }}</p>
                    <button
                        class="bg-indigo-400 hover:bg-indigo-500 transition duration-300 ease-in-out text-white font-bold py-2 px-4 rounded mt-3"
                        onclick="alert('{{ $product->name }} added to cart!')">
                        Add to Cart
                    </button>
                </div>
            @endforeach
        </div>
        <div
            class="container w-1/4 min-h-screen bg-white shadow-lg border-t-2 border-gray-300 items-center flex flex-col">
            <x-cart />
        </div>
    </div>
</x-app-layout>
