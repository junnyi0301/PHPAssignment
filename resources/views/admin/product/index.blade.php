<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>
    <div class="h-auto">
        @foreach ($products as $product)
            <div class="flex flex-col w-full m-auto justify-center">
                <div class="flex flex-row my-4 justify-center">
                    <img class="w-36 h-36 rounded-lg" src="{{ $product->image }}">
                    <div class="flex flex-col w-1/2 justify-center">
                        <div class="ml-4">
                            <h3 class="font-semibold text-xl text-gray-800 text-left">
                                {{ $product->name }}
                            </h3>
                            <h2 class="font-semibold text-xl text-gray-400 text-left">
                                {{ $product->description }}
                            </h2>
                            <h2 class="font-semibold text-xl text-gray-400 text-left">
                                {{ $product->price }}
                            </h2>
                        </div>
                    </div>
                    <div class="flex flex-row items-center justify-center">
                        <a href="{{ route('admin.edit', $product->id) }}"
                            class="inline-block px-5 py-1.5 text-black dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            Edit
                        </a>
                        <form action="{{ route('admin.destroy', $product->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-block px-5 py-1.5 text-black dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                <hr class="border-t-1 border-gray-300 mx-8">
                </hr>
            </div>
        @endforeach
    </div>
</x-admin-layout>
