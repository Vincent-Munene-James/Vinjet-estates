<?php
session_start();
require_once './config/database.php';

// Check if form was submitted
if($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: login.php");
    exit;
}

// Get form data
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate inputs
if(empty($email) || empty($password)) {
    header("Location: login.php?error=required");
    exit;
}

// Check tenants table first
$stmt = $conn->prepare("SELECT tenant_id, full_name, email, password, 'tenant' as role FROM tenants WHERE email = ?");

if(!$stmt) {
    header("Location: login.php?error=Database error");
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = null;
$role = null;

if($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $role = 'tenant';
}
$stmt->close();

// If not a tenant, check agents table
if(!$user) {
    $stmt = $conn->prepare("SELECT agent_id, full_name, email, password, 'agent' as role FROM agents WHERE email = ?");
    
    if(!$stmt) {
        header("Location: login.php?error=Database error");
        exit;
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $role = 'agent';
    }
    $stmt->close();
}

// If not an agent, check owners table
if(!$user) {
    $stmt = $conn->prepare("SELECT owner_id, full_name, email, password, 'owner' as role FROM owners WHERE email = ?");
    
    if(!$stmt) {
        header("Location: login.php?error=Database error");
        exit;
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $role = 'owner';
    }
    $stmt->close();
}

// User not found in any table
if(!$user) {
    header("Location: login.php?error=invalid");
    exit;
}

// Verify password
if(password_verify($password, $user['password']) || $password === $user['password']) {
    // Login successful - set session variables
    $_SESSION['user_id'] = $user['tenant_id'] ?? $user['agent_id'] ?? $user['owner_id'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role'] = $role;
    $_SESSION['logged_in'] = true;

    // Redirect based on role
    switch($role) {
        case 'tenant':
            $_SESSION['tenant_id'] = $user['tenant_id'];
            $_SESSION['tenant_name'] = $user['full_name'];
            $_SESSION['tenant_email'] = $user['email'];
            header("Location: tenant-dashboard.php");
            break;
        case 'agent':
            $_SESSION['agent_id'] = $user['agent_id'];
            $_SESSION['agent_name'] = $user['full_name'];
            $_SESSION['agent_email'] = $user['email'];
            header("Location: agent-dashboard.php");
            break;
        case 'owner':
            $_SESSION['owner_id'] = $user['owner_id'];
            $_SESSION['owner_name'] = $user['full_name'];
            $_SESSION['owner_email'] = $user['email'];
            header("Location: owner-dashboard.php");
            break;
        default:
            header("Location: index.php");
    }
    exit;
} else {
    // Invalid password
    header("Location: login.php?error=invalid");
    exit;
}
?>
