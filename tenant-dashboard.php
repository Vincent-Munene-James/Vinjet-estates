<?php
session_start();
require_once './config/database.php';

// Check if user is logged in and is a tenant
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

if($_SESSION['user_role'] !== 'tenant') {
    header("Location: login.php?error=unauthorized");
    exit;
}

$tenant_id = $_SESSION['tenant_id'];
$tenant_name = $_SESSION['tenant_name'];
$tenant_email = $_SESSION['tenant_email'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tenant Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }

        .dashboard-header {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .dashboard-header h2 {
            color: #333;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .dashboard-header p {
            color: #666;
            margin: 0;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .card-body h5 {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .card-body a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .card-body a:hover {
            background: rgba(255,255,255,0.3);
            color: white;
        }

        .bg-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
        }

        .bg-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        }

        .bg-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
        }

        .text-white {
            color: white;
        }

        .logout-btn {
            background-color: #dc3545;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .section-title {
            color: #333;
            font-weight: 700;
            margin: 2rem 0 1.5rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #0d6efd;
        }

        .property-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-left: 4px solid #0d6efd;
        }

        .property-details {
            margin: 1rem 0;
        }

        .property-details h5 {
            color: #0d6efd;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .property-details p {
            color: #666;
            margin: 0.25rem 0;
        }

        .agent-info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .agent-info h6 {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .agent-info p {
            color: #666;
            margin: 0.25rem 0;
            font-size: 0.9rem;
        }

        .no-bookings {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            color: #999;
        }

        .no-bookings i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ddd;
        }
    </style>
</head>

<body class="bg-light">

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="tenant-dashboard.php">
            <i class="fas fa-home"></i> Vinjet Estates
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link">Welcome, <?= htmlspecialchars($tenant_name) ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">

<!-- Dashboard Header -->
<div class="dashboard-header">
    <h2><i class="fas fa-tachometer-alt"></i> Tenant Dashboard</h2>
    <p>Manage your properties, bookings, and payments</p>
</div>

<!-- Quick Links Cards -->
<div class="row mt-4">

    <!-- Properties -->
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5><i class="fas fa-building"></i> Available Properties</h5>
                <p>Browse and view available properties</p>
                <a href="properties.php" class="btn btn-light btn-sm mt-2">
                    <i class="fas fa-eye"></i> View Properties
                </a>
            </div>
        </div>
    </div>

    <!-- My Bookings -->
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5><i class="fas fa-calendar-check"></i> My Bookings</h5>
                <p>View your booked properties and assignments</p>
                <a href="#my-bookings-section" class="btn btn-light btn-sm mt-2">
                    <i class="fas fa-arrow-down"></i> View Bookings
                </a>
            </div>
        </div>
    </div>

    <!-- Payments -->
    <div class="col-md-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5><i class="fas fa-credit-card"></i> Payments</h5>
                <p>Manage your rental payments and invoices</p>
                <a href="payments.php?tenant=<?= $tenant_id ?>" class="btn btn-light btn-sm mt-2">
                    <i class="fas fa-receipt"></i> View Payments
                </a>
            </div>
        </div>
    </div>

</div>

