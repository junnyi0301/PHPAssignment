<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>
    <form action="{{ route('pay') }}" method="POST">
        @csrf
        <div class="container flex flex-row m-auto w-2/3 h-auto">
            <div class="w-2/3 flex flex-col justify-start">
                <div id="orderContainer" class="flex flex-col justify-start">
                </div>
                <div class="flex flex-col bg-white mx-8 rounded-lg p-8 shadow-lg w-2/3 mx-auto my-4">
                    <div class="w-2/3 m-auto">
                        <div class="flex flex-row justify-between">
                            <h2 class="text-xl font-bold">Subtotal:</h2>
                            <input type="hidden" name="subtotal" value="" id="subtotalInput">
                            <h2 class="text-xl font-bold" id="subtotal">RM0.00</h2>
                        </div>
                        <div class="flex flex-row justify-between">
                            <h2 class="text-xl font-bold">Tax:</h2>
                            <input type="hidden" name="tax" value="" id="taxInput">
                            <h2 class="text-xl font-bold" id="tax">RM0.00</h2>
                        </div>
                        <div class="flex flex-row justify-between">
                            <h2 class="text-xl font-bold">Total:</h2>
                            <input type="hidden" name="total" value="" id="totalInput">
                            <h2 class="text-xl font-bold" id="total">RM0.00</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/3 min-h-screen mx-auto bg-white shadow-lg border-t-2 border-gray-300">
                <div class="sticky top-0 mx-4">
                    <h2 class="font-semibold text-xl text-gray-800 p-4 text-center">Payment</h2>
                    <hr class="mb-4">
                    <input type="hidden" name="order" value="{{ $xml }}">
                    <label for="address" class="h-4">Address</label>
                    <input type="text" name="address" class="w-full h-8 mb-4 rounded-lg">
                    <label for="postalCode" class="h-4">Postal Code</label>
                    <input type="text" name="postalCode" class="w-full h-8 mb-4 rounded-lg">
                    <label for="city" class="h-4">City</label>
                    <input type="text" name="city" class="w-full h-8 mb-4 rounded-lg">
                    <label for="country" class="h-4">Country</label>
                    <input type="text" name="country" class="w-full h-8 mb-4 rounded-lg">
                    <hr class="mt-4">
                    <div class="mt-6 flex flex-row justify-between mx-16">
                        <div class="flex flex-row justify-start mb-4">
                            <input type="radio" name="consumeMethod" id="dineIn" value="dineIn" class="my-auto">
                            <label for="dineIn" class="ml-2">Dine In</label>
                        </div>
                        <div class="flex flex-row justify-start mb-4">
                            <input type="radio" name="consumeMethod" id="delivery" value="delivery" class="my-auto">
                            <label for="takeAway" class="ml-2">Delivery</label>
                        </div>
                    </div>
                    <button type="submit"
                        class="my-4 p-4 bg-indigo-400 hover:bg-indigo-500 transition duration-300 ease-in-out text-white font-semibold rounded-lg w-full">Pay
                        with Cash</button>
                    <button type="submit"
                        class="my-4 p-4 bg-gray-700 hover:bg-black transition duration-300 ease-in-out text-white font-semibold rounded-lg w-full">
                        Pay with PayPal
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script>
        async function loadOrder() {
            const xmlString = `{!! addslashes($xml) !!}`;
            console.log(xmlString);

            const xmlDoc = new DOMParser().parseFromString(xmlString, "text/xml");

            const xslRes = await fetch('/storage/xsl/order.xsl');
            const xslText = await xslRes.text();
            const xslDoc = new DOMParser().parseFromString(xslText, "text/xml");

            const xsltProcessor = new XSLTProcessor();
            xsltProcessor.importStylesheet(xslDoc);

            const resultDocument = xsltProcessor.transformToFragment(xmlDoc, document);

            const cartSection = document.getElementById('orderContainer');
            cartSection.innerHTML = '';
            cartSection.appendChild(resultDocument);

            const xpathResult = xmlDoc.evaluate("//price", xmlDoc, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);

            let total = 0;
            for (let i = 0; i < xpathResult.snapshotLength; i++) {
                total += parseFloat(xpathResult.snapshotItem(i).textContent);
            }

            // Display total
            const subtotalDisplay = document.getElementById('subtotal');
            const subtotalInput = document.getElementById('subtotalInput');
            if (subtotalDisplay) {
                subtotalDisplay.textContent = "RM " + total.toFixed(2);
                subtotalInput.value = total.toFixed(2);
            }

            const taxDisplay = document.getElementById('tax');
            const taxInput = document.getElementById('taxInput');
            if (taxDisplay) {
                taxDisplay.textContent = "RM " + (total * 0.06).toFixed(2);
                taxInput.value = (total * 0.06).toFixed(2);
            }

            const totalDisplay = document.getElementById('total');
            const totalInput = document.getElementById('totalInput');
            if (totalDisplay) {
                totalDisplay.textContent = "RM " + (total * 1.06).toFixed(2);
                totalInput.value = (total * 1.06).toFixed(2);
            }
        }

        loadOrder();
    </script>
</x-app-layout>
