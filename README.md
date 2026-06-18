# Janagani Navadeep - Professional Portfolio

A modern, responsive, and professionally designed personal portfolio website featuring a full-stack implementation with HTML, CSS, JavaScript, PHP, and MySQL.

## 📁 Project Structure

```
portfolio/
├── index.html           # Main portfolio page
├── styles.css           # Professional styling with modern design
├── script.js            # Interactive features and animations
├── config.php           # Database configuration
├── database.sql         # MySQL database schema
├── .htaccess            # Server configuration (optional)
├── api/
│   ├── contact.php      # Contact form handler
│   └── portfolio.php    # Portfolio data API
└── assets/              # Images and media (optional)
```

## ✨ Features

### Frontend Features

- **Responsive Design** - Works perfectly on all devices (desktop, tablet, mobile)
- **Modern Styling** - Beautiful gradient colors and smooth animations
- **Smooth Navigation** - Sticky navbar with smooth scrolling
- **Interactive Elements** - Hover effects, progress bars, and animations
- **Contact Form** - Functional contact form with validation
- **Mobile Menu** - Hamburger menu for mobile devices
- **Lazy Loading** - Optimized performance with lazy loading support
- **Print Support** - Professional print stylesheet

### Backend Features

- **MySQL Database** - Stores portfolio data and contact messages
- **RESTful API** - API endpoints for portfolio data
- **Email Notifications** - Automatic emails for contact form submissions
- **Data Validation** - Server-side validation and spam prevention
- **Security** - SQL injection prevention, XSS protection, CSRF tokens
- **Logging** - Visit tracking and analytics

## 🚀 Quick Start

### Prerequisites

- Web Server (Apache/Nginx)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser

### Installation

#### 1. Download/Extract Portfolio Files

```bash
# Extract the portfolio files to your web server directory
# Example: /var/www/html/portfolio or C:\xampp\htdocs\portfolio
```

#### 2. Create Database

```bash
# Connect to MySQL
mysql -u root -p

# Execute the database script
source /path/to/database.sql;

# Or paste the entire database.sql content in MySQL workbench
```

#### 3. Configure Database Connection

