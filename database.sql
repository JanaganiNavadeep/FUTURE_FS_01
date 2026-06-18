-- ============================================
-- PROFESSIONAL PORTFOLIO - MySQL Database
-- ============================================
-- Database: portfolio_janagani
-- Created: 2024
-- Description: Database for storing portfolio data and contact messages

-- ============================================
-- CREATE DATABASE
-- ============================================

CREATE DATABASE IF NOT EXISTS `portfolio_janagani`
DEFAULT CHARACTER SET = utf8mb4
DEFAULT COLLATE = utf8mb4_unicode_ci;
USE `portfolio_janagani`;

-- ============================================
-- TABLE: users
-- ============================================
-- Stores personal information about the portfolio owner

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    linkedin_profile VARCHAR(255),
    github_profile VARCHAR(255),
    career_objective TEXT,
    profile_picture LONGBLOB,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_created_at (created_at)
);

-- ============================================
-- TABLE: education
-- ============================================
-- Stores education history

CREATE TABLE IF NOT EXISTS education (
    education_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    degree_name VARCHAR(100) NOT NULL,
    institution_name VARCHAR(100) NOT NULL,
    location VARCHAR(100),
    start_year INT NOT NULL,
    end_year INT NOT NULL,
    percentage DECIMAL(5, 2),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_end_year (end_year)
);

-- ============================================
-- TABLE: skills
-- ============================================
-- Stores technical skills with proficiency levels

CREATE TABLE IF NOT EXISTS skills (
    skill_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    skill_name VARCHAR(100) NOT NULL,
    skill_category VARCHAR(50),
    proficiency_level INT DEFAULT 80,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_skill_category (skill_category),
    UNIQUE KEY unique_skill (user_id, skill_name)
);

-- ============================================
-- TABLE: projects
-- ============================================
-- Stores information about completed projects

CREATE TABLE IF NOT EXISTS projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    project_name VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    technologies_used VARCHAR(500),
    start_date DATE,
    end_date DATE,
    repository_link VARCHAR(500),
    live_link VARCHAR(500),
    project_image LONGBLOB,
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_featured (featured),
    INDEX idx_created_at (created_at)
);

-- ============================================
-- TABLE: certificates
-- ============================================
-- Stores certification and achievement information

CREATE TABLE IF NOT EXISTS certificates (
    certificate_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    certificate_name VARCHAR(200) NOT NULL,
    issuing_organization VARCHAR(100) NOT NULL,
    issue_date DATE,
    expiry_date DATE,
    certificate_link VARCHAR(500),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_issue_date (issue_date)
);

-- ============================================
-- TABLE: contact_messages
-- ============================================
-- Stores contact form submissions

CREATE TABLE IF NOT EXISTS contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_name VARCHAR(100) NOT NULL,
    sender_email VARCHAR(100) NOT NULL,
    sender_phone VARCHAR(20),
    subject VARCHAR(200),
    message_text LONGTEXT NOT NULL,
    read_status BOOLEAN DEFAULT FALSE,
    response_status ENUM('pending', 'responded', 'spam') DEFAULT 'pending',
    response_message LONGTEXT,
    responded_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_sender_email (sender_email),
    INDEX idx_read_status (read_status),
    INDEX idx_response_status (response_status),
    INDEX idx_created_at (created_at)
);

-- ============================================
-- TABLE: experience (Optional)
-- ============================================
-- Stores work experience information

CREATE TABLE IF NOT EXISTS experience (
    experience_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    job_title VARCHAR(100) NOT NULL,
    employment_type VARCHAR(50),
    location VARCHAR(100),
    start_date DATE NOT NULL,
    end_date DATE,
    current_job BOOLEAN DEFAULT FALSE,
    job_description TEXT,
    achievements TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_start_date (start_date)
);

-- ============================================
-- TABLE: portfolio_stats
-- ============================================
-- Stores portfolio view statistics

CREATE TABLE IF NOT EXISTS portfolio_stats (
    stat_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    visitor_ip VARCHAR(45),
    visitor_country VARCHAR(100),
    page_visited VARCHAR(255),
    referrer VARCHAR(500),
    user_agent LONGTEXT,
    visit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_visit_date (visit_date)
);

-- ============================================
-- INSERT: Sample Data for Janagani Navadeep
-- ============================================

-- Insert user data
INSERT INTO users (first_name, last_name, email, phone, linkedin_profile, github_profile, career_objective)
VALUES (
    'Janagani',
    'Navadeep',
    'janaganinavadeep7@gmail.com',
    '+91-9963363474',
    'https://linkedin.com/in/janagani-navadeep',
    'https://github.com/JanaganiNavadeep',
    'To work with an organization in a position where I can efficiently contribute my skills and abilities to the growth of the organization and build a professional career.'
);

-- Insert education data
INSERT INTO education (user_id, degree_name, institution_name, location, start_year, end_year, percentage, description)
VALUES
    (1, 'Bachelor of Technology', 'Mohan Babu University', 'Tirupati, India', 2023, 2027, 91.60, 'Pursuing Bachelor of Technology degree'),
    (1, 'Intermediate', 'Narayana Junior College', 'Kurnool, India', 2021, 2023, 95.80, 'Completed Intermediate education'),
    (1, 'Secondary School', 'Sree Vidyanikethan E.M High School', 'Ananthapur, India', 2020, 2021, 95.00, 'Completed Secondary School');

