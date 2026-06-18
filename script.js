// ============================================
// PROFESSIONAL PORTFOLIO - JAVASCRIPT
// ============================================

// DOM Elements
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
const navLinks = document.querySelectorAll('.nav-link');
const heroSection = document.querySelector('.hero');
const contactForm = document.getElementById('contactForm');

// ============================================
// HAMBURGER MENU TOGGLE
// ============================================

hamburger.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    hamburger.classList.toggle('active');
});

// Close menu when a link is clicked
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('active');
        hamburger.classList.remove('active');
    });
});

// ============================================
// NAVBAR SCROLL EFFECT
// ============================================

let lastScrollTop = 0;
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', () => {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > 100) {
        navbar.style.boxShadow = '0 5px 20px rgba(124, 58, 237, 0.1)';
    } else {
        navbar.style.boxShadow = 'none';
    }
    
    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
});

// ============================================
// ANIMATED BACKGROUND STARS
// ============================================

function createStars() {
    const heroContent = document.querySelector('.hero');
    const starContainers = ['.stars', '.stars2', '.stars3'];
    
    starContainers.forEach(containerClass => {
        const container = document.querySelector(containerClass);
        for (let i = 0; i < 50; i++) {
            const star = document.createElement('div');
            star.style.position = 'absolute';
            star.style.width = Math.random() * 3 + 'px';
            star.style.height = star.style.width;
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.backgroundColor = '#fff';
            star.style.borderRadius = '50%';
            star.style.opacity = Math.random();
            star.style.animation = 'twinkle ' + (Math.random() * 3 + 1) + 's infinite';
            container.appendChild(star);
        }
    });
}

window.addEventListener('load', createStars);

// ============================================
// SCROLL ANIMATIONS
// ============================================

const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all sections
document.querySelectorAll('section').forEach(section => {
    section.style.opacity = '0';
    section.style.transform = 'translateY(20px)';
    section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(section);
});

// ============================================
// SMOOTH SCROLL TO SECTIONS
// ============================================

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ============================================
// CONTACT FORM HANDLING
// ============================================

const portfolioPreviewLink = document.getElementById('previewPortfolioLink');
const portfolioPreviewModal = document.getElementById('portfolioPreviewModal');
const portfolioPreviewClose = document.getElementById('portfolioPreviewClose');
const portfolioPreviewContent = document.getElementById('portfolioPreviewContent');

if (contactForm) {
    contactForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const name = this.querySelector('input[name="name"]').value.trim();
        const email = this.querySelector('input[name="email"]').value.trim();
        const message = this.querySelector('textarea[name="message"]').value.trim();
        
        if (!name || !email || !message) {
            showNotification('Please fill in all fields', 'error');
            return;
        }
        
        if (!isValidEmail(email)) {
            showNotification('Please enter a valid email', 'error');
            return;
        }

        if (window.location.protocol === 'file:') {
            // Fallback for local file preview: save the message to localStorage so the form appears to work
            try {
                const demoKey = 'demo_contact_messages';
                const existing = JSON.parse(localStorage.getItem(demoKey) || '[]');
                existing.push({ name, email, message, timestamp: new Date().toISOString() });
                localStorage.setItem(demoKey, JSON.stringify(existing));
                showNotification('Saved locally (demo). To actually send messages, run the site via a PHP server.', 'success');
                this.reset();
            } catch (err) {
                console.error('Local fallback failed:', err);
                showNotification('Unable to save message locally.', 'error');
            }
            return;
        }

        try {
            const formData = new URLSearchParams();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('message', message);

            const response = await fetch('./api/contact.php', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            let result = null;

            try {
                result = JSON.parse(text);
            } catch (parseError) {
                console.error('Contact form response was not JSON:', text);
            }

            if (!response.ok) {
                const messageText = result?.message || `Server returned ${response.status}: ${response.statusText}`;
                showNotification(messageText, 'error');
                return;
            }

            if (!result) {
                showNotification('Invalid server response. Check your PHP server.', 'error');
                return;
            }

            if (result.status === 'success') {
                this.reset();
                return;
            }

            showNotification(result.message || 'Unable to send your message.', 'error');
        } catch (error) {
            console.error('Contact form submission failed:', error);
            showNotification('Unable to send your message right now. Please try again later.', 'error');
        }
    });
}

// Portfolio preview modal handling
function openPortfolioPreview() {
    if (!portfolioPreviewModal || !portfolioPreviewContent) {
        return;
    }

    portfolioPreviewModal.classList.add('open');
    portfolioPreviewModal.setAttribute('aria-hidden', 'false');
    portfolioPreviewContent.textContent = 'Loading featured project details...';

    fetch('./api/portfolio.php?action=projects&featured=true')
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success' || !Array.isArray(data.data)) {
                throw new Error(data.message || 'Unable to load portfolio preview.');
            }

            if (data.data.length === 0) {
                portfolioPreviewContent.textContent = 'No featured projects are available at this time.';
                return;
            }

            portfolioPreviewContent.innerHTML = data.data.map(project => {
                return [
                    `Project: ${project.project_name || 'Untitled'}`,
                    `Description: ${project.project_description || 'No description available.'}`,
                    `Technologies: ${project.technologies || 'N/A'}`,
                    `Repository: ${project.repository_url || 'Not available'}`
                ].join('\n');
            }).join('\n\n---\n\n');
        })
        .catch(error => {
            console.error(error);
            portfolioPreviewContent.textContent = 'Unable to load portfolio preview right now. Please try again later.';
        });
}

