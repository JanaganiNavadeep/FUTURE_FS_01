<?php
// ============================================
// PROFESSIONAL PORTFOLIO - PHP Backend
// ============================================
// File: config.php
// Database configuration and utility functions

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'portfolio_janagani');

// Portfolio Owner Information
define('PORTFOLIO_OWNER_ID', 1);
define('OWNER_EMAIL', 'janaganinavadeep7@gmail.com');
define('OWNER_NAME', 'Janagani Navadeep');
define('OWNER_PHONE', '+91-9963363474');

// Email Configuration (for contact form notifications)
// ⚠️ UPDATE WITH YOUR GMAIL ACCOUNT OR YOUR EMAIL SERVICE CREDENTIALS
define('SMTP_ENABLED', true); // Set to true to enable SMTP
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com'); // Your Gmail address
define('SMTP_PASSWORD', 'your-app-password'); // Gmail App Password (NOT your main password)

// Establish Database Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    error_log('Database Connection Error: ' . $conn->connect_error);
    // Return error response if this is an API call
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['action'])) {
        header('Content-Type: application/json');
        http_response_code(503);
        die(json_encode(['status' => 'error', 'message' => 'Database service unavailable. Please try again later.']));
    }
    die('Database connection failed. Please contact the site administrator.');
}

// Set charset to utf8
$conn->set_charset('utf8mb4');

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'portfolio_errors.log');

// Security headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

// ============================================
// UTILITY FUNCTIONS
// ============================================

/**
 * Sanitize input string
 */
function sanitize_input($input)
{
    global $conn;
    return $conn->real_escape_string(htmlspecialchars(trim($input)));
}

/**
 * Validate email format
 */
function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
}

/**
 * Send JSON response
 */
function send_response($status, $message, $data = null, $http_status = 200)
{
    header('Content-Type: application/json');
    http_response_code($http_status);

    $response = [
        'status' => $status,
        'message' => $message,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    if ($data !== null) {
        $response['data'] = $data;
    }

    echo json_encode($response);
    exit();
}

/**
 * Get portfolio owner information
 */
function get_portfolio_owner()
{
    global $conn;

    $query = "SELECT * FROM users WHERE user_id = " . PORTFOLIO_OWNER_ID;
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

/**
 * Get all education records
 */
function get_education()
{
    global $conn;

    $query = "SELECT * FROM education WHERE user_id = " . PORTFOLIO_OWNER_ID . " ORDER BY end_year DESC";
    $result = $conn->query($query);

    $education = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $education[] = $row;
        }
    }

    return $education;
}

/**
 * Get all skills
 */
function get_skills()
{
    global $conn;

    $query = "SELECT * FROM skills WHERE user_id = " . PORTFOLIO_OWNER_ID . " ORDER BY proficiency_level DESC";
    $result = $conn->query($query);

    $skills = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $skills[] = $row;
        }
    }

    return $skills;
}

/**
 * Get all projects
 */
function get_projects($featured_only = false)
{
    global $conn;

    $query = "SELECT * FROM projects WHERE user_id = " . PORTFOLIO_OWNER_ID;

    if ($featured_only) {
        $query .= " AND featured = TRUE";
    }

    $query .= " ORDER BY created_at DESC";
    $result = $conn->query($query);

    $projects = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $projects[] = $row;
        }
    }

    return $projects;
}

/**
 * Get all certificates
 */
function get_certificates()
{
    global $conn;

    $query = "SELECT * FROM certificates WHERE user_id = " . PORTFOLIO_OWNER_ID . " ORDER BY issue_date DESC";
    $result = $conn->query($query);

    $certificates = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $certificates[] = $row;
        }
    }

    return $certificates;
}

/**
 * Save contact message to database
 */
