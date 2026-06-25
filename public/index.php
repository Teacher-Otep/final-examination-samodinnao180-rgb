<?php
if (file_exists(__DIR__ . '/../includes/db.php')) {
    require_once __DIR__ . '/../includes/db.php';
    $form_action = '../includes/insert.php';
} else {
    require_once __DIR__ . '/includes/db.php';
    $form_action = 'includes/insert.php';
}

if (isset($_POST['update'])) {
    $id = $_POST['id']; 
    $n = $_POST['name']; 
    $s = $_POST['surname']; 
    $m = $_POST['middlename'];
    
    try {
        $stmt = $pdo->prepare("UPDATE students SET name = :name, surname = :surname, middlename = :middlename WHERE id = :id");
        $stmt->execute([':name' => $n, ':surname' => $s, ':middlename' => $m, ':id' => $id]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Update Error: " . $e->getMessage());
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
        $stmt->execute([':id' => $id]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Delete Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CyberTerminal v1.0</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <span class="logo" onclick="hideContent()">//SYS_CORE</span>
            <div class="nav-links">
                <button class="nav-btn" onclick="showSection('create')">CREATE</button>
                <button class="nav-btn" onclick="showSection('read')">READ</button>
                <button class="nav-btn" onclick="showSection('update')">UPDATE</button>
                <button class="nav-btn" onclick="showSection('delete')">DELETE</button>
            </div>
        </div>
    </nav>

    <main class="main-container">
        <section id="home" class="homecontent"> 
            <h1 class="splash">TERMINAL INTERFACE</h1>
            <p>System operational. Clean registry database verified.</p>
        </section>
        
        <section id="create" class="content card" style="display:none;">
            <h2 class="contenttitle">> REGISTER NEW DATA RECORD</h2>
            <form action="<?php echo $form_action; ?>" method="POST" class="form-grid">
                <div class="input-group"><label>Surname</label><input type="text" name="surname" required></div>
                <div class="input-group"><label>Name</label><input type="text" name="name" required></div>
                <div class="input-group"><label>Middle Name</label><input type="text" name="middlename"></div>
                <div class="input-group"><label>Address</label><input type="text" name="address"></div>
                <div class="input-group"><label>Contact</label><input type="text" name="contact"></div>
                <div class="btn-row">
                    <button type="button" class="btn-sec" onclick="clearFields()">WIPE FIELDS</button>
                    <button type="submit" name="save" class="btn-pri">COMMIT TO DATABASE</button>
                </div>
            </form>   
        </section>

        <section id="read" class="content card" style="display:none;">
            <h2 class="contenttitle">> RETRIEVED STUDENT MAP</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr><th>ID</th><th>Surname</th><th>Name</th><th>Middle Name</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM students");
                        while($row = $stmt->fetch()) {
                            echo "<tr><td>{$row['id']}</td><td>{$row['surname']}</td><td>{$row['name']}</td><td>{$row['middlename']}</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="update" class="content card" style="display:none;">
            <h2 class="contenttitle">> OVERWRITE RECORD DATA</h2>
            <form method="POST" class="form-grid">
                <div class="input-group"><label>Target Row ID</label><input type="number" name="id" required></div>
                <div class="input-group"><label>New Surname</label><input type="text" name="surname"></div>
                <div class="input-group"><label>New Name</label><input type="text" name="name"></div>
                <div class="input-group"><label>New Middle</label><input type="text" name="middlename"></div>
                <button type="submit" name="update" class="btn-pri full-width">EXECUTE TRANSITION</button>
            </form>
        </section>

        <section id="delete" class="content card" style="display:none;">
            <h2 class="contenttitle">> PURGE DATA MATRIX</h2>
            <div class="delete-list">
                <?php
                $stmt = $pdo->query("SELECT * FROM students");
                while($row = $stmt->fetch()) {
                    echo "<div class='delete-item'>
                            <span>{$row['name']} {$row['surname']}</span>
                            <a href='index.php?delete={$row['id']}' class='btn-del'>PURGE</a>
                          </div>";
                }
                ?>
            </div>
        </section>
    </main>
    <div id="success-toast" class="toast">ENTRY BROADCAST SUCCESSFUL</div>
    <script src="script.js"></script>
</body>
</html>