Edit `config.php` and update database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'portfolio_janagani');
```

#### 4. Update Owner Information

Update the following in `config.php`:

```php
define('OWNER_EMAIL', 'janaganinavadeep7@gmail.com');
define('OWNER_NAME', 'Janagani Navadeep');
define('OWNER_PHONE', '+91-9963363474');
```

#### 5. Open in Browser

```
http://localhost/portfolio
// or
http://yourdomain.com/portfolio
```

## 📋 Database Structure

### Tables

1. **users** - Portfolio owner information
2. **education** - Education history
3. **skills** - Technical skills
4. **projects** - Project portfolio
5. **certificates** - Certifications and achievements
6. **experience** - Work experience (optional)
7. **contact_messages** - Contact form submissions
8. **portfolio_stats** - Visit analytics

### Views

- `user_profile_view` - Complete user profile with counts
- `unread_messages_view` - Unread contact messages

## 🔌 API Endpoints

### Portfolio Data Endpoints

```
GET /api/portfolio.php?action=profile
GET /api/portfolio.php?action=education
GET /api/portfolio.php?action=skills
GET /api/portfolio.php?action=projects
GET /api/portfolio.php?action=certificates
GET /api/portfolio.php?action=summary
GET /api/portfolio.php?action=all
```

### Contact Form Endpoint

```
POST /api/contact.php
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+91-1234567890",
    "subject": "Project Inquiry",
    "message": "I'd like to discuss a project..."
}
```

## 🎨 Customization

### Update Personal Information

Edit `index.html`:

- Replace name in hero section
- Update contact information
- Add/modify education records
- Update skills and proficiency levels
- Modify project details
- Update certificate links

### Change Color Scheme

Edit `styles.css` - Update CSS variables in `:root`:

```css
:root {
  --primary-color: #7c3aed;
  --secondary-color: #06b6d4;
  --accent-color: #ec4899;
  --dark-bg: #0f172a;
  --light-bg: #1e293b;
  --text-primary: #f1f5f9;
  --text-secondary: #cbd5e1;
}
```

### Add New Sections

Add new sections following the existing HTML structure and CSS classes.

## 📧 Email Configuration

To enable email notifications:

1. Update `OWNER_EMAIL` in `config.php`
2. Ensure your server has mail function enabled
3. (Optional) Configure SMTP for better reliability

For production, consider using services like:

- SendGrid
- Mailgun
- AWS SES

## 🔒 Security

### Implemented Security Features

- ✅ SQL Injection Prevention (Prepared statements)
- ✅ XSS Protection (Input sanitization)
- ✅ CSRF Protection (Token validation)
- ✅ Security Headers (CORS, X-Frame-Options, etc.)
- ✅ Email Validation
- ✅ Spam Detection
- ✅ Rate Limiting (can be added)
- ✅ HTTPS Ready

### Security Recommendations

1. **Always use HTTPS** in production
2. **Keep PHP/MySQL updated**
3. **Use strong database passwords**
4. **Implement rate limiting** for contact form
5. **Regular security audits**
6. **Backup database regularly**

## 📱 Responsive Breakpoints

- **Desktop**: 1200px and up
- **Tablet**: 768px to 1199px
- **Mobile**: 480px to 767px
- **Small Mobile**: Below 480px

## 🚀 Performance Optimization

### Implemented Optimizations

- ✅ CSS/JS minification ready
- ✅ Lazy loading images
- ✅ Smooth animations with GPU acceleration
- ✅ Optimized fonts
- ✅ Efficient database queries with indexes
- ✅ Caching headers

### Recommended Optimizations

1. Enable GZIP compression on server
2. Minify CSS and JavaScript
3. Use CDN for static files
4. Implement caching strategies
5. Optimize images
6. Consider using a static site generator for performance

## 📊 Analytics

The portfolio tracks:

- Visitor IP addresses
- Page visited
- Referrer information
- User agent (browser info)
- Visit timestamps

Access analytics through database queries or create an admin panel.

## 🔄 Backup & Restore

### Backup Database

```bash
mysqldump -u root -p portfolio_janagani > backup.sql
```

### Restore Database

```bash
mysql -u root -p portfolio_janagani < backup.sql
```

## 📝 Content Management

### Adding New Education

```php
// In database.sql or through admin panel
INSERT INTO education (user_id, degree_name, institution_name, location, start_year, end_year, percentage)
VALUES (1, 'Degree Name', 'Institution', 'Location', 2020, 2024, 95.5);
```

### Adding New Project

```php
INSERT INTO projects (user_id, project_name, description, technologies_used, repository_link, featured)
VALUES (1, 'Project Name', 'Description', 'Tech1, Tech2', 'https://github.com/...', TRUE);
```

### Adding New Skill

```php
INSERT INTO skills (user_id, skill_name, skill_category, proficiency_level)
VALUES (1, 'Skill Name', 'Category', 85);
```

## 🎓 Learning Resources

- [HTML Documentation](https://developer.mozilla.org/en-US/docs/Web/HTML)
- [CSS Guide](https://developer.mozilla.org/en-US/docs/Web/CSS)
- [JavaScript Basics](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
- [PHP Manual](https://www.php.net/manual/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

## 🤝 Contributing

To customize for your own portfolio:

1. Update personal information in HTML
2. Modify colors and styling in CSS
3. Customize JavaScript animations
4. Update database with your data
5. Test on different devices

## 📞 Contact & Support

- **Email**: janaganinavadeep7@gmail.com
- **Phone**: +91-9963363474
- **LinkedIn**: Janagani Navadeep
- **GitHub**: JanaganiNavadeep

## 📄 License

This portfolio template is provided as-is for personal use.

## 🎉 Credits

Created with ❤️ for a professional online presence.

---

## Version History

### v1.0 (2024)

- Initial portfolio release
- Frontend (HTML/CSS/JS)
- Backend (PHP/MySQL)
- API endpoints
- Contact form functionality
- Database schema
- Comprehensive documentation

---

**Last Updated**: 2024
**Status**: Production Ready ✅

For more information or updates, visit the repository.
