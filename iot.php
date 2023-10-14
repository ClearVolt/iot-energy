<?php

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=my_database', 'root', '');

// Get the data from the IoT device
$data = json_decode(file_get_contents('http://example.com/api/iot-data'));

// Insert the data into the database
$sql = 'INSERT INTO iot_data (energy, iot, timestamp) VALUES (:energy, :iot, :timestamp)';
$stmt = $db->prepare($sql);
$stmt->bindParam(':energy', $data->temperature);
$stmt->bindParam(':iot', $data->humidity);
$stmt->bindParam(':timestamp', $data->timestamp);
$stmt->execute();

// Get the latest data from the database
$sql = 'SELECT * FROM iot_data ORDER BY timestamp DESC LIMIT 1';
$stmt = $db->prepare($sql);
$stmt->execute();
$latestData = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IoT Dashboard</title>
</head>
<body>

<h1>IoT Dashboard</h1>

<div class="row">
    <div class="col-sm-6">
        <h4>energy</h4>
        <p><?php echo $latestData['energy']; ?> edsa data</p>
    </div>
    <div class="col-sm-6">
        <h4>iot</h4>
        <p><?php echo $latestData['iot']; ?>%</p>
    </div>
</div>

</body>
</html>
