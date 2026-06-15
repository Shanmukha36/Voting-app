<?php
$file = 'votes.txt';

// Initialize the text file on the EFS drive if it doesn't exist
if (!file_exists($file)) {
    file_put_contents($file, "Apple:0\nSamsung:0\nXiaomi:0\nMoto:0\nBBK:0");
}

// Handle the voting actions
if (isset($_POST['vote'])) {
    $current = file_get_contents($file);
    
    // Parse current votes
    preg_match('/Apple:(\d+)/', $current, $apple_m);
    preg_match('/Samsung:(\d+)/', $current, $samsung_m);
    preg_match('/Xiaomi:(\d+)/', $current, $xiaomi_m);
    preg_match('/Moto:(\d+)/', $current, $moto_m);
    preg_match('/BBK:(\d+)/', $current, $bbk_m);
    
    $votes = [
        'Apple' => $apple_m[1] ?? 0,
        'Samsung' => $samsung_m[1] ?? 0,
        'Xiaomi' => $xiaomi_m[1] ?? 0,
        'Moto' => $moto_m[1] ?? 0,
        'BBK' => $bbk_m[1] ?? 0
    ];
    
    $choice = $_POST['vote'];
    if (array_key_exists($choice, $votes)) {
        $votes[$choice]++;
    }
    
    // Save updated votes back to the EFS drive
    $new_content = "Apple:{$votes['Apple']}\nSamsung:{$votes['Samsung']}\nXiaomi:{$votes['Xiaomi']}\nMoto:{$votes['Moto']}\nBBK:{$votes['BBK']}";
    file_put_contents($file, $new_content);
    
    // Refresh page to prevent duplicate form submissions
    header("Location: index.php");
    exit;
}

// Read current votes for the HTML display
$current = file_get_contents($file);
preg_match('/Apple:(\d+)/', $current, $apple_m);
preg_match('/Samsung:(\d+)/', $current, $samsung_m);
preg_match('/Xiaomi:(\d+)/', $current, $xiaomi_m);
preg_match('/Moto:(\d+)/', $current, $moto_m);
preg_match('/BBK:(\d+)/', $current, $bbk_m);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartphone Brand War</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; text-align: center; background-color: #f0f2f5; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { color: #333; font-size: 24px; margin-bottom: 20px; }
        .vote-btn { display: block; width: 100%; font-size: 18px; padding: 15px; margin: 10px 0; cursor: pointer; border: none; border-radius: 8px; color: white; font-weight: bold; transition: opacity 0.2s; }
        .vote-btn:active { opacity: 0.8; }
        
        /* Brand Colors */
        .apple { background-color: #000000; }
        .samsung { background-color: #1428A0; }
        .xiaomi { background-color: #FF6900; }
        .moto { background-color: #000000; border: 2px solid #333; }
        .bbk { background-color: #0055FF; }

        .server-info { margin-top: 30px; font-size: 12px; color: #666; padding: 10px; background: #f8f9fa; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Vote for the Best Phone Brand!</h1>
        <form method="post">
            <button type="submit" name="vote" value="Apple" class="vote-btn apple">Apple (<?php echo $apple_m[1] ?? 0; ?>)</button>
            <button type="submit" name="vote" value="Samsung" class="vote-btn samsung">Samsung (<?php echo $samsung_m[1] ?? 0; ?>)</button>
            <button type="submit" name="vote" value="Xiaomi" class="vote-btn xiaomi">Xiaomi (<?php echo $xiaomi_m[1] ?? 0; ?>)</button>
            <button type="submit" name="vote" value="Moto" class="vote-btn moto">Motorola (<?php echo $moto_m[1] ?? 0; ?>)</button>
            <button type="submit" name="vote" value="BBK" class="vote-btn bbk">BBK Electronics (<?php echo $bbk_m[1] ?? 0; ?>)</button>
        </form>
        
        <div class="server-info">
            Server Handling Request: <br><b><?php echo gethostname(); ?></b>
        </div>
    </div>
</body>
</html>