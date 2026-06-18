<?php
// ============================================
// PROFESSIONAL PORTFOLIO - Contact API
// ============================================
// File: api/contact.php
// Handles contact form submissions

header('Content-Type: application/json');
require_once('../config.php');

// Handle different HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        handle_contact_form();
        break;

    case 'GET':
        $action = $_GET['action'] ?? 'count';
        if ($action === 'messages') {
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            $messages = get_recent_messages($limit);
            send_response('success', 'Recent messages retrieved', $messages);
        } else {
            $messages_count = get_messages_count();
            send_response('success', 'Messages count retrieved', ['count' => $messages_count]);
        }
        break;

    case 'OPTIONS':
        http_response_code(200);
        exit;

    default:
        send_response('error', 'Method not allowed', [], 405);
        break;
}

/**
 * Handle contact form submission
 */
function handle_contact_form()
{
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        send_response('error', 'Invalid request method', [], 405);
    }

    // Get JSON data
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    $name = $input['name'] ?? $_POST['name'] ?? '';
    $email = $input['email'] ?? $_POST['email'] ?? '';
    $message = $input['message'] ?? $_POST['message'] ?? '';
    $phone = $input['phone'] ?? $_POST['phone'] ?? '';
    $subject = $input['subject'] ?? $_POST['subject'] ?? 'Contact Form Submission';

    // Sanitize inputs
    $name = trim($name);
    $email = trim($email);
    $message = trim($message);
    $phone = trim($phone);
    $subject = trim($subject);

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        send_response('error', 'Please fill in all required fields (name, email, message)', []);
    }

    // Validate email format
    if (!validate_email($email)) {
        send_response('error', 'Please provide a valid email address', []);
    }

    // Validate message length
    if (strlen($message) < 10) {
        send_response('error', 'Message should be at least 10 characters long', []);
    }

    if (strlen($message) > 5000) {
        send_response('error', 'Message should not exceed 5000 characters', []);
    }

    // Check for spam (simple check)
    if (contains_spam($message) || contains_spam($name)) {
        send_response('error', 'Your message contains inappropriate content', []);
    }

    // Save to database
    $saved = save_contact_message($name, $email, $phone, $subject, $message);

    if (!$saved) {
        send_response('error', 'Failed to save your message. Please try again later.', []);
    }

    // Send notification email
    send_notification_email($name, $email, $subject, $message);

    // Log the visit
    log_visit('contact', 'contact_form');

    // Success response
    send_response('success', 'Thank you for your message! I will get back to you soon.', [
        'message_id' => $saved,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}

/**
 * Check if message contains spam content
 */
function contains_spam($text)
{
    $spam_keywords = [
        'viagra',
        'cialis',
        'casino',
        'lottery',
        'click here',
        'buy now',
        'limited time',
        'act now',
        'urgent',
        'bitcoin',
        'forex',
        'trading',
        'work from home'
    ];

    $text_lower = strtolower($text);

    foreach ($spam_keywords as $keyword) {
        if (strpos($text_lower, $keyword) !== false) {
            return true;
        }
    }

    // Check for excessive URLs
    if (substr_count($text, 'http') > 3) {
        return true;
    }

    // Check for all caps text (shouting)
    if (strlen($text) > 20 && strtoupper($text) === $text) {
        return true;
    }

    return false;
}

/**
 * Send notification email to portfolio owner
 */
function send_notification_email($sender_name, $sender_email, $subject, $message)
{
    $to = OWNER_EMAIL;
    $email_subject = "New Contact Form Submission: " . $subject;

    $email_body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #7c3aed, #06b6d4); color: white; padding: 20px; border-radius: 5px; }
            .content { padding: 20px; background: #f5f5f5; margin-top: 20px; border-radius: 5px; }
            .footer { text-align: center; color: #999; margin-top: 20px; font-size: 12px; }
            .sender-info { background: white; padding: 15px; border-left: 4px solid #7c3aed; margin-bottom: 15px; }
            .message-content { background: white; padding: 15px; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Contact Form Submission</h2>
            </div>
            
            <div class='content'>
                <div class='sender-info'>
                    <p><strong>From:</strong> $sender_name</p>
                    <p><strong>Email:</strong> <a href='mailto:$sender_email'>$sender_email</a></p>
                    <p><strong>Subject:</strong> $subject</p>
                </div>
                
                <div class='message-content'>
                    <h3>Message:</h3>
                    <p>" . nl2br(htmlspecialchars($message)) . "</p>
                </div>
            </div>
            
            <div class='footer'>
                <p>This email was sent from your portfolio contact form.</p>
                <p>Sent at: " . date('Y-m-d H:i:s') . "</p>
            </div>
        </div>
    </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: noreply@yourportfolio.com\r\n";
    $headers .= "Reply-To: $sender_email\r\n";

    send_email_via_smtp($to, $email_subject, $email_body, $headers);

    // Optional: Send auto-reply to sender
    send_auto_reply($sender_name, $sender_email);
}

/**
 * Send auto-reply to form submitter
 */
function send_auto_reply($sender_name, $sender_email)
{
    $subject = "Re: Your message has been received";

    $body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #7c3aed, #06b6d4); color: white; padding: 20px; border-radius: 5px; }
            .content { padding: 20px; background: #f5f5f5; margin-top: 20px; border-radius: 5px; }
            .footer { text-align: center; color: #999; margin-top: 20px; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Thank You!</h2>
            </div>
            
            <div class='content'>
                <p>Hi $sender_name,</p>
                
                <p>Thank you for reaching out! I have received your message and will get back to you as soon as possible, typically within 24-48 hours.</p>
                
                <p>In the meantime, feel free to check out my projects and portfolio on my website.</p>
                
                <p>Best regards,<br>
                <strong>" . OWNER_NAME . "</strong><br>
                " . OWNER_PHONE . "</p>
            </div>
            
            <div class='footer'>
                <p>This is an automated response. Please do not reply to this email.</p>
            </div>
        </div>
    </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: " . OWNER_NAME . " <noreply@yourportfolio.com>\r\n";

    send_email_via_smtp($sender_email, $subject, $body, $headers);
}

/**
 * Get count of messages
 */
function get_recent_messages($limit = 20)
{
    global $conn;

    $limit = max(1, min(100, intval($limit)));
    $query = "SELECT message_id, sender_name, sender_email, subject, message_text, read_status, response_status, created_at FROM contact_messages ORDER BY created_at DESC LIMIT $limit";
    $result = $conn->query($query);

    $messages = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
    }

    return $messages;
}

function get_messages_count()
{
    global $conn;

    $query = "SELECT COUNT(*) as count FROM contact_messages";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    return 0;
}

// ============================================
// API Endpoints Ready
// ============================================
// POST /api/contact.php - Submit contact form
// GET /api/contact.php?action=messages - Get recent contact messages
// GET /api/contact.php - Get message count

?>