<?php
$category = $_GET['category'] ?? '';
$nameSearch = $_GET['name'] ?? '';
$minPrice = $_GET['min_price'] ?? '';

$results = [];

if (file_exists('foods.xml')) {
    $doc = new DOMDocument();
    $doc->load('foods.xml');
    $xpath = new DOMXPath($doc);
    $query = "//food";
    $conditions = [];

    if (!empty($category)) {
        $conditions[] = "category='$category'";
    }
    if (!empty($nameSearch)) {
        $escapedName = htmlspecialchars($nameSearch, ENT_QUOTES);
        $conditions[] = "contains(translate(name, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '".strtolower($escapedName)."')";
    }
    if (!empty($minPrice)) {
        $conditions[] = "price >= $minPrice";
    }
    if ($conditions) {
        $query .= "[" . implode(" and ", $conditions) . "]";
    }
    $nodes = $xpath->query($query);

    foreach ($nodes as $food) {
        $results[] = [
            'name' => $food->getElementsByTagName('name')[0]->nodeValue,
            'price' => $food->getElementsByTagName('price')[0]->nodeValue,
            'description' => $food->getElementsByTagName('description')[0]->nodeValue,
            'category' => $food->getElementsByTagName('category')[0]->nodeValue,
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Food</title>
    <style>
        table { border-collapse: collapse; width: 60%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>
    <h1>Search Food by Name, Category, or Price</h1>

    <form method="GET">
        <label for="name">Food Name Contains:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($nameSearch) ?>" />

        <label for="category">Category:</label>
        <select name="category" id="category">
            <option value="">-- Any --</option>
            <option value="Food" <?= $category === 'Food' ? 'selected' : '' ?>>Food</option>
            <option value="Drink" <?= $category === 'Drink' ? 'selected' : '' ?>>Drink</option>
        </select>

        <label for="min_price">Min Price:</label>
        <input type="number" step="0.01" name="min_price" id="min_price" value="<?= htmlspecialchars($minPrice) ?>" />

        <button type="submit">Search</button>
    </form>

    <?php if (!empty($results)): ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Category</th>
            </tr>
            <?php foreach ($results as $food): ?>
                <tr>
                    <td><?= htmlspecialchars($food['name']) ?></td>
                    <td><?= htmlspecialchars($food['price']) ?></td>
                    <td><?= htmlspecialchars($food['description']) ?></td>
                    <td><?= htmlspecialchars($food['category']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_GET): ?>
        <p>No matching food found.</p>
    <?php endif; ?>
</body>
</html>
