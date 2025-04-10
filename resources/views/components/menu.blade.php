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
                        src="{{ $product->image }}">
                    <p class="font-semibold pt-1">{{ $product->name }}</p>
                    <p class="pt-1 text-center w-2/3 text-gray-500 h-20">{{ $product->description }}</p>
                    <p class="pt-1 text-gray-900">RM{{ $product->price }}</p>
                    <button
                        class="bg-indigo-400 hover:bg-indigo-500 transition duration-300 ease-in-out text-white font-bold py-2 px-4 rounded mt-3"
                        onclick="addToCart({{ $product }})">
                        Add to Cart
                    </button>
                </div>
            @endforeach
        </div>
        <div
            class="container w-1/4 min-h-screen bg-white shadow-lg border-t-2 border-gray-300 items-center flex flex-col">
            <div class="flex flex-col justify-start w-full px-4">
                <h2 class="font-semibold text-xl text-gray-800 p-4 text-center">Cart</h2>
                <hr class="mb-6 w-full">
                <div id="cart-items" class="flex flex-col justify-start px-6 w-full max-h-96 overflow-y-scroll">
                </div>
                <hr class="my-6 w-full">
                <div class="flex flex-col">
                    <div class="flex flex-row justify-between">
                        <h2 class="font-semibold">Subtotal</h2>
                        <h2>RM100</h2>
                    </div>
                    <div class="flex flex-row justify-between">
                        <h2 class="font-semibold">Tax</h2>
                        <h2>RM100</h2>
                    </div>
                    <div class="flex flex-row justify-between">
                        <h2 class="font-semibold">Total</h2>
                        <h2>RM100</h2>
                    </div>
                    <button type="submit"
                        class="my-4 p-4 bg-indigo-400 hover:bg-indigo-500 transition duration-300 ease-in-out text-white font-semibold rounded-lg w-full">Checkout</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const parser = new DOMParser();
        const serializer = new XMLSerializer();

        // Start with an empty cart XML
        let cartXml = parser.parseFromString(`<cart></cart>`, "application/xml");

        function addToCart(product, size) {
            const items = cartXml.getElementsByTagName('item');
            let found = false;

            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                const itemId = item.getElementsByTagName('id')[0].textContent;
                const itemSize = item.getElementsByTagName('size')[0].textContent;

                if (itemId == product.id) {
                    // Item exists, increase quantity
                    const quantityEl = item.getElementsByTagName('quantity')[0];
                    quantityEl.textContent = parseInt(quantityEl.textContent) + 1;
                    found = true;
                    break;
                }
            }

            if (!found) {
                const root = cartXml.createElement('item');

                const idNode = cartXml.createElement('id');
                idNode.textContent = product.id;

                const imageNode = cartXml.createElement('image');
                imageNode.textContent = product.image;

                const nameNode = cartXml.createElement('name');
                nameNode.textContent = product.name;

                const sizeNode = cartXml.createElement('size');
                sizeNode.textContent = size;

                const priceNode = cartXml.createElement('price');
                priceNode.textContent = product.price;

                const quantityNode = cartXml.createElement('quantity');
                quantityNode.textContent = 1;

                root.appendChild(idNode);
                root.appendChild(imageNode);
                root.appendChild(nameNode);
                root.appendChild(sizeNode);
                root.appendChild(priceNode);
                root.appendChild(quantityNode);

                cartXml.documentElement.appendChild(root);
            }
            console.log(serializer.serializeToString(cartXml));
            loadCart(serializer.serializeToString(cartXml));
        }

        async function loadCart(cartXml) {
            const xmlDoc = new DOMParser().parseFromString(cartXml, "text/xml");

            const xslRes = await fetch('/storage/xsl/cart.xsl');
            const xslText = await xslRes.text();
            const xslDoc = new DOMParser().parseFromString(xslText, "text/xml");

            const xsltProcessor = new XSLTProcessor();
            xsltProcessor.importStylesheet(xslDoc);

            const resultDocument = xsltProcessor.transformToFragment(xmlDoc, document);

            const cartSection = document.getElementById('cart-items');
            cartSection.innerHTML = '';
            cartSection.appendChild(resultDocument);
        }

        function removeItem(id) {
            const items = cartXml.getElementsByTagName('item');

            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                const itemId = item.getElementsByTagName('id')[0].textContent;
                const itemSize = item.getElementsByTagName('size')[0].textContent;

                if (itemId == id) {
                    // Reduce quantity
                    const quantityEl = item.getElementsByTagName('quantity')[0];
                    quantityEl.textContent = parseInt(quantityEl.textContent) - 1;

                    if (quantityEl.textContent == 0) {
                        // Remove item if quantity is 0
                        cartXml.documentElement.removeChild(item);
                    }
                    break;
                }
            }
            console.log(serializer.serializeToString(cartXml));
            loadCart(serializer.serializeToString(cartXml));
        }
    </script>
</x-app-layout>