function save_contact_message($name, $email, $phone = '', $subject = '', $message)
{
    global $conn;

    $name = sanitize_input($name);
    $email = sanitize_input($email);
    $phone = sanitize_input($phone);
    $subject = sanitize_input($subject);
    $message = sanitize_input($message);

    $query = "INSERT INTO contact_messages (sender_name, sender_email, sender_phone, subject, message_text) 
              VALUES ('$name', '$email', '$phone', '$subject', '$message')";

    if ($conn->query($query) === TRUE) {
        return $conn->insert_id;
    } else {
        error_log('Error saving contact message: ' . $conn->error);
        return false;
    }
}

/**
 * Log portfolio visit
 */
function log_visit($page = '', $referrer = '')
{
    global $conn;

    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user_agent = $conn->real_escape_string($_SERVER['HTTP_USER_AGENT'] ?? 'unknown');
    $page = sanitize_input($page);
    $referrer = sanitize_input($referrer);

    $query = "INSERT INTO portfolio_stats (user_id, visitor_ip, page_visited, referrer, user_agent) 
              VALUES (" . PORTFOLIO_OWNER_ID . ", '$ip', '$page', '$referrer', '$user_agent')";

    $conn->query($query);
}

/**
 * Send email via SMTP or fallback to mail()
 */
function send_email_via_smtp($to, $subject, $body, $headers = '')
{
    if (!SMTP_ENABLED || empty(SMTP_USER) || empty(SMTP_PASSWORD)) {
        // Fallback to mail() if SMTP not configured
        return @mail($to, $subject, $body, $headers);
    }

    try {
        // Create socket connection to SMTP server
        $fp = @fsockopen(SMTP_HOST, SMTP_PORT, $errno, $errstr, 30);
        
        if (!$fp) {
            error_log("SMTP Connection failed: $errstr ($errno). Falling back to mail().");
            return @mail($to, $subject, $body, $headers);
        }

        $out = '';
        
        // Read SMTP greeting
        $response = fgets($fp, 1024);
        if (strpos($response, '220') === false) {
            fclose($fp);
            return @mail($to, $subject, $body, $headers);
        }

        // Send EHLO command
        fwrite($fp, "EHLO localhost\r\n");
        $response = fgets($fp, 1024);

        // Start TLS
        fwrite($fp, "STARTTLS\r\n");
        $response = fgets($fp, 1024);
        
        if (strpos($response, '220') !== false) {
            if (function_exists('stream_context_create')) {
                stream_context_set_option($fp, 'ssl', 'allow_self_signed', true);
                stream_context_set_option($fp, 'ssl', 'verify_peer', false);
            }
        }

        // Send EHLO again after TLS
        fwrite($fp, "EHLO localhost\r\n");
        $response = fgets($fp, 1024);

        // Authenticate
        fwrite($fp, "AUTH LOGIN\r\n");
        $response = fgets($fp, 1024);

        fwrite($fp, base64_encode(SMTP_USER) . "\r\n");
        $response = fgets($fp, 1024);

        fwrite($fp, base64_encode(SMTP_PASSWORD) . "\r\n");
        $response = fgets($fp, 1024);

        if (strpos($response, '235') === false) {
            error_log("SMTP Authentication failed. Response: $response");
            fclose($fp);
            return @mail($to, $subject, $body, $headers);
        }

        // Send email
        fwrite($fp, "MAIL FROM: <" . SMTP_USER . ">\r\n");
        $response = fgets($fp, 1024);

        fwrite($fp, "RCPT TO: <$to>\r\n");
        $response = fgets($fp, 1024);

        fwrite($fp, "DATA\r\n");
        $response = fgets($fp, 1024);

        $email_message = "Subject: $subject\r\n";
        $email_message .= "To: $to\r\n";
        $email_message .= $headers . "\r\n\r\n";
        $email_message .= $body . "\r\n";

        fwrite($fp, $email_message . "\r\n.\r\n");
        $response = fgets($fp, 1024);

        fwrite($fp, "QUIT\r\n");
        fclose($fp);

        return true;
    } catch (Exception $e) {
        error_log("SMTP Error: " . $e->getMessage());
        return @mail($to, $subject, $body, $headers);
    }
}

?>