<?php
include 'config.php';
$apiKey = '1234'; // Set your API key here

function getApiKeyFromHeaders() {
    $headers = getallheaders();
    return isset($headers['API_KEY']) ? $headers['API_KEY'] : null;
}

if (getApiKeyFromHeaders() != $apiKey) {
    header('HTTP/1.0 403 Forbidden');
    echo json_encode(["message" => "Forbidden"]);
    exit;
}

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        getUsers();
        break;
    case 'POST':
        addUser($input);
        break;
    case 'PUT':
        updateUser($input);
        break;
    case 'DELETE':
        deleteUser($input);
        break;
    default:
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

function getUsers() {
    global $conn;
    $result = $conn->query("SELECT * FROM test_api");
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
}

function addUser($data) {
    global $conn;
    $name = $conn->real_escape_string($data['name']);
    $email = $conn->real_escape_string($data['email']);
    $conn->query("INSERT INTO test_api (name, email) VALUES ('$name', '$email')");
    echo json_encode(["message" => "User added"]);
}

function updateUser($data) {
    global $conn;
    $id = $conn->real_escape_string($data['id']);
    $name = $conn->real_escape_string($data['name']);
    $email = $conn->real_escape_string($data['email']);
    $conn->query("UPDATE test_api SET name='$name', email='$email' WHERE id=$id");
    echo json_encode(["message" => "User updated"]);
}

function deleteUser($data) {
    global $conn;
    $id = $conn->real_escape_string($data['id']);
    $conn->query("DELETE FROM test_api WHERE id=$id");
    echo json_encode(["message" => "User deleted"]);
}
?>
