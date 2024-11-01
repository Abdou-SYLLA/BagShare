<?php
header('Content-Type: application/json');

$xml = simplexml_load_file('../../public/data/IMGViewer.xml');
$images = [];

foreach ($xml->image as $image) {
    $images[] = [
        'src' => (string) $image['src'],
        'alt' => (string) $image['alt']
    ];
}

echo json_encode($images);
?>
