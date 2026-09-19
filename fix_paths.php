<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$guides = \App\Models\IhramGuide::all();
foreach ($guides as $guide) {
    $cleanPath = preg_replace("#^storage/storage/#", "storage/", $guide->image);
    $cleanPath = str_replace(["'", '"'], '', $cleanPath);
    $guide->update(['image' => $cleanPath]);
    echo "Updated: {$guide->title_en} => {$cleanPath}\n";
}
echo "Done!";
