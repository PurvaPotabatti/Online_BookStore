# Bookly - Professional Online Bookstore

A clean, corporate-style online bookstore built with modern web technologies and professional design principles.

## 🎨 **Professional Design Features**

### **Color Scheme**
- **Primary Blue**: `#3498db` - Professional, trustworthy blue
- **Secondary Blue**: `#2980b9` - Darker blue for accents and hover states
- **Sidebar**: `#E8E0E1` - Your requested light color with professional gradient
- **Text**: `#2c3e50` - Dark, readable text for excellent contrast
- **Backgrounds**: Clean whites and light grays for professional appearance

### **Design Principles**
- **Clean Typography**: Segoe UI font family for professional readability
- **Subtle Shadows**: Minimal shadows for depth without distraction
- **Consistent Spacing**: Uniform padding and margins throughout
- **Professional Gradients**: Subtle blue gradients for buttons and highlights
- **Responsive Design**: Mobile-friendly with professional mobile sidebar

## 🚀 **Features**

### **User Management**
- Secure user registration and authentication
- Password hashing with Argon2id
- Session management
- Input validation and sanitization

### **Book Management**
- Dynamic book catalog with categories
- Professional book cards with hover effects
- Search and filtering capabilities
- Rating system

### **Shopping Features**
- Shopping cart functionality
- Order management system
- Secure checkout process

## 🛠 **Technology Stack**

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Server**: Apache/Nginx with XAMPP support

## 📋 **Installation & Setup**

### **Prerequisites**
- XAMPP, WAMP, or similar local server
- PHP 7.4 or higher
- MySQL 5.7 or higher

### **Setup Steps**

1. **Clone/Download** the project to your web server directory
2. **Start** your local server (XAMPP, WAMP, etc.)
3. **Run Database Setup**: Visit `setup_database.php` in your browser
4. **Verify Installation**: Check that all tables are created successfully
5. **Test Signup**: Try creating a new account

### **Database Configuration**
The system will automatically create:
- `users` - User accounts and authentication
- `books` - Book catalog and inventory
- `orders` - Order management
- `order_items` - Order details
- `cart` - Shopping cart functionality

## 🎯 **Key Pages**

- **Home** (`index.html`) - Main landing page with book showcase
- **Sign Up** (`signup.html`) - User registration
- **Sign In** (`signin.html`) - User authentication
- **Categories** - Fiction, Non-Fiction, Children, Comics, Technology
- **About** - Company information
- **Contact** - Contact form and information
- **FAQ** - Frequently asked questions

## 🔒 **Security Features**

- **SQL Injection Protection**: Prepared statements
- **XSS Prevention**: Input sanitization
- **Password Security**: Strong hashing algorithms
- **Session Management**: Secure user sessions
- **Input Validation**: Comprehensive form validation

## 📱 **Responsive Design**

- **Desktop**: Full-featured layout with sidebar navigation
- **Tablet**: Optimized for medium screens
- **Mobile**: Collapsible sidebar with touch-friendly interface

## 🎨 **Customization**

### **Colors**
To modify the color scheme, update these CSS variables in `style.css`:
```css
/* Primary Colors */
--primary-blue: #3498db;
--secondary-blue: #2980b9;
--sidebar-color: #E8E0E1;
--text-color: #2c3e50;
```

### **Typography**
The system uses Segoe UI for a professional appearance. To change fonts, update the `font-family` property in the body selector.

## 🚀 **Performance Optimizations**

- **CSS Optimization**: Minimal, efficient CSS
- **Image Optimization**: Optimized book cover images
- **Database Indexing**: Proper database indexes for fast queries
- **Caching**: Session-based caching for user data

## 📞 **Support**

For technical support or customization requests, please refer to the contact page or create an issue in the project repository.

## 📄 **License**

This project is developed for educational and commercial use. Please ensure compliance with any third-party assets or libraries used.

---

**Bookly** - Professional Online Bookstore Solution
*Built with modern web standards and professional design principles*

