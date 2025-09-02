<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $whatsapp = filter_var($_POST['whatsapp'], FILTER_SANITIZE_URL);
    $telegram = filter_var($_POST['telegram'], FILTER_SANITIZE_URL);

    $configContent = "<?php\nreturn [\n" .
        "    'whatsapp' => '" . addslashes($whatsapp) . "',\n" .
        "    'telegram' => '" . addslashes($telegram) . "',\n" .
        "];\n";

    file_put_contents(__DIR__ . '/config/social_links.php', $configContent);

    header("Location: dashboard.php?updated=1");
    exit;
}