function closePortfolioPreview() {
    if (!portfolioPreviewModal) {
        return;
    }

    portfolioPreviewModal.classList.remove('open');
    portfolioPreviewModal.setAttribute('aria-hidden', 'true');
}

if (portfolioPreviewLink) {
    portfolioPreviewLink.addEventListener('click', (e) => {
        e.preventDefault();
        openPortfolioPreview();
    });
}

if (portfolioPreviewClose) {
    portfolioPreviewClose.addEventListener('click', closePortfolioPreview);
}

if (portfolioPreviewModal) {
    portfolioPreviewModal.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal-backdrop')) {
            closePortfolioPreview();
        }
    });
}

// ============================================
// UTILITY FUNCTIONS
// ============================================

// Validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Show notification message
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        padding: 1rem 2rem;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        z-index: 2000;
        animation: slideIn 0.3s ease;
        font-weight: 600;
    `;
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Add animation keyframes if not already present
    if (!document.querySelector('style[data-notifications]')) {
        const style = document.createElement('style');
        style.setAttribute('data-notifications', 'true');
        style.textContent = `
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(100px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes slideOut {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(100px);
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Remove notification after 4 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// ============================================
// ACTIVE LINK HIGHLIGHTING
// ============================================

window.addEventListener('scroll', () => {
    let current = '';
    const sections = document.querySelectorAll('section');
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').slice(1) === current) {
            link.style.color = 'var(--secondary-color)';
        } else {
            link.style.color = 'var(--text-secondary)';
        }
    });
});

// ============================================
// SKILL PROGRESS ANIMATION
// ============================================

function animateProgressBars() {
    const progressBars = document.querySelectorAll('.progress');
    
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        
        // Use requestAnimationFrame for smooth animation
        setTimeout(() => {
            bar.style.transition = 'width 1.5s ease';
            bar.style.width = width;
        }, 100);
    });
}

// Trigger progress bar animation when skills section is in view
const skillsSection = document.querySelector('.skills');
let skillsAnimated = false;

if (skillsSection) {
    const skillsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !skillsAnimated) {
                animateProgressBars();
                skillsAnimated = true;
                skillsObserver.unobserve(skillsSection);
            }
        });
    }, { threshold: 0.5 });
    
    skillsObserver.observe(skillsSection);
}

// ============================================
// COUNTER ANIMATION FOR STATISTICS
// ============================================

function animateCounter(element, target, duration = 2000) {
    const start = 0;
    const range = target - start;
    const increment = range / (duration / 50);
    let current = start;
    
    const counter = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(counter);
        }
        element.textContent = Math.floor(current);
    }, 50);
}

// Animate stat cards when they come into view
const statCards = document.querySelectorAll('.stat-number');
let statsAnimated = false;

const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !statsAnimated) {
            statCards.forEach(card => {
                const number = parseInt(card.textContent);
                if (!isNaN(number)) {
                    animateCounter(card, number);
                }
            });
            statsAnimated = true;
            statsObserver.disconnect();
        }
    });
}, { threshold: 0.5 });

if (statCards.length > 0) {
    statsObserver.observe(statCards[0].closest('.stat-card'));
}

// ============================================
// PAGE LOAD ANIMATIONS
// ============================================

window.addEventListener('load', () => {
    // Fade in hero content
    const heroContent = document.querySelector('.hero-content');
    if (heroContent) {
        heroContent.style.opacity = '1';
    }
});

// ============================================
// MOBILE MENU IMPROVEMENTS
// ============================================

// Close menu when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.navbar')) {
        navMenu.classList.remove('active');
        hamburger.classList.remove('active');
    }
});

// Prevent menu from closing when clicking inside it
document.querySelector('.nav-menu')?.addEventListener('click', (e) => {
    e.stopPropagation();
});

// ============================================
// THEME TOGGLE FUNCTIONALITY (Optional)
// ============================================

function initThemeToggle() {
    // Check for saved theme preference or default to 'dark'
    const currentTheme = localStorage.getItem('theme') || 'dark';
    
    // You can expand this to support light mode
    // document.documentElement.setAttribute('data-theme', currentTheme);
}

initThemeToggle();

// ============================================
// PERFORMANCE OPTIMIZATION
// ============================================

// Lazy loading for images (if any are added)
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                imageObserver.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// ============================================
// KEYBOARD NAVIGATION
// ============================================

document.addEventListener('keydown', (e) => {
    // Close menu with Escape key
    if (e.key === 'Escape') {
        navMenu.classList.remove('active');
        hamburger.classList.remove('active');
    }
});

// ============================================
// PRINT STYLESHEET SUPPORT
// ============================================

const printStyle = document.createElement('style');
printStyle.textContent = `
    @media print {
        .navbar, .hero-buttons {
            display: none !important;
        }
        
        body {
            background: white;
            color: black;
        }
        
        section {
            page-break-inside: avoid;
        }
    }
`;
document.head.appendChild(printStyle);

console.log('Portfolio initialized successfully!');