-- Insert skills data
INSERT INTO skills (user_id, skill_name, skill_category, proficiency_level, description)
VALUES
    (1, 'Java Programming', 'Backend', 85, 'Proficient in Java for backend development'),
    (1, 'C Programming', 'Languages', 80, 'Strong understanding of C programming concepts'),
    (1, 'HTML', 'Frontend', 90, 'Expert in semantic HTML5'),
    (1, 'CSS', 'Frontend', 88, 'Advanced CSS with animations and responsive design'),
    (1, 'JavaScript', 'Frontend', 85, 'Strong JavaScript skills for interactive web development'),
    (1, 'MySQL', 'Database', 82, 'Proficient in database design and SQL queries'),
    (1, 'Excel', 'Tools', 80, 'Proficient in spreadsheet management and analysis');

-- Insert projects data
INSERT INTO projects (user_id, project_name, description, technologies_used, repository_link, featured)
VALUES
    (1, 'Medi-Aid - Emergency Medical Information', 
    'A collaborative healthcare/emergency care application developed as an open-source project to improve emergency response and medical support systems.',
    'HTML5, CSS, JavaScript', 
    'https://github.com/JanaganiNavadeep/Mediaid-emergency-care/tree/main/wt', 
    TRUE);

-- Insert certificates data
INSERT INTO certificates (user_id, certificate_name, issuing_organization, certificate_link, description)
VALUES
    (1, 'Web Development Certification', 'Mohan Babu University', 
    'https://drive.google.com/file/d/1vI2g6z4Q6HSDHsRHibUfswodEVjBEhgS/view?usp=drivesdk',
    'Certified in Web Development'),
    (1, 'Winzera Company Certification', 'Tlc company name Winzera', 
    'https://drive.google.com/file/d/1H6KUUlVEndTEpTgO4X6GXUCTEnpUskMH/view?usp=drivesdk',
    'Certified as a member'),
    (1, 'Hackathon Participation Certificate', 'Mohan Babu University Hackathon', 
    NULL,
    'Recognized for active participation and innovation in a university hackathon event.'),
    (1, 'Intro to MS Excel', 'Simplilearn SkillUp',
    'https://drive.google.com/file/d/1H6KUUlVEndTEpTgO4X6GXUCTEnpUskMH/view?usp=drivesdk',
    'Completed Introduction to MS Excel online course through Simplilearn SkillUp');

-- ============================================
-- VIEWS for Easy Data Retrieval
-- ============================================

-- View: Complete User Profile
CREATE OR REPLACE VIEW user_profile_view AS
SELECT 
    u.user_id,
    u.first_name,
    u.last_name,
    u.email,
    u.phone,
    u.linkedin_profile,
    u.github_profile,
    u.career_objective,
    COUNT(DISTINCT e.education_id) as education_count,
    COUNT(DISTINCT s.skill_id) as skill_count,
    COUNT(DISTINCT p.project_id) as project_count,
    COUNT(DISTINCT c.certificate_id) as certificate_count
FROM users u
LEFT JOIN education e ON u.user_id = e.user_id
LEFT JOIN skills s ON u.user_id = s.user_id
LEFT JOIN projects p ON u.user_id = p.user_id
LEFT JOIN certificates c ON u.user_id = c.user_id
GROUP BY u.user_id;

-- View: Unread Messages
CREATE OR REPLACE VIEW unread_messages_view AS
SELECT 
    message_id,
    sender_name,
    sender_email,
    subject,
    message_text,
    created_at
FROM contact_messages
WHERE read_status = FALSE
ORDER BY created_at DESC;

-- ============================================
-- STORED PROCEDURES
-- ============================================

-- Procedure: Get Portfolio Summary
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS get_portfolio_summary(IN p_user_id INT)
BEGIN
    SELECT 
        (SELECT COUNT(*) FROM education WHERE user_id = p_user_id) as total_education,
        (SELECT COUNT(*) FROM skills WHERE user_id = p_user_id) as total_skills,
        (SELECT COUNT(*) FROM projects WHERE user_id = p_user_id) as total_projects,
        (SELECT COUNT(*) FROM certificates WHERE user_id = p_user_id) as total_certificates;
END //
DELIMITER ;

-- Procedure: Add Contact Message
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS add_contact_message(
    IN p_name VARCHAR(100),
    IN p_email VARCHAR(100),
    IN p_phone VARCHAR(20),
    IN p_subject VARCHAR(200),
    IN p_message LONGTEXT
)
BEGIN
    INSERT INTO contact_messages (sender_name, sender_email, sender_phone, subject, message_text)
    VALUES (p_name, p_email, p_phone, p_subject, p_message);
END //
DELIMITER ;

-- ============================================
-- INDEXES for Performance Optimization
-- ============================================

CREATE INDEX idx_education_user ON education(user_id);
CREATE INDEX idx_skills_user ON skills(user_id);
CREATE INDEX idx_projects_user ON projects(user_id);
CREATE INDEX idx_certificates_user ON certificates(user_id);
CREATE INDEX idx_messages_email ON contact_messages(sender_email);

-- ============================================
-- Database Backup Query
-- ============================================
-- To backup: mysqldump -u username -p portfolio_janagani > backup.sql
-- To restore: mysql -u username -p portfolio_janagani < backup.sql

-- ============================================
-- End of Database Schema
-- ============================================

/*
USAGE INSTRUCTIONS:

1. Connect to MySQL Server
   mysql -u root -p

2. Execute this script to create the database and tables
   SOURCE path/to/this/file.sql;

3. To verify the setup:
   USE portfolio_janagani;
   SHOW TABLES;
   SELECT * FROM users;

4. Connect from PHP/Backend:
   $host = "localhost";
   $user = "root";
   $password = "your_password";
   $db = "portfolio_janagani";
   
   $connection = new mysqli($host, $user, $password, $db);

5. Access view: SELECT * FROM user_profile_view;

6. Call stored procedure: CALL get_portfolio_summary(1);

*/
