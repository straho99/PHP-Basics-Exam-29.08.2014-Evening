<?php
$input = $_GET['priceList'];
preg_match_all("/<tr>\s*<td>\s*([^<\n\r]+)\s*<\/td>\s*<td>\s*([^<\n\r]+)\s*<\/td>\s*<td>\s*([^<\n\r]+)\s*<\/td>\s*<td>\s*([^<\n\r]+)\s*<\/td>/", $input, $matches);

$productInfo = [];
for ($i = 0; $i < count($matches[1]); $i++) {
    $product = array(
        'product'=>trim(html_entity_decode($matches[1][$i]))
    );
    $productInfo[] = $product;
}
for ($i = 0; $i < count($matches[2]); $i++) {
    $productInfo[$i]['category'] = trim(html_entity_decode($matches[2][$i]));
}
for ($i = 0; $i < count($matches[3]); $i++) {
    $productInfo[$i]['price'] = trim($matches[3][$i]);
}
for ($i = 0; $i < count($matches[4]); $i++) {
    $productInfo[$i]['currency'] = trim(html_entity_decode(($matches[4][$i])));
}

$productsByCategory = [];
for ($i = 0; $i < count($productInfo); $i++) {
    if (!array_key_exists($productInfo[$i]['category'], $productsByCategory)) {
        $newProduct = array(
            'product' => $productInfo[$i]['product'],
            'price' => $productInfo[$i]['price'],
            'currency' => $productInfo[$i]['currency']
        );
        $productsByCategory[$productInfo[$i]['category']] = array($newProduct);
    } else {
        $newProduct = array(
            'product' => $productInfo[$i]['product'],
            'price' => $productInfo[$i]['price'],
            'currency' => $productInfo[$i]['currency']
        );
        $productsByCategory[$productInfo[$i]['category']][] = $newProduct;
    }
}

ksort($productsByCategory);
foreach ($productsByCategory as $key => $value) {
    usort($value, function($a, $b) {
        return strcmp($a['product'], $b['product']);
    });
    $productsByCategory[$key] = $value;
}

echo json_encode($productsByCategory);

?>