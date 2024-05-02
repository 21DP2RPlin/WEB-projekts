<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Data Entry Form</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .data-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 50px;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .input-group label {
            flex: 1;
        }

        .input-group select, .input-group input {
            flex: 2;
            margin-right: 10px;
            padding: 5px;
        }

        .input-group button {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <ul id="navbar">
        <li><a href="index.html">Home</a></li>
        <li><a href="contactinfo.html">Kontaktinformācija</a></li>
        <li><a href="ParVietni.html">Par vietni</a></li>
        <li><a href="Map.html">Laukumu karte</a></li>
        <li><a href="login.php">Rediģet</a></li>
    </ul>

    <?php
    // Database connection setup
    $servername = "localhost"; // or your database host
    $username = "root"; // your database username
    $password = "Bobrkurwa1488+"; // your database password
    $database = "noslegumadarbs"; // your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $selectedId = $_POST['id'] ?? '';
    $adrese = '';
    $apraksts = '';
    $pilseta = '';
    $rajons = '';
    $izmers = '';

    // Handling form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
        $id = $_POST['id'];
        $adrese = $_POST['adrese'];
        $apraksts = $_POST['apraksts'];
        $pilseta = $_POST['pilseta'];
        $rajons = $_POST['rajons'];
        $izmers = $_POST['izmers'];

        // Update or insert record
        $stmt = $conn->prepare("INSERT INTO laukumi (ID, adrese, apraksts, pilseta, rajons, izmers) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE adrese = VALUES(adrese), apraksts = VALUES(apraksts), pilseta = VALUES(pilseta), rajons = VALUES(rajons), izmers = VALUES(izmers)");
        $stmt->bind_param("isssss", $id, $adrese, $apraksts, $pilseta, $rajons, $izmers);
        $stmt->execute();

        echo "<p>Saved successfully</p>";
    }

    // Fetch existing data
    if (!empty($selectedId)) {
        $stmt = $conn->prepare("SELECT * FROM laukumi WHERE ID = ?");
        $stmt->bind_param("i", $selectedId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $adrese = $row['adrese'];
            $apraksts = $row['apraksts'];
           
            $stmtPilseta = $conn->prepare("SELECT nosaukums FROM pilseta WHERE ID = ?");
            $stmtPilseta->bind_param("i", $row['pilseta']);
            $stmtPilseta->execute();
            $resultPilseta = $stmtPilseta->get_result();
            $rowPilseta = $resultPilseta->fetch_assoc();
            $pilseta = $rowPilseta ? $rowPilseta['nosaukums'] : '';


            $stmtRajons = $conn->prepare("SELECT nosaukums FROM rajoni WHERE ID = ?");
            $stmtRajons->bind_param("i", $row['rajons']);
            $stmtRajons->execute();
            $resultRajons = $stmtRajons->get_result();
            $rowRajons = $resultRajons->fetch_assoc();
            $rajons = $rowRajons ? $rowRajons['nosaukums'] : '';


            $stmtIzmers = $conn->prepare("SELECT izmers FROM laukumu_izmers WHERE ID = ?");
            $stmtIzmers->bind_param("i", $row['izmers']);
            $stmtIzmers->execute();
            $resultIzmers = $stmtIzmers->get_result();
            $rowIzmers = $resultIzmers->fetch_assoc();
            $izmers = $rowIzmers ? $rowIzmers['izmers'] : '';
        }
    }

    // Fetch options for select
    function fetchOptions($conn, $column) {
        $sql = "SELECT DISTINCT $column FROM laukumi";
        $result = $conn->query($sql);
        $options = [];
        while ($row = $result->fetch_assoc()) {
            $options[] = $row[$column];
        }
        return $options;
    }
    ?>

    <div class="data-container">
        <form method="post">
            <div class="input-group">
                <label for="id">ID</label>
                <select name="id" onchange="this.form.submit()">
                    <option value="">Select ID</option>
                    <?php
                    $ids = fetchOptions($conn, 'ID');
                    foreach ($ids as $option) {
                        echo "<option" . ($option == $selectedId ? " selected" : "") . ">$option</option>";
                    }
                    ?>
                </select>
                <button type="submit" name="new">New</button> <!-- Added the "New" button -->

                <?php
                // Get the next available ID
                function getNextID($conn) {
                    $stmt = $conn->prepare("SELECT MAX(ID) AS max_id FROM laukumi");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    return $row['max_id'] + 1; // Increment the highest ID by 1
                }

                // Handling form submission for selecting an existing ID or creating a new one
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['new'])) {
                        // Get the next available ID
                        $selectedId = getNextID($conn);

                        // Insert the new row with the determined ID
                        $stmt = $conn->prepare("INSERT INTO laukumi (ID) VALUES (?)");
                        $stmt->bind_param("i", $selectedId);
                        $stmt->execute();

                        echo "<p>New row created with ID: $selectedId</p>";
                    }
                }
                ?>

            </div>
            <div class="input-group">
                <label for="pilseta">Pilseta</label>
                <select name="pilseta">
                    <?php
                    $stmtPilsetaAll = $conn->prepare("SELECT ID, nosaukums FROM pilseta");
                    $stmtPilsetaAll->execute();
                    $resultPilsetaAll = $stmtPilsetaAll->get_result();
                    while ($rowPilsetaAll = $resultPilsetaAll->fetch_assoc()) {
                        $selected = ($rowPilsetaAll['nosaukums'] == $pilseta) ? "selected" : "";
                        echo "<option value='" . $rowPilsetaAll['ID'] . "' $selected>" . $rowPilsetaAll['nosaukums'] . "</option>";
                    }
                    ?>
                </select>
                <button type="button" onclick="clearField('pilseta')">Clear</button>
            </div>
            <div class="input-group">
                <label for="rajons">Rajons</label>
                <select name="rajons">
                    <?php
                    $stmtRajonsAll = $conn->prepare("SELECT ID, nosaukums FROM rajoni");
                    $stmtRajonsAll->execute();
                    $resultRajonsAll = $stmtRajonsAll->get_result();
                    while ($rowRajonsAll = $resultRajonsAll->fetch_assoc()) {
                        $selected = ($rowRajonsAll['nosaukums'] == $rajons) ? "selected" : "";
                        echo "<option value='" . $rowRajonsAll['ID'] . "' $selected>" . $rowRajonsAll['nosaukums'] . "</option>";
                    }
                    ?>
                </select>
                <button type="button" onclick="clearField('rajons')">Clear</button>
            </div>
            <div class="input-group">
                <label for="adrese">Adrese</label>
                <input type="text" name="adrese" value="<?php echo htmlspecialchars($adrese ?? ''); ?>">
                <button type="button" onclick="clearField('adrese')">Clear</button>
            </div>
            <div class="input-group">
                <label for="izmers">Izmers</label>
                <select name="izmers">
                    <?php
                    $stmtIzmersAll = $conn->prepare("SELECT ID, izmers FROM laukumu_izmers");
                    $stmtIzmersAll->execute();
                    $resultIzmersAll = $stmtIzmersAll->get_result();
                    while ($rowIzmersAll = $resultIzmersAll->fetch_assoc()) {
                        $selected = ($rowIzmersAll['izmers'] == $izmers) ? "selected" : "";
                        echo "<option value='" . $rowIzmersAll['ID'] . "' $selected>" . $rowIzmersAll['izmers'] . "</option>";
                    }
                    ?>
                </select>
                <button type="button" onclick="clearField('izmers')">Clear</button>
            </div>
            <div class="input-group">
                <label for="apraksts">Apraksts</label>
                <input type="text" name="apraksts" value="<?php echo htmlspecialchars($apraksts ?? ''); ?>">
                <button type="button" onclick="clearField('apraksts')">Clear</button>
            </div>
            <div class="input-group">
                <button type="submit" name="save">Save</button>
                <button type="button" onclick="window.location.href='index.html'">Continue</button>
            </div>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                echo "<p>Saved successfully</p>";
            } ?>
        </form>
    </div>
    <script>
        function clearField(fieldId) {
            document.getElementsByName(fieldId)[0].value = "";
        }
    </script>
</body>
</html>