<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Property Details</title>
<link rel="stylesheet" href="../../style.css">
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
    }
    .laukumu_container {
        width: 80%;
        margin: 0 auto;
        padding-top: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .property-image {
        text-align: center;
        padding-top: 20px;
    }
    .property-details {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 20px;
        border-bottom: 1px solid #ccc;
    }
    .property-details .row {
        width: 45%;
        padding-bottom: 10px;
    }
    .property-details .row .label {
        font-weight: bold;
        font-size: 23px
    }
    .property-details .row .info {
        color: #666;
        font-size: 20px;
    }
    .map-container {
        text-align: center;
        padding: 20px;
    }
    iframe {
        width: 100%;
        height: 400px;
        border: none;
    }
</style>
</head>
<body>
    <ul id="navbar">
        <li><a href="../../index.html">Home</a></li>
        <li><a href="../../contactinfo.html">Kontaktinformācija</a></li>
        <li><a href="../../ParVietni.html">Par vietni</a></li>
        <li><a href="../../Map.html">Laukumu karte</a></li>
        <li><a href="../../login.php">Rediģet</a></li>
    </ul>
    <div class="laukumu_container">
        <div class="property-image">
            <img src="Brasa1_2.jpg" alt="Property Image" width="700" height="500">
        </div>
        <div class="property-details">
            <?php
            $servername = "localhost"; // or your database host
            $username = "root"; // your database username
            $password = "Bobrkurwa1488+"; // your database password
            $database = "noslegumadarbs"; // your database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $specificID = 3; // Change this to the specific ID you want to display

            $sql = "SELECT l.id, p.nosaukums AS pilseta, r.nosaukums AS rajons, l.adrese, li.izmers, l.apraksts
                    FROM laukumi l
                    JOIN pilseta p ON l.pilseta = p.id
                    JOIN rajoni r ON l.rajons = r.id
                    JOIN laukumu_izmers li ON l.izmers = li.id
                    WHERE l.id = $specificID";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='row'>";
                    echo "<div class='label'>ID:</div>";
                    echo "<div class='info'>" . $row['id'] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='label'>Adress:</div>";
                    echo "<div class='info'>" . $row['adrese'] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='label'>Pilseta:</div>";
                    echo "<div class='info'>" . $row['pilseta'] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='label'>Rajons:</div>";
                    echo "<div class='info'>" . $row['rajons'] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='label'>Izmērs:</div>";
                    echo "<div class='info'>" . $row['izmers'] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='label'>Apraksts:</div>";
                    echo "<div class='info'>" . $row['apraksts'] . "</div>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d914.1907215078327!2d24.142803258652798!3d56.977507513366476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46eecf7ad4ccaf6f%3A0x167c668e8303e827!2s%C4%80ra%20vingro%C5%A1anas%20laukums!5e0!3m2!1sru!2slv!4v1697360353205!5m2!1sru!2slv" allowfullscreen></iframe>
        </div>
    </div>
</body>
</html>
