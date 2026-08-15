<?php
/**
 * Installer v5 - No shell commands needed
 */
$dir = __DIR__;
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

$msg = '';
$success = false;

if ($step == 2) {
    // Check vendor exists
    $success = is_dir($dir.'/vendor');
    $msg = $success ? "Vendor directory found!" : "vendor/ missing - re-upload the ZIP";
}

if ($step == 3) {
    // Check .env exists and APP_KEY
    $envExists = file_exists($dir.'/.env');
    $envContent = $envExists ? file_get_contents($dir.'/.env') : '';
    $hasKey = strpos($envContent, 'APP_KEY=base64:') !== false;
    
    if (!$envExists) {
        $msg = ".env file missing!";
    } elseif (!$hasKey) {
        // Generate key manually
        $key = 'base64:'.base64_encode(random_bytes(32));
        $envContent = str_replace('APP_KEY=', "APP_KEY=$key", $envContent);
        file_put_contents($dir.'/.env', $envContent);
        $msg = "APP_KEY generated!";
        $success = true;
    } else {
        $msg = "APP_KEY already set.";
        $success = true;
    }
}

if ($step == 4) {
    $success = true;
    $msg = "Ready! Visit your site.";
}
?>
<!DOCTYPE html>
<html>
<head><title>Installer</title></head>
<body style="font-family:Arial;max-width:700px;margin:20px auto;padding:20px;">
<h1>Water Supply Chain - Installer</h1>

<?php if ($step == 1): ?>
    <p>All dependencies are pre-installed. Just a few setup steps.</p>
    <a href="?step=2" style="background:#4CAF50;color:white;padding:10px 20px;text-decoration:none;">START SETUP</a>

<?php else: ?>
    <h2>Step <?= $step ?> of 4</h2>
    <pre style="background:#f5f5f5;padding:10px;"><?= htmlspecialchars($msg) ?></pre>

    <?php if ($step == 2): ?>
        <?= $success 
            ? '<a href="?step=3" style="background:#4CAF50;color:white;padding:10px 20px;text-decoration:none;">Next: Generate Key</a>' 
            : '<p style="color:red;">Upload the full ZIP again.</p>' ?>
    
    <?php elseif ($step == 3): ?>
        <?= $success 
            ? '<a href="?step=4" style="background:#4CAF50;color:white;padding:10px 20px;text-decoration:none;">Next: Finish</a>' 
            : '<p style="color:red;">Check .env file.</p>' ?>
    
    <?php elseif ($step == 4): ?>
        <h2 style="color:green;">SETUP COMPLETE!</h2>
        <a href="/" style="background:#4CAF50;color:white;padding:15px 30px;text-decoration:none;font-size:18px;">VISIT YOUR WEBSITE</a>
        <br><br>
        <p><strong>IMPORTANT:</strong> Delete install.php now!</p>
        <p>File Manager → htdocs → install.php → Delete</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
