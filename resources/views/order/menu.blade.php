<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        src="{{ $product->getFood()->getImage() }}">
                    <p class="font-semibold pt-1">{{ $product->getFood()->getName() }}</p>
                    <p class="pt-1 text-center w-2/3 text-gray-500 h-20">{{ $product->getFood()->getDescription() }}</p>
                    <p class="pt-1 text-gray-900">RM{{ $product->getFood()->getPrice() }}</p>
                    <button
                        class="bg-indigo-400 hover:bg-indigo-500 transition duration-300 ease-in-out text-white font-bold py-2 px-4 rounded mt-3"
                        onclick="productOverlay( {{ $product->getFood()->getFood() }}, {{ json_encode($product->getOptions()) }})">
                        Add to Cart
                    </button>
                </div>
            @endforeach
        </div>
        <div
            class="container w-1/4 min-h-screen bg-white shadow-lg border-t-2 border-gray-300 items-center flex flex-col">
            <div class="flex flex-col justify-start w-full px-4 sticky top-0">
                <h2 class="font-semibold text-xl text-gray-800 p-4 text-center">Cart</h2>
                <hr class="mb-6 w-full">
                <div id="cart-items" class="flex flex-col justify-start px-6 w-full max-h-96 overflow-y-scroll">
                </div>
                <hr class="my-6 w-full">
                <div class="flex flex-col">
                    <div class="flex flex-row justify-between">
                        <h2 class="font-semibold">Subtotal</h2>
                        <h2 id="subtotal">RM100</h2>
                    </div>
                    <div class="flex flex-row justify-between">
                        <h2 class="font-semibold">Tax</h2>
                        <h2 id="tax">RM100</h2>
                    </div>
                    <div class="flex flex-row justify-between">
                        <h2 class="font-semibold">Total</h2>
                        <h2 id="total">RM100</h2>
                    </div>
                    <form action="/payment" method="POST" id="checkoutForm">
                        @csrf
                        <input type="hidden" name="xmlInput" id="xmlInput" value="">
                        <button type="button" onclick="checkout()"
                            class="my-4 p-4 bg-indigo-400 hover:bg-indigo-500 transition duration-300 ease-in-out text-white font-semibold rounded-lg w-full">Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div id="productOverlayBox"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl p-6 w-96 shadow-lg relative">
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-center">Choose Option</h2>
                    <div class="flex flex-col gap-3 mb-4" id='optionsGroup'>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button type="button" onclick="confirmOption()"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg">Confirm</button>
                    <button type="button" onclick="closeOverlay()"
                        class="text-gray-600 hover:underline">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const parser = new DOMParser();
        const serializer = new XMLSerializer();

        // Start with an empty cart XML
        let cartXml = parser.parseFromString('<cart></cart>', "application/xml");

        loadCart(serializer.serializeToString(cartXml));

        function checkout() {
            document.getElementById('xmlInput').value = serializer.serializeToString(cartXml);
            document.getElementById('checkoutForm').submit();
        }

        function addToCart(product, option, optionPrice) {
            const items = cartXml.getElementsByTagName('item');
            let found = false;

            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                const itemId = item.getElementsByTagName('id')[0].textContent;
                const itemOption = item.getElementsByTagName('option')[0].textContent;

                if (itemId == product.id && itemOption == option) {
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

                const optionNode = cartXml.createElement('option');
                optionNode.textContent = option;

                const priceNode = cartXml.createElement('price');
                priceNode.textContent = (Number(product.price) + Number(optionPrice)).toFixed(2);

                const quantityNode = cartXml.createElement('quantity');
                quantityNode.textContent = 1;

                root.appendChild(idNode);
                root.appendChild(imageNode);
                root.appendChild(nameNode);
                root.appendChild(optionNode);
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

            const xpathResult = xmlDoc.evaluate("//price", xmlDoc, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);

            let total = 0;
            for (let i = 0; i < xpathResult.snapshotLength; i++) {
                total += parseFloat(xpathResult.snapshotItem(i).textContent);
            }

            // Display total
            const subtotalDisplay = document.getElementById('subtotal');
            if (subtotalDisplay) {
                subtotalDisplay.textContent = "RM " + total.toFixed(2);
            }

            const taxDisplay = document.getElementById('tax');
            if (taxDisplay) {
                taxDisplay.textContent = "RM " + (total * 0.06).toFixed(2);
            }

            const totalDisplay = document.getElementById('total');
            if (totalDisplay) {
                totalDisplay.textContent = "RM " + (total * 1.06).toFixed(2);
            }
        }

        function removeItem(id, option) {
            const items = cartXml.getElementsByTagName('item');

            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                const itemId = item.getElementsByTagName('id')[0].textContent;
                const itemOption = item.getElementsByTagName('option')[0].textContent;

                if (itemId == id && itemOption == option) {
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

        function productOverlay(product, options) {
            window.selectedProduct = product;
            optionsGroup = document.getElementById('optionsGroup');
            optionsGroup.innerHTML = '';
            Object.entries(options).forEach(([key, value]) => {
                let label = document.createElement('label');
                label.classList.add('mr-2');

                // Create radio input element
                let radioInput = document.createElement('input');
                radioInput.type = 'radio';
                radioInput.name = 'option';
                radioInput.value = value;

                // Create text node for the option label
                let textNode = document.createTextNode(" " + key + " + RM" + value);

                // Append the radio input and text to the label
                label.appendChild(radioInput);
                label.appendChild(textNode);

                // Append the label to the options group container
                optionsGroup.appendChild(label);
            });
            document.getElementById('productOverlayBox').classList.remove('hidden');
        }

        function confirmOption() {
            const checkedRadio = document.querySelector('input[name="option"]:checked');
            const option = checkedRadio ? checkedRadio.parentElement.textContent.trim() : null;
            const onlyName = option.split('+')[0].trim();
            const optionPrice = document.querySelector('input[name="option"]:checked').value;
            addToCart(window.selectedProduct, onlyName, optionPrice);
            closeOverlay();
        }

        function closeOverlay() {
            document.getElementById('productOverlayBox').classList.add('hidden');
        }
    </script>
</x-app-layout>
