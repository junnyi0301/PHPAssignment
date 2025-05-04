<?php
header('Content-Type: application/json');

$xml = simplexml_load_file('../foods.xml');
$foods = [];

foreach ($xml->food as $food) {
    $foods[] = [
        'name' => (string)$food->name,
        'price' => (float)$food->price,
        'description' => (string)$food->description,
        'category' => (string)$food->category,
    ];
}

echo json_encode($foods);

