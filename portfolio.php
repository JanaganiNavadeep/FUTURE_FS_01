<?php
// ============================================
// PROFESSIONAL PORTFOLIO - Data API
// ============================================
// File: api/portfolio.php
// Provides portfolio data as JSON endpoints

header('Content-Type: application/json');
require_once('../config.php');

// Get action from query parameter
$action = $_GET['action'] ?? 'all';

switch ($action) {
    case 'profile':
        $data = get_portfolio_owner();
        send_response('success', 'Profile retrieved successfully', $data);
        break;

    case 'education':
        $data = get_education();
        send_response('success', 'Education records retrieved', $data);
        break;

    case 'skills':
        $data = get_skills();
        send_response('success', 'Skills retrieved', $data);
        break;

    case 'projects':
        $featured = $_GET['featured'] ?? false;
        $data = get_projects($featured);
        send_response('success', 'Projects retrieved', $data);
        break;

    case 'certificates':
        $data = get_certificates();
        send_response('success', 'Certificates retrieved', $data);
        break;

    case 'summary':
        $data = get_portfolio_summary();
        send_response('success', 'Portfolio summary retrieved', $data);
        break;

    case 'all':
        $data = [
            'profile' => get_portfolio_owner(),
            'education' => get_education(),
            'skills' => get_skills(),
            'projects' => get_projects(),
            'certificates' => get_certificates()
        ];
        log_visit('portfolio_api', 'api_all');
        send_response('success', 'Complete portfolio data retrieved', $data);
        break;

    default:
        send_response('error', 'Invalid action', [], 400);
        break;
}

/**
 * Get portfolio summary statistics
 */
function get_portfolio_summary()
{
    global $conn;

    $query = "SELECT 
        (SELECT COUNT(*) FROM education WHERE user_id = " . PORTFOLIO_OWNER_ID . ") as education_count,
        (SELECT COUNT(*) FROM skills WHERE user_id = " . PORTFOLIO_OWNER_ID . ") as skill_count,
        (SELECT COUNT(*) FROM projects WHERE user_id = " . PORTFOLIO_OWNER_ID . ") as project_count,
        (SELECT COUNT(*) FROM certificates WHERE user_id = " . PORTFOLIO_OWNER_ID . ") as certificate_count,
        (SELECT COUNT(*) FROM contact_messages) as message_count";

    $result = $conn->query($query);

    if ($result) {
        return $result->fetch_assoc();
    }

    return null;
}

// ============================================
// API Endpoints Documentation
// ============================================
/*

Available Endpoints:

1. GET /api/portfolio.php?action=profile
   Returns: User profile information

2. GET /api/portfolio.php?action=education
   Returns: Array of education records

3. GET /api/portfolio.php?action=skills
   Returns: Array of skills with proficiency levels

4. GET /api/portfolio.php?action=projects
   Returns: Array of all projects

5. GET /api/portfolio.php?action=projects&featured=true
   Returns: Array of featured projects only

6. GET /api/portfolio.php?action=certificates
   Returns: Array of certificates and achievements

7. GET /api/portfolio.php?action=summary
   Returns: Portfolio statistics summary

8. GET /api/portfolio.php?action=all
   Returns: Complete portfolio data (all of the above)

Example Response Format:
{
    "status": "success",
    "message": "Data retrieved successfully",
    "data": { ... },
    "timestamp": "2024-01-15 10:30:00"
}

Usage Examples:

// Fetch all data
fetch('/api/portfolio.php?action=all')
    .then(response => response.json())
    .then(data => console.log(data));

// Fetch only projects
fetch('/api/portfolio.php?action=projects')
    .then(response => response.json())
    .then(data => console.log(data.data));

// JavaScript example
async function getPortfolioData() {
    try {
        const response = await fetch('/api/portfolio.php?action=all');
        const data = await response.json();
        
        if (data.status === 'success') {
            console.log(data.data);
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

*/

?>