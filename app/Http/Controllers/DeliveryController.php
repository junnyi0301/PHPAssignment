<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Patterns\DeliveryTimeContext;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DOMDocument;
use XSLTProcessor;
use SimpleXMLElement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DeliveryController extends Controller
{
    public function showForm()
    {
        return view('delivery.form');
    }

    public function calculate(Request $request)
    {
        $klAreas = [
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

        $validated = $request->validate([
            'area' => 'required|string|max:255',
            'street_number' => 'required|string|max:50',
            'house_number' => 'required|string|max:50',
            'notes' => 'nullable|string|max:500'
        ]);

        // CRUD Operation - Create
        $order = DeliveryOrder::create($validated);

        // State Pattern Implementation
        $currentTime = now();
        $context = new DeliveryTimeContext($currentTime);
        $estimatedTime = $context->getDeliveryTime(clone $currentTime);

        // XML/XSLT Handling with error handling
        $transformedXml = '<div class="error">Order summary unavailable</div>'; // Default fallback
        $xmlPath = null;

        try {
            // Ensure directory exists
            $directory = storage_path('app/orders');
            if (!file_exists($directory)) {
                if (!mkdir($directory, 0755, true)) {
                    throw new \Exception("Failed to create directory: $directory");
                }
            }

            // Create XML
            $xml = new SimpleXMLElement('<delivery_order/>');
            $xml->addChild('area', htmlspecialchars($validated['area']));
            $xml->addChild('street', htmlspecialchars($validated['street_number']));
            $xml->addChild('house', htmlspecialchars($validated['house_number']));
            $xml->addChild('timestamp', now()->toIso8601String());

            // Save XML
            $xmlPath = storage_path("app/orders/order_{$order->id}.xml");
            if (!$xml->asXML($xmlPath)) {
                throw new \Exception("Failed to save XML file: $xmlPath");
            }

            // XSLT Transformation
            $xsl = new DOMDocument;
            if (!$xsl->load(resource_path('views/xslt/order.xsl'))) {
                throw new \Exception("Failed to load XSL file");
            }

            $proc = new XSLTProcessor;
            $proc->importStyleSheet($xsl);
            $transformedXml = $proc->transformToXML($xml);

        } catch (\Exception $e) {
            Log::error('Delivery processing error: ' . $e->getMessage());
            // Continue with default $transformedXml value
        }

        // Secure Coding: Memory Management
        unset($xml, $xsl, $proc, $context);
        gc_collect_cycles();

        return view('delivery.confirmation', [
            'deliveryData' => $validated,
            'estimatedTime' => $estimatedTime,
            'currentTime' => $currentTime,
            'cartItems' => session('cart', []),
            'totalPrice' => $this->calculateTotal(),
            'xmlSummary' => $transformedXml,
            'xmlPath' => $xmlPath,
            'googleMapsKey' => config('services.google.maps.key') // Add this line
        ]);
    }

    private function calculateTotal(): float
    {
        return collect(session('cart', []))->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }
}