<!-- My Bookings Section -->
<div id="my-bookings-section">
    <h3 class="section-title"><i class="fas fa-calendar-check"></i> My Bookings & Assigned Properties</h3>

    <?php
    // Query to get all booked/assigned properties for the tenant
    $query = "
        SELECT 
            p.property_id,
            p.property_name,
            p.property_type,
            p.location,
            p.description,
            p.rental_price,
            p.bedrooms,
            p.bathrooms,
            p.image_url,
            a.agent_id,
            a.full_name as agent_name,
            a.email as agent_email,
            a.phone_number as agent_phone,
            tp.booking_date,
            tp.assignment_date,
            tp.status
        FROM tenant_properties tp
        JOIN properties p ON tp.property_id = p.property_id
        LEFT JOIN agents a ON p.agent_id = a.agent_id
        WHERE tp.tenant_id = ?
        ORDER BY tp.assignment_date DESC, tp.booking_date DESC
    ";

    $stmt = $conn->prepare($query);
    
    if(!$stmt) {
        echo '<div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> Database error: ' . htmlspecialchars($conn->error) . '
              </div>';
    } else {
        $stmt->bind_param("i", $tenant_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 0) {
            echo '<div class="no-bookings">
                    <i class="fas fa-inbox"></i>
                    <h5>No Bookings Yet</h5>
                    <p>You haven\'t booked any properties yet. <a href="properties.php">Browse available properties</a></p>
                  </div>';
        } else {
            // Display booked properties
            while($booking = $result->fetch_assoc()) {
                $status = $booking['status'] ?? 'pending';
                $statusBadge = '';
                
                switch($status) {
                    case 'assigned':
                        $statusBadge = '<span class="badge bg-success">Assigned</span>';
                        break;
                    case 'pending':
                        $statusBadge = '<span class="badge bg-warning">Pending</span>';
                        break;
                    case 'rejected':
                        $statusBadge = '<span class="badge bg-danger">Rejected</span>';
                        break;
                    default:
                        $statusBadge = '<span class="badge bg-secondary">Unknown</span>';
                }
                ?>
                
                <div class="property-card">
                    <div class="row">
                        <!-- Property Image -->
                        <div class="col-md-3">
                            <?php if(!empty($booking['image_url'])): ?>
                                <img src="<?= htmlspecialchars($booking['image_url']) ?>" alt="Property" class="img-fluid rounded" style="height: 200px; object-fit: cover; width: 100%;">
                            <?php else: ?>
                                <div class="bg-secondary text-white text-center rounded" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image fa-3x"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Property Details -->
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h4 style="color: #333; margin: 0;">
                                        <?= htmlspecialchars($booking['property_name']) ?>
                                        <?= $statusBadge ?>
                                    </h4>
                                    <p style="color: #666; margin: 0.25rem 0;">
                                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($booking['location']) ?>
                                    </p>
                                </div>
                                <h3 style="color: #0d6efd; margin: 0;">
                                    KES <?= number_format($booking['rental_price']) ?>/month
                                </h3>
                            </div>

                            <!-- Property Info -->
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <p><strong>Type:</strong> <?= htmlspecialchars($booking['property_type']) ?></p>
                                    <p><strong>Bedrooms:</strong> <?= $booking['bedrooms'] ?> | <strong>Bathrooms:</strong> <?= $booking['bathrooms'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Booking Date:</strong> 
                                        <?= !empty($booking['booking_date']) ? date('d M Y', strtotime($booking['booking_date'])) : 'N/A' ?>
                                    </p>
                                    <?php if($status === 'assigned' && !empty($booking['assignment_date'])): ?>
                                        <p><strong>Assignment Date:</strong> 
                                            <?= date('d M Y', strtotime($booking['assignment_date'])) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <p style="color: #666; margin: 0.5rem 0;">
                                <strong>Description:</strong> <?= htmlspecialchars(substr($booking['description'], 0, 100)) ?>...
                            </p>

                            <!-- Agent Information -->
                            <?php if($status === 'assigned' && !empty($booking['agent_name'])): ?>
                                <div class="agent-info">
                                    <h6><i class="fas fa-user-tie"></i> Assigned Agent</h6>
                                    <p><strong>Name:</strong> <?= htmlspecialchars($booking['agent_name']) ?></p>
                                    <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($booking['agent_email']) ?>" style="color: #0d6efd;"><?= htmlspecialchars($booking['agent_email']) ?></a></p>
                                    <?php if(!empty($booking['agent_phone'])): ?>
                                        <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars($booking['agent_phone']) ?>" style="color: #0d6efd;"><?= htmlspecialchars($booking['agent_phone']) ?></a></p>
                                    <?php endif; ?>
                                </div>
                            <?php elseif($status === 'pending'): ?>
                                <div class="agent-info" style="background: #fff3cd;">
                                    <p style="color: #856404; margin: 0;">
                                        <i class="fas fa-info-circle"></i> Your booking is pending approval. An agent will be assigned soon.
                                    </p>
                                </div>
                            <?php endif; ?>

                            <!-- Action Buttons -->
                            <div style="margin-top: 1rem;">
                                <a href="property-details.php?property=<?= $booking['property_id'] ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                <?php if($status === 'assigned'): ?>
                                    <a href="property-documents.php?property=<?= $booking['property_id'] ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-file-alt"></i> Documents
                                    </a>
                                    <a href="maintenance-request.php?property=<?= $booking['property_id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-tools"></i> Report Issue
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        }
        $stmt->close();
    }
    ?>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
