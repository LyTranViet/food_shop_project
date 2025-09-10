# Food Admin App

## Overview
The Food Admin App is a web application designed for administrators to manage food items in a database. It provides functionalities to add, edit, delete, and list food items, ensuring a streamlined process for managing food inventory.

## Features
- **Admin Login**: Secure login for administrators to access the application.
- **Add Food**: Form to add new food items with details such as name, description, price, and image URL.
- **Edit Food**: Ability to edit existing food items, updating their details as necessary.
- **Delete Food**: Functionality to remove food items from the database.
- **List Foods**: View all food items in the database with options to edit or delete.

## Project Structure
```
food-admin-app
├── src
│   ├── db.php               # Database connection logic
│   ├── admin_login.php      # Admin login functionality
│   ├── admin_add_food.php   # Add new food items
│   ├── admin_delete_food.php # Delete food items
│   ├── admin_edit_food.php  # Edit existing food items
│   ├── index.php            # Main entry point
│   └── foods
│       └── list.php         # List all food items
├── public
│   └── assets
│       └── styles.css       # CSS styles for the application
├── README.md                # Project documentation
```

## Setup Instructions
1. **Clone the Repository**: 
   ```bash
   git clone <repository-url>
   cd food-admin-app
   ```

2. **Database Configuration**: 
   - Update the `db.php` file with your database connection details.

3. **Run the Application**: 
   - Use a local server environment (like XAMPP or MAMP) to run the application.
   - Access the application via `http://localhost/food-admin-app/src/index.php`.

## Usage
- Navigate to the login page to access the admin functionalities.
- Use the provided forms to manage food items effectively.

## License
This project is open-source and available for modification and distribution under the MIT License.