<<<<<<< HEAD
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
=======
# Online Bookstore - Backend Setup

This is a complete backend system for the Online Bookstore website with user authentication, book management, and shopping cart functionality.

## 🗄️ Database Schema

The system uses MySQL with the following tables:

- **categories**: Book categories (Fiction, Non-Fiction, Children, Comics, Technology)
- **users**: User accounts with authentication
- **books**: Book inventory with details
- **orders**: Customer orders
- **order_items**: Individual items in orders
- **cart**: Shopping cart for logged-in users

## 🚀 Setup Instructions

### 1. Prerequisites
- XAMPP installed and running
- PHP 7.4+ 
- MySQL 5.7+

### 2. Database Setup
1. Start XAMPP and ensure MySQL service is running
2. Open your browser and navigate to: `http://localhost/Online_BookStore/setup_database.php`
3. This will create the database and all necessary tables
4. Sample data will be automatically inserted

### 3. Test Database Connection
1. Navigate to: `http://localhost/Online_BookStore/test_db.php`
2. Verify all tables are created and sample data is loaded

## 📁 File Structure

```
Online_BookStore/
├── db_connect.php          # Database connection
├── setup_database.php      # Database setup script
├── test_db.php            # Database connection test
├── signup.php             # User registration backend
├── signin.php             # User authentication backend
├── logout.php             # User logout
├── api/
│   ├── books.php          # Books API endpoint
│   ├── categories.php     # Categories API endpoint
│   └── cart.php           # Shopping cart API
├── index.html             # Main homepage
├── signup.html            # Registration page
├── signin.html            # Login page
└── style.css              # Styling
```

## 🔐 Authentication System

### User Registration
- Username: 3+ characters, unique
- Email: Valid format, unique
- Password: 6+ characters
- Password confirmation required

### User Login
- Login with username or email
- Secure password hashing
- Session management

## 📚 Book Management

### Features
- Book listing with categories
- Search functionality
- Stock management
- Rating system
- Image support

### Sample Books Included
- The Midnight Library
- The Kite Runner
- Sapiens
- Man's Search for Meaning
- Quiet
- The Innovators
- Atomic Habits
- Thinking, Fast and Slow

## 🛒 Shopping Cart

### Features
- Add/remove books
- Quantity management
- User-specific carts
- Stock validation

## 🌐 API Endpoints

### Books API
- `GET api/books.php` - Get all books
- `GET api/books.php?category=1` - Get books by category
- `GET api/books.php?search=keyword` - Search books

### Categories API
- `GET api/categories.php` - Get all categories

### Cart API
- `POST api/cart.php?action=add` - Add item to cart
- `GET api/cart.php?action=get` - Get cart items
- `POST api/cart.php?action=update` - Update cart item
- `POST api/cart.php?action=clear` - Clear cart

## 🔧 Configuration

### Database Settings
Edit `db_connect.php` to modify:
- Host: `localhost`
- Database: `online_bookstore`
- Username: `root`
- Password: `` (empty for XAMPP default)

## 🧪 Testing

1. **Database Test**: `test_db.php`
2. **User Registration**: `signup.html`
3. **User Login**: `signin.html`
4. **API Testing**: Use browser or Postman

## 🚨 Troubleshooting

### Common Issues
1. **Connection Failed**: Ensure XAMPP MySQL service is running
2. **Database Not Found**: Run `setup_database.php` first
3. **Permission Denied**: Check MySQL user permissions
4. **Table Errors**: Verify database setup completed successfully

### Error Messages
- Check browser console for JavaScript errors
- Check XAMPP error logs
- Verify file paths and permissions

## 📱 Frontend Integration

The backend is designed to work with the existing frontend:
- AJAX calls for dynamic content
- JSON responses for API endpoints
- Session-based authentication
- Responsive design support

## 🔒 Security Features

- Password hashing with `password_hash()`
- Prepared statements to prevent SQL injection
- Input validation and sanitization
- Session management
- CSRF protection ready

## 🚀 Next Steps

After setup:
1. Test user registration and login
2. Verify book listing works
3. Test shopping cart functionality
4. Customize categories and books as needed
5. Add additional features like order processing

## 📞 Support

If you encounter issues:
1. Check XAMPP status
2. Verify database connection
3. Review error logs
4. Test individual components

---

**Happy Coding! 📚✨**
>>>>>>> 0253efdf1da9db7ef4d063ebb005b59d86c3e734

