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

