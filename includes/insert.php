<?php
require_once 'db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': 
        $stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
        echo json_encode($stmt->fetchAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        $sql = "INSERT INTO students (name, surname, middlename, address, contact_number)
                VALUES (:name, :surname, :middlename, :address, :contact)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':surname' => $data['surname'],
            ':middlename' => $data['middlename'],
            ':address' => $data['address'],
            ':contact' => $data['contact']
        ]);

        echo json_encode(["status" => "success"]);
        break;

    case 'PUT': 
        $data = json_decode(file_get_contents("php://input"), true);

        $sql = "UPDATE students SET name=?, surname=?, middlename=?, address=?, contact_number=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['surname'],
            $data['middlename'],
            $data['address'],
            $data['contact'],
            $data['id']
        ]);

        echo json_encode(["status" => "updated"]);
        break;

    case 'DELETE': 
        parse_str($_SERVER['QUERY_STRING'], $params);

        $stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
        $stmt->execute([$params['id']]);

        echo json_encode(["status" => "deleted"]);
        break;
}