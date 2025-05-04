<?php

namespace App\Factories;

use App\Models\Food;
use Illuminate\Http\UploadedFile;

class FoodFactory {

    public static function create(array $data, ?UploadedFile $image = null): Food {
        $food = Food::create([
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'category' => $data['category'] ?? null,
                    'description' => $data['description'] ?? null,
                    'image' => 'storage/images/empty/empty.jpg',
        ]);

        if ($image) {
            $extension = $image->getClientOriginalExtension();
            $filename = $food->id . '.' . $extension;
            $image->move(public_path('storage/images/products'), $filename);
            $food->image = 'storage/images/products/' . $filename;
            $food->save();
        }

        $xmlPath = public_path('foods.xml');
        if (!file_exists($xmlPath)) {
            $xml = new \SimpleXMLElement('<foods></foods>');
        } else {
            $xml = simplexml_load_file($xmlPath);
        }

        $foodNode = $xml->addChild('food');
        $foodNode->addChild('name', htmlspecialchars($food->name));
        $foodNode->addChild('price', $food->price);
        $foodNode->addChild('description', htmlspecialchars($food->description));
        $foodNode->addChild('category', htmlspecialchars($food->category));

        $xml->asXML($xmlPath);

        return $food;
    }
}
