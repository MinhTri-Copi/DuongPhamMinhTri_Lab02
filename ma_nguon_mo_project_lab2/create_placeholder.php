<?php
// Kiểm tra thư mục public/images
$dir = 'public/images';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
    echo "Đã tạo thư mục $dir <br>";
} else {
    echo "Thư mục $dir đã tồn tại <br>";
}

// Kiểm tra file no-image.png
$file = $dir . '/no-image.png';
if (!file_exists($file)) {
    // Tạo hình ảnh 200x200 với màu xám
    $image = imagecreatetruecolor(200, 200);
    $bg = imagecolorallocate($image, 240, 240, 240);
    $text_color = imagecolorallocate($image, 100, 100, 100);
    
    // Tô màu nền
    imagefilledrectangle($image, 0, 0, 200, 200, $bg);
    
    // Viết chữ "No Image"
    imagestring($image, 5, 50, 90, "No Image", $text_color);
    
    // Lưu hình ảnh
    imagepng($image, $file);
    imagedestroy($image);
    
    echo "Đã tạo file $file <br>";
} else {
    echo "File $file đã tồn tại <br>";
}

echo "Hoàn tất!";
?> 