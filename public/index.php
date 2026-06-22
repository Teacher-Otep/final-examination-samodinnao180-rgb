<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Management System</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<nav class="navbar">
    <img src="logo.jpeg" id="logo" onclick="showHome()">

    <button onclick="showSection('create')">Create</button>
    <button onclick="loadStudents()">Read</button>
    <button onclick="loadStudents()">Update</button>
    <button onclick="loadStudents()">Delete</button>
</nav>


<section id="home" class="homecontent">
    <h1>Welcome to Student Management System</h1>
    <h2>A Project in Integrative Programming Technologies</h2>
</section>


<section id="create" class="content">
    <h2>Add Student</h2>

    <div class="form-group">
        <input id="surname" placeholder="Surname">
        <input id="name" placeholder="Name">
        <input id="middlename" placeholder="Middle Name">
        <input id="address" placeholder="Address">
        <input id="contact" placeholder="Contact">
    </div>

    <button onclick="addStudent()">Save</button>
</section>


<section id="read" class="content">
    <h2>Student Records</h2>

    <table id="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</section>

</div>

<script src="script.js"></script>
</body>
</html>