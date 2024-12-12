<?php

// Enable error reporting for all errors and warnings
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load environment variables from the .env file
require_once __DIR__ . '/vendor/autoload.php';

// Create and load Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

try {
    $dotenv->load(); // Load environment variables
} catch (Exception $e) {
    die("Error loading .env file: " . $e->getMessage());
}

// Get environment variables
$dbhost = $_ENV['RDS_HOSTNAME'] ?? null;
$dbport = $_ENV['RDS_PORT'] ?? null;
$dbname = $_ENV['RDS_DB_NAME'] ?? null;
$username = $_ENV['RDS_USERNAME'] ?? null;
$password = $_ENV['RDS_PASSWORD'] ?? null;

// Create a Data Source Name (DSN) for the MySQL connection
$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset=utf8";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Log the error but don't display it
    error_log("Database connection failed: " . $e->getMessage());
    die("Could not connect to the database.");
}

// Function to fetch and update the quantity for any fruit
function updateFruitQuantity($fruitName, $action, $pdo)
{
    // Fetch current quantity
    $query = "SELECT qty FROM fruits WHERE name = :name";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':name' => $fruitName]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $qty = $row ? $row['qty'] : 0;

    // Update the quantity based on action
    if ($action === 'add' && $qty < 5) {
        $qty++;
    } elseif ($action === 'remove' && $qty > 0) {
        $qty--;
    }

    // Update the database with the new quantity
    $updateQuery = "UPDATE fruits SET qty = :qty WHERE name = :name";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute([':qty' => $qty, ':name' => $fruitName]);

    return $qty;
}

// Handle the form submissions for each fruit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_apple'])) {
        $appleQty = updateFruitQuantity('apples', 'add', $pdo);
    } elseif (isset($_POST['remove_apple'])) {
        $appleQty = updateFruitQuantity('apples', 'remove', $pdo);
    }

    if (isset($_POST['add_banana'])) {
        $bananaQty = updateFruitQuantity('bananas', 'add', $pdo);
    } elseif (isset($_POST['remove_banana'])) {
        $bananaQty = updateFruitQuantity('bananas', 'remove', $pdo);
    }

    if (isset($_POST['add_orange'])) {
        $orangeQty = updateFruitQuantity('oranges', 'add', $pdo);
    } elseif (isset($_POST['remove_orange'])) {
        $orangeQty = updateFruitQuantity('oranges', 'remove', $pdo);
    }

    if (isset($_POST['add_avocado'])) {
        $avocadoQty = updateFruitQuantity('avocados', 'add', $pdo);
    } elseif (isset($_POST['remove_avocado'])) {
        $avocadoQty = updateFruitQuantity('avocados', 'remove', $pdo);
    }
}

// Fetch the current quantities of fruits
$appleQty = updateFruitQuantity('apples', 'check', $pdo);
$bananaQty = updateFruitQuantity('bananas', 'check', $pdo);
$orangeQty = updateFruitQuantity('oranges', 'check', $pdo);
$avocadoQty = updateFruitQuantity('avocados', 'check', $pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="apple-touch-icon" sizes="57x57" href="/images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
    <link rel="manifest" href="/images/site.webmanifest">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/ms-icon-144x144.png">
    <title>LAMP Project</title>
<script>
        // Function to check max or min quantity before form submission
        function validateQuantity(fruitName, currentQty, action) {
            if (action === 'add' && currentQty >= 5) {
                alert(`Cannot add more ${fruitName}. The maximum quantity is 5.`);
                return false;
            }
            if (action === 'remove' && currentQty <= 0) {
                alert(`Cannot remove ${fruitName}. The quantity is already at 0.`);
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h1>Fruits Counter:</h1>

    <div>
        <h2>Apples: <?php echo htmlspecialchars($appleQty); ?></h2>
        <form method="POST">
            <button
                type="submit"
                name="add_apple"
                onclick="return validateQuantity('apples', <?php echo $appleQty; ?>, 'add')">Add 1 Apple</button>
            <button
                type="submit"
                name="remove_apple"
                onclick="return validateQuantity('apples', <?php echo $appleQty; ?>, 'remove')">Remove 1 Apple</button>
        </form>
    </div>

    <div>
        <h2>Bananas: <?php echo htmlspecialchars($bananaQty); ?></h2>
        <form method="POST">
            <button
                type="submit"
                name="add_banana"
                onclick="return validateQuantity('bananas', <?php echo $bananaQty; ?>, 'add')">Add 1 Banana</button>
            <button
                type="submit"
                name="remove_banana"
                onclick="return validateQuantity('bananas', <?php echo $bananaQty; ?>, 'remove')">Remove 1 Banana</button>
        </form>
    </div>

    <div>
        <h2>Oranges: <?php echo htmlspecialchars($orangeQty); ?></h2>
        <form method="POST">
            <button
                type="submit"
                name="add_orange"
                onclick="return validateQuantity('oranges', <?php echo $orangeQty; ?>, 'add')">Add 1 Orange</button>
            <button
                type="submit"
                name="remove_orange"
                onclick="return validateQuantity('oranges', <?php echo $orangeQty; ?>, 'remove')">Remove 1 Orange</button>
        </form>
    </div>

    <div>
        <h2>Avocados: <?php echo htmlspecialchars($avocadoQty); ?></h2>
        <form method="POST">
            <button
                type="submit"
                name="add_avocado"
                onclick="return validateQuantity('avocados', <?php echo $avocadoQty; ?>, 'add')">Add 1 Avocado</button>
            <button
                type="submit"
                name="remove_avocado"
                onclick="return validateQuantity('avocados', <?php echo $avocadoQty; ?>, 'remove')">Remove 1 Avocado</button>
        </form>
    </div>

</body>
</html>

