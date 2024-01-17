<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION['random_string'])) {
        $_SESSION['random_string'] = bin2hex(random_bytes(10)); // Generate a random string.
    }

    $randomString = $_SESSION['random_string'];
    echo '<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($randomString) . '" alt="QR Code" />';
    ?>
</body>
</html>