<?php
function filterText($text) {
    $prohibited = [
        '/\b(dumbass|stupid)\b/ui',
        '/\b(autist|retard)\b/ui',
        '/\b(i will find you|kill yourself)\b/ui',
        '/(\b(https?:\/\/|www\.)[^\s]+)\b/ui'
    ];

    foreach ($prohibited as $p) {
        $text = preg_replace($p, 'CENSORED', $text);
    }

    return $text;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $message = $_POST['message'];

    $filteredMessage = filterText($message);

    $fileName = $login . '_' . date('Y-m-d_H-i-s') . '.txt';

    file_put_contents($fileName, $filteredMessage);

    $resultMessage = $filteredMessage;
} else {
    $resultMessage = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter</title>
</head>
<body>
<form method="post">
    <label for="login">Login:</label><br>
    <input type="text" id="login" name="login" required><br><br>

    <label for="message">Message:</label><br>
    <textarea id="message" name="message" rows="5" cols="30" required></textarea><br><br>

    <button type="submit">Send</button>
</form>

<?php if (!empty($resultMessage)): ?>
    <h2>Filter result:</h2><br>
    <p><?php echo $resultMessage ?></p><br>
<?php endif; ?>
</body>
</html>