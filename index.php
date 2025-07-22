<?php
$keyFile = 'key.txt';
$key = '';

if (file_exists($keyFile)) {
    $key = trim(file_get_contents($keyFile));
}

if (!empty($key)) {
    $redirectUrl = "https://generateed.pages.dev/?key=" . urlencode($key);
} else {
    die("No key found in key.txt");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting...</title>
    <meta http-equiv="refresh" content="1;url=<?php echo htmlspecialchars($redirectUrl); ?>">
    <style>
        body {
            margin: 0;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .message {
            text-align: center;
            font-size: 1.8em;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="message">
        Key Generated Successfully...<br>Redirecting...
    </div>
</body>
</html>
