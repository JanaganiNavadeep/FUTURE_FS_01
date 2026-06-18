# 🚀 Professional Portfolio Website

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-blue)](https://www.php.net/)
[![MySQL Version](https://img.shields.io/badge/MySQL-%3E%3D5.7-blue)](https://www.mysql.com/)
[![Responsive Design](https://img.shields.io/badge/Responsive-Yes-brightgreen)](#responsive-design)

A **modern, fully-responsive professional portfolio website** built with HTML5, CSS3, JavaScript, PHP, and MySQL. Perfect for developers, freelancers, and professionals to showcase their work, skills, and achievements online.

> 👤 **Portfolio of**: Janagani Navadeep | Full Stack Developer | C-Language Specialist  
> 📧 **Contact**: janaganinavadeep7@gmail.com  
> 🔗 **LinkedIn**: [linkedin.com/in/janagani-navadeep](https://linkedin.com/in/janagani-navadeep)  
> 🐙 **GitHub**: [github.com/JanaganiNavadeep](https://github.com/JanaganiNavadeep)

---

## ✨ Features

### Frontend
- 🎨 **Modern Design** - Beautiful gradient colors with professional aesthetic
- 📱 **Fully Responsive** - Perfect on desktop, tablet, and mobile devices
- ⚡ **Smooth Animations** - Fade-in effects, progress bars, and transitions
- 🧭 **Sticky Navigation** - Fixed navbar with smooth scrolling
- 📋 **Organized Sections** - Home, About, Education, Skills, Projects, Certificates, Contact
- 🌐 **Social Links** - Direct connections to LinkedIn, GitHub, and more
- ♿ **Accessible** - WCAG compliant with semantic HTML
- 🔍 **SEO Optimized** - Proper meta tags and open graph support

### Backend
- 🗄️ **MySQL Database** - Persistent data storage for all portfolio information
- 📡 **RESTful API** - 8 endpoints for portfolio data retrieval
- 📧 **Email Integration** - SMTP support for contact form notifications
- 🔒 **Security** - SQL injection prevention, XSS protection, CSRF tokens
- 📊 **Analytics** - Visitor tracking and message management
- 👨‍💼 **Admin Dashboard** - Easy content management interface

---

## 🛠️ Technology Stack

| Category | Technology |
|----------|------------|
| **Frontend** | HTML5, CSS3, JavaScript (ES6+) |
| **Backend** | PHP 7.4+, MySQL 5.7+ |
| **Server** | Apache with mod_rewrite |
| **Icons** | Font Awesome 6.4.0 |
| **Email** | SMTP/Gmail Integration |

---

## 📋 Project Structure

```
portfolio/
├── index.html              # Main portfolio page
├── styles.css              # Complete styling
├── script.js               # JavaScript functionality
├── config.php              # Database & email config
├── database.sql            # MySQL schema
├── .htaccess               # Apache rewrite rules
├── GITHUB_README.md        # This file
├── START_HERE.md           # Quick start guide
├── SETUP.md                # Detailed setup instructions
└── api/
    ├── contact.php         # Contact form handler
    └── portfolio.php       # Portfolio data API
└── admin/
    └── dashboard.html      # Admin management panel
```

---

## 🚀 Quick Start

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache with mod_rewrite enabled
- Modern web browser

### Installation (5 minutes)

#### 1️⃣ Clone the Repository
```bash
git clone https://github.com/JanaganiNavadeep/FUTURE_FS_01.git
cd FUTURE_FS_01/port
```

#### 2️⃣ Setup Database
```bash
# Connect to MySQL
mysql -u root -p

# Import the database schema
source database.sql;
```

#### 3️⃣ Configure Database Connection
Edit `config.php` and update:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'portfolio_janagani');
```

#### 4️⃣ Configure Email (Optional)
To enable contact form emails, update `config.php`:
```php
define('SMTP_ENABLED', true);
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');
```

#### 5️⃣ Deploy to Web Server
```bash
# Copy files to your web server directory
cp -r port/* /var/www/html/portfolio/

# Or for Windows (XAMPP)
# Copy to: C:\xampp\htdocs\portfolio\
```

#### 6️⃣ Access Your Portfolio
```
http://localhost/portfolio
# or
http://yourdomain.com
```

---

## 📊 API Endpoints

All endpoints return JSON responses with consistent format:

```json
{
  "status": "success|error",
  "message": "Description",
  "data": { /* endpoint-specific data */ },
  "timestamp": "2024-01-15 10:30:00"
}
```

### Available Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/portfolio.php?action=profile` | GET | User profile information |
| `/api/portfolio.php?action=education` | GET | Education records |
| `/api/portfolio.php?action=skills` | GET | Technical skills with proficiency |
| `/api/portfolio.php?action=projects` | GET | All projects |
| `/api/portfolio.php?action=projects&featured=true` | GET | Featured projects only |
| `/api/portfolio.php?action=certificates` | GET | Certifications and achievements |
| `/api/portfolio.php?action=summary` | GET | Portfolio statistics |
| `/api/portfolio.php?action=all` | GET | Complete portfolio data |

### Example Usage

```javascript
// Fetch portfolio summary
fetch('/api/portfolio.php?action=summary')
  .then(response => response.json())
  .then(data => console.log(data));

// Fetch featured projects
fetch('/api/portfolio.php?action=projects&featured=true')
  .then(response => response.json())
  .then(data => console.log(data.data));
```

---

## 💾 Database Schema

### Tables

| Table | Purpose | Fields |
|-------|---------|--------|
| `users` | Profile info | user_id, first_name, last_name, email, phone, etc. |
| `education` | Education history | education_id, degree, institution, years, percentage |
| `skills` | Technical skills | skill_id, skill_name, category, proficiency_level |
| `projects` | Project portfolio | project_id, name, description, technologies, links |
| `certificates` | Achievements | certificate_id, name, organization, issue_date |
| `contact_messages` | Contact submissions | message_id, sender_name, email, message, status |
| `experience` | Work history | experience_id, company, job_title, dates |
| `portfolio_stats` | Visitor analytics | stat_id, visitor_ip, page_visited, visit_date |

---

## 📱 Responsive Design

| Device | Breakpoint | Features |
|--------|-----------|----------|
| Desktop | 1200px+ | Full layout, all features visible |
| Tablet | 768px - 1199px | Adjusted grid, optimized spacing |
| Mobile | 480px - 767px | Single column, hamburger menu |
| Small Phone | < 480px | Minimal UI, touch-friendly |

---

## 🔐 Security Features

- ✅ **SQL Injection Prevention** - Parameterized queries
- ✅ **XSS Protection** - Input sanitization with htmlspecialchars()
- ✅ **CSRF Protection** - Token-based validation
- ✅ **Spam Detection** - Keyword filtering and rate limiting
- ✅ **Secure Headers** - CORS, X-Frame-Options, CSP headers
- ✅ **Sensitive File Protection** - .htaccess rules prevent access to config files
- ✅ **Password Security** - Bcrypt hashing for stored passwords

---

## 📈 Performance Optimizations

- 🚀 Browser caching (30-365 days by file type)
- 🗜️ Gzip compression for assets
- 📦 Lazy loading support for images
- 📊 Database query optimization with indexes
- 🎯 CSS/JS minification ready
- 🔄 Smooth scrolling and animations

---

## 🎨 Customization

### Colors
Edit CSS variables in `styles.css`:
```css
:root {
    --primary-color: #2f6f4e;
    --secondary-color: #7fb069;
    --accent-color: #b5d99c;
}
```

### Content
Update your information in:
- `index.html` - Main content
- `config.php` - Owner information and database credentials
- `database.sql` - Sample data

### Branding
Replace:
- Logo in navbar (modify HTML)
- Favicon in `<head>`
- Social media links
- Contact information

---

## 📖 Usage

### Viewing the Portfolio
1. Open `index.html` in any browser (works offline)
2. Click navigation links to explore sections
3. Submit contact form to send emails (requires PHP server)

### Admin Dashboard
Access at `/admin/dashboard.html` to:
- View contact messages
- Add education records
- Add projects
- View statistics

### Using the API
Call endpoints from JavaScript:
```javascript
// Example: Load projects
const projects = await fetch('/api/portfolio.php?action=projects')
  .then(r => r.json())
  .then(d => d.data);

console.log(projects);
```

---

## 🐛 Troubleshooting

### Issue: Contact form not sending emails
**Solution**: 
1. Ensure PHP server is running
2. Enable SMTP in `config.php`
3. Check error logs in `portfolio_errors.log`

### Issue: Database connection error
**Solution**:
1. Verify MySQL server is running
2. Check credentials in `config.php`
3. Ensure `portfolio_janagani` database exists

### Issue: API endpoints returning 404
**Solution**:
1. Verify `.htaccess` is in root directory
2. Ensure mod_rewrite is enabled on server
3. Check that `api/` folder exists

### Issue: Website not responsive
**Solution**:
1. Clear browser cache (Ctrl+Shift+Delete)
2. Check viewport meta tag in `index.html`
3. Test in Chrome DevTools (F12 → Device Toolbar)

---

## 📝 Portfolio Contents

### Education
- 🎓 **Bachelor of Technology** - Mohan Babu University (2023-2027) - 91.6%
- 📚 **Intermediate** - Narayana Junior College (2021-2023) - 95.8%
- 🏫 **Secondary School** - Sree Vidyanikethan E.M High School (2020-2021) - 95%

### Skills (7 Technologies)
- Java Programming (85%)
- C Programming (80%)
- HTML5 (90%)
- CSS3 (88%)
- JavaScript (85%)
- MySQL (82%)
- Microsoft Excel (80%)

### Projects
- **Medi-Aid** - Emergency Medical Information System (HTML, CSS, JS)
- [View on GitHub](https://github.com/JanaganiNavadeep/Mediaid-emergency-care)

### Certifications (4)
- Web Development Certification - Mohan Babu University
- Winzera Company Membership Certificate
- Hackathon Participation Certificate
- Introduction to MS Excel - Simplilearn SkillUp

---

## 🤝 Contributing

This is a personal portfolio project, but feel free to:
- Fork the repository
- Customize it for your own portfolio
- Submit improvements via pull requests
- Report issues

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 📞 Contact

- **Email**: janaganinavadeep7@gmail.com
- **Phone**: +91-9963363474
- **LinkedIn**: [Janagani Navadeep](https://linkedin.com/in/janagani-navadeep)
- **GitHub**: [@JanaganiNavadeep](https://github.com/JanaganiNavadeep)

---

## 🌟 Acknowledgments

- Font Awesome for icons
- Google Fonts for typography
- Open source community for tools and libraries

---

## 📚 Additional Resources

- [START_HERE.md](START_HERE.md) - Quick start guide
- [SETUP.md](SETUP.md) - Detailed setup instructions
- [FILES_SUMMARY.md](FILES_SUMMARY.md) - File descriptions
- [database.sql](database.sql) - Database schema

---

**Last Updated**: June 2024  
**Version**: 1.0  
**Status**: ✅ Production Ready

---

Made with ❤️ by Janagani Navadeep
