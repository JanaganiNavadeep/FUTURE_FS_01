# Janagani Navadeep Portfolio - Installation & Setup Guide

## 📦 What You Have

A complete professional portfolio system with:

- ✅ Beautiful responsive HTML frontend
- ✅ Modern CSS styling with gradients and animations
- ✅ Interactive JavaScript features
- ✅ PHP backend with MySQL database
- ✅ RESTful API endpoints
- ✅ Contact form with email notifications
- ✅ Admin dashboard for content management
- ✅ Security features and validation
- ✅ Comprehensive documentation

## 🎯 Quick Start (5 Minutes)

### Option 1: Static Portfolio (No Database Required)

The portfolio works as a static website without PHP/MySQL!

1. **Simply open index.html in a browser**
   - All information is displayed statically
   - No backend required
   - Perfect for quick deployment

2. **To enable contact form:**
   - Form will show validation messages
   - For email to work, need PHP backend (see Option 2)

### Option 2: Full Stack Setup (With Database)

#### Step 1: Prerequisites

- Apache/Nginx or any web server with PHP support
- PHP 7.4+ installed
- MySQL server installed and running
- Local setup: XAMPP, WAMP, or MAMP

#### Step 2: File Placement

**XAMPP (Windows):**

```
C:\xampp\htdocs\portfolio\
├── index.html
├── styles.css
├── script.js
├── config.php
├── database.sql
├── .htaccess
├── api/
│   ├── contact.php
│   └── portfolio.php
└── admin/
    └── dashboard.html
```

**Linux/Mac:**

```
/var/www/html/portfolio/
(same structure as above)
```

#### Step 3: Create Database

1. **Open phpMyAdmin or MySQL CLI**

2. **Copy entire content of database.sql and execute:**

   ```sql
   -- Paste all content from database.sql here
   ```

   OR run from terminal:

   ```bash
   mysql -u root -p < database.sql
   ```

#### Step 4: Configure Database Connection

Edit `config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');          // Your MySQL username
define('DB_PASSWORD', 'password');  // Your MySQL password
define('DB_NAME', 'portfolio_janagani');
```

#### Step 5: Access Portfolio

```
Local:     http://localhost/portfolio
           http://localhost/phpmyadmin (to manage database)
           http://localhost/portfolio/admin/dashboard.html (admin panel)

Live:      https://yourdomain.com/portfolio
```

## 📁 File Structure Explained

```
portfolio/
├── index.html                 # Main portfolio page
├── styles.css                 # All styling (1500+ lines)
├── script.js                  # Interactivity and animations
├── config.php                 # Database configuration
├── database.sql               # Database schema and sample data
├── .htaccess                  # Apache configuration
├── README.md                  # Full documentation
├── SETUP.md                   # This file
├── api/
│   ├── contact.php           # Contact form handler
│   └── portfolio.php         # Data API endpoints
└── admin/
    └── dashboard.html        # Admin content management
```

## 🔧 Customization

### Update Personal Information

**In index.html:**

- Search for "Janagani Navadeep" and replace with your name
- Update contact info (phone, email)
- Modify LinkedIn and GitHub URLs
- Update education details
- Change skills and percentages
- Update project information

### Update Database Content

**After setup, add your data:**

```sql
-- Add education
INSERT INTO education (user_id, degree_name, institution_name, ...)
VALUES (1, 'Your Degree', 'Your University', ...);

-- Add skills
INSERT INTO skills (user_id, skill_name, proficiency_level, ...)
VALUES (1, 'Your Skill', 90, ...);

-- Add projects
INSERT INTO projects (user_id, project_name, description, ...)
VALUES (1, 'Your Project', 'Description', ...);
```

### Change Colors

**In styles.css, update CSS variables:**

```css
:root {
  --primary-color: #7c3aed; /* Purple */
  --secondary-color: #06b6d4; /* Cyan */
  --accent-color: #ec4899; /* Pink */
  --dark-bg: #0f172a; /* Dark Blue */
  --light-bg: #1e293b; /* Light Blue */
}
```

## 🚀 Deployment

### Deploy to Shared Hosting

1. **Upload files via FTP**
   - Connect to your hosting FTP
   - Upload all files maintaining folder structure
   - Upload database.sql

2. **Create Database**
   - Use hosting control panel (cPanel/Plesk)
   - Execute database.sql in phpMyAdmin

