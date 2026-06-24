<?php
require_once __DIR__ . '/includes/db.php';
$form_action = 'includes/insert.php';

// UPDATE Logic
if (isset($_POST['update'])) {
    $id = $_POST['id']; 
    $n = $_POST['name']; 
    $s = $_POST['surname']; 
    $m = $_POST['middlename'];
    
    try {
        $stmt = $pdo->prepare("UPDATE students SET name = :name, surname = :surname, middlename = :middlename WHERE id = :id");
        $stmt->execute([
            ':name'       => $n,
            ':surname'    => $s,
            ':middlename' => $m,
            ':id'         => $id
        ]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Update Error: " . $e->getMessage());
    }
}

// DELETE Logic
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
    <title>Pop Hub Hub</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Mega&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <span class="logo" onclick="hideContent()">STUDENT.EXE</span>
            <div class="nav-links">
                <button class="nav-btn" onclick="showSection('create')">ADD +</button>
                <button class="nav-btn" onclick="showSection('read')">VIEW</button>
                <button class="nav-btn" onclick="showSection('update')">EDIT</button>
                <button class="nav-btn" onclick="showSection('delete')">DROP</button>
            </div>
        </div>
    </nav>

    <main class="main-container">
        <section id="home" class="homecontent"> 
            <h1 class="splash">MANAGEMENT POP!</h1>
            <p>High-contrast database engine loaded. Structural records clean.</p>
        </section>
        
        <section id="create" class="content card" style="display:none;">
            <h2 class="contenttitle">Open New File Entry</h2>
            <form action="<?php echo $form_action; ?>" method="POST" class="form-grid">
                <div class="input-group"><label>Surname</label><input type="text" name="surname" required></div>
                <div class="input-group"><label>Name</label><input type="text" name="name" required></div>
                <div class="input-group"><label>Middle Name</label><input type="text" name="middlename"></div>
                <div class="input-group"><label>Address</label><input type="text" name="address"></div>
                <div class="input-group"><label>Contact</label><input type="text" name="contact"></div>
                <div class="btn-row">
                    <button type="button" class="btn-sec" onclick="clearFields()">Clear</button>
                    <button type="submit" name="save" class="btn-pri">Save to Disk</button>
                </div>
            </form>   
        </section>

        <section id="read" class="content card" style="display:none;">
            <h2 class="contenttitle">Current System Records</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr><th>ID</th><th>Surname</th><th>Name</th><th>Middle Name</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $pdo->query("SELECT * FROM students");
                            while($row = $stmt->fetch()) {
                                echo "<tr><td>{$row['id']}</td><td>{$row['surname']}</td><td>{$row['name']}</td><td>{$row['middlename']}</td></tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='4'>Failed Reading: " . $e->getMessage() . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="update" class="content card" style="display:none;">
            <h2 class="contenttitle">Alter Existing Values</h2>
            <form method="POST" class="form-grid">
                <div class="input-group"><label>Target Row ID</label><input type="number" name="id" required></div>
                <div class="input-group"><label>New Surname</label><input type="text" name="surname"></div>
                <div class="input-group"><label>New Name</label><input type="text" name="name"></div>
                <div class="input-group"><label>New Middle</label><input type="text" name="middlename"></div>
                <button type="submit" name="update" class="btn-pri full-width">UPDATE VALUES</button>
            </form>
        </section>

        <section id="delete" class="content card" style="display:none;">
            <h2 class="contenttitle">Destruction Row</h2>
            <div class="delete-list">
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM students");
                    while($row = $stmt->fetch()) {
                        echo "<div class='delete-item'>
                                <span>{$row['name']} {$row['surname']}</span>
                                <a href='index.php?delete={$row['id']}' class='btn-del'>REMOVE</a>
                              </div>";
                    }
                } catch (PDOException $e) {
                    echo "<div>Error: " . $e->getMessage() . "</div>";
                }
                ?>
            </div>
        </section>
    </main>

    <div id="success-toast" class="toast">DISK UPDATE SUCCESSFUL</div>
    <script src="script.js"></script>
</body>
</html>