3. **Update config.php**
   - Use database credentials from hosting panel
   - Change DB_HOST (usually localhost or specific IP)

### Deploy to Cloud (Heroku, AWS, etc.)

1. **Create server with PHP + MySQL**
2. **Upload files**
3. **Run database setup**
4. **Configure environment variables**

## 🔒 Security Checklist

- [ ] Use HTTPS in production
- [ ] Keep PHP/MySQL updated
- [ ] Set strong database password
- [ ] Backup database regularly
- [ ] Verify email configuration
- [ ] Test form submission
- [ ] Check file permissions
- [ ] Disable directory listing

## 🐛 Troubleshooting

### Website shows blank page

```
Solution:
1. Check PHP syntax: php -l index.html
2. Check error logs: /var/log/php/errors.log
3. Enable error display in config.php temporarily
```

### Database connection error

```
Solution:
1. Verify MySQL is running
2. Check credentials in config.php
3. Run: mysql -u root -p (to test connection)
4. Ensure database exists: SHOW DATABASES;
```

### Contact form not working

```
Solution:
1. Check if api/contact.php exists
2. Verify PHP mail() function is enabled
3. Check Apache rewrite rules (.htaccess)
4. Test: curl http://localhost/portfolio/api/contact.php
```

### 404 errors

```
Solution:
1. Verify mod_rewrite is enabled: a2enmod rewrite
2. Check .htaccess file exists
3. Verify file paths are correct
4. Clear browser cache
```

## 📞 API Usage

### Get All Portfolio Data

```javascript
fetch("/api/portfolio.php?action=all")
  .then((res) => res.json())
  .then((data) => console.log(data.data));
```

### Submit Contact Form

```javascript
const formData = {
  name: "John Doe",
  email: "john@example.com",
  phone: "+91-1234567890",
  subject: "Project Discussion",
  message: "I'd like to discuss...",
};

fetch("/api/contact.php", {
  method: "POST",
  headers: { "Content-Type": "application/json" },
  body: JSON.stringify(formData),
})
  .then((res) => res.json())
  .then((data) => console.log(data));
```

## 📊 Database Backup

### Backup

```bash
# Full backup
mysqldump -u root -p portfolio_janagani > backup.sql

# With date
mysqldump -u root -p portfolio_janagani > backup_$(date +%Y-%m-%d).sql
```

### Restore

```bash
# From backup file
mysql -u root -p portfolio_janagani < backup.sql

# From phpMyAdmin
1. Login to phpMyAdmin
2. Select database
3. Import > Choose file > Go
```

## 📱 Testing

### Desktop Testing

- Chrome, Firefox, Safari, Edge
- Check responsive behavior
- Test contact form
- Verify animations

### Mobile Testing

- Test on iPhone (Safari)
- Test on Android (Chrome)
- Check touch interactions
- Verify hamburger menu

### API Testing

```bash
# Test portfolio API
curl "http://localhost/portfolio/api/portfolio.php?action=all"

# Test contact API
curl -X POST "http://localhost/portfolio/api/contact.php" \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@test.com","message":"Test"}'
```

## 🎓 Learning Resources

### Frontend

- [MDN Web Docs](https://developer.mozilla.org)
- [CSS Tricks](https://css-tricks.com)
- [JavaScript.info](https://javascript.info)

### Backend

- [PHP Manual](https://www.php.net/manual/)
- [MySQL Tutorial](https://www.mysqltutorial.org)
- [PHP Database](https://www.w3schools.com/php/php_mysql_intro.asp)

## ✨ Next Steps

1. **Customize** - Update personal information
2. **Test** - Try all features locally
3. **Deploy** - Upload to web server
4. **Monitor** - Check analytics and messages
5. **Maintain** - Regular backups and updates

## 📝 Version Information

- **Version**: 1.0
- **Created**: 2024
- **Status**: Production Ready
- **Requirements**: PHP 7.4+, MySQL 5.7+
- **License**: Personal Use

## 🎉 Support

For issues or questions:

- Email: janaganinavadeep7@gmail.com
- Phone: +91-9963363474
- LinkedIn: Janagani Navadeep

---

**Happy Deploying!** 🚀

Remember to:

- Keep backups
- Monitor performance
- Update regularly
- Stay secure
