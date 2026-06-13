## 1. Group Members (BIIT 2305 - Sect 2)
* PUTRI AIRISYA IRWAYU BINTI MEGAT MOHD SHUKRI (2328526)
* NUR AINUL MARDHIAH BINTI MUHAMMAD SAFWAN (2324500)
* NUR ATHIRAH AMNI BINTI ZAILANI (2416156)
* RASHINA BINTI RAFEEK (2416522)
* SITI ROSDIYANAH BINTI IDRIS (2415502)

## 2. Project Overview
The Bakery Management System is a web-based application developed using Laravel to streamline bakery operations. The system enables customers to browse bakery products, place orders, manage shopping carts and make table reservations. It also provides administrators with tools to manage products, monitor customer orders, oversee reservations and track order delivery statuses through a centralized dashboard.

## 3. Project Objectives
* To develop a web-based bakery management system using Laravel and the MVC architecture.
* To implement secure user authentication and role-based access control for customers and administrators.
* To provide complete CRUD functionality for managing bakery products and order processing.
* To create a user-friendly interface that improves operational efficiency for bakery staff and customers.

## 4. Target Users
* **Customers:** Authenticated end-users who browse the halal-certified product catalogue (cookies and pastries), manage their shopping cart, choose fulfillment methods (delivery or self-pickup), and track their order histories.
* **Administrators (Admin):** Management users holding the highest access levels to run system CRUD operations, manage menu items (pricing, descriptions, halal status), track lifecycle order stages (Pending, Preparing, Completed), and review real-time sales summaries via the dashboard.

## 5. Features and Functionalities
**Customer Features:**
* User Registration & Login: Secure account creation and role-based login built using Laravel Jetstream.
* Product Browsing: View available bakery items that organized with descriptions, images and prices.
* Shopping Cart System: Dynamically add items to the cart, adjust quantities or remove bakery goods before finishing a transaction.
* Order Placement & Confirmation: Secure checkout that saves transactions directly to the system database and delivers an order confirmation receipt.
* Table Reservation: Customers can reserve a table by providing their name, phone number, number of guests, preferred date, and reservation time. Reservation details are stored in the database for administrative review.

**Admin Features:**
* Admin Dashboard & Reporting: Real-time visibility into tracking total customer users, total foods sold, total orders and delivered product.
* Product Management (CRUD): Full authority to add new items to the catalogue, upload product photos, update pricing/descriptions, or delete retired recipes.
* Order Management: Oversee incoming requests and systematically update order fulfillment workflows from *Pending* to *On the way* or even *cancel* in real time.
* Table Reservation Management: View and manage customer table reservations, including customer phone numbers, number of guests, reservation dates, and reservation times.

## 6. Tech Stack & Requirements
* **Framework:** Laravel (PHP)
* **Database:** MySQL
* **Local Server:** XAMPP / Apache
* **Frontend:** Blade Templates, Bootstrap / CSS
  
## 7. Database Design & Key Relationships
**Database Schema Overview**
Our database consists of **16 tables** designed to handle user authentication, products and order records that fully supporting the system's requirements:

**Core Application Tables:**
* users – Stores user email, name, phone number, id and role definitions (Admin vs. Customer) that managed via Laravel Jetstream.
* food – Holds product display (e.g., Cookies) like title, price, details and uploading image to ensure systematic food organization.
* orders – Records customer transactions, storing total quantity, amount, delivery status, payment status, changing status. 
* book – Stores customer table reservation details including customer name, phone number, number of guests and date.

**Laravel System Tables:**
* migrations – Tracks database schema versions and structural modifications.
* failed_jobs – Logs any background queue actions or asynchronous operations that failed.
* password_reset_tokens – Stores secure, temporary tokens used for the account password recovery flow.

**Entity Relationship Diagram (ERD):**
[https://docs.google.com/document/d/1028O5yPoMcmtIEJNZl8K9L12L-x8kHVW8fdmnf2-XnM/edit?usp=sharing](url)

* Users to Orders (One-to-Many): A registered customer can place multiple cookie orders, but each individual order belongs to exactly one user.
* Food to Orders (One-to-Many): A bakery product can appear in multiple customer orders, while each order record references a specific product.
* Users to Book (One-to-Many): A customer can create multiple table reservations, while each reservation belongs to a single customer.
* Users to Food (One-to-Many): Administrators can manage multiple bakery products through Create, Read, Update and Delete (CRUD) operations.

## 8. Laravel Components Implementation 
**Routes(Web.php)**
* **HOME ROUTES**
```
Route::get('/', [HomeController::class, 'my_home']);
Route::get('/home', [HomeController::class, 'index']);
```

* **ADMIN FOOD ROUTES**
```
Route::get('/add_product', [AdminController::class, 'add_product']);
Route::post('/upload_food', [AdminController::class, 'upload_food']);
Route::get('/view_product', [AdminController::class, 'view_product']);
Route::get('/delete_product/{id}', [AdminController::class, 'delete_product']);
Route::get('/update_product/{id}', [AdminController::class, 'update_product']);
Route::post('/edit_product/{id}', [AdminController::class, 'edit_product']);
```

* **USER CART & ORDER ROUTES**
```
Route::post('/add_cart/{id}', [HomeController::class, 'add_cart']);
Route::get('/my_cart', [HomeController::class, 'my_cart']);

// Route to handle removing an item from the cart
Route::get('/remove_cart/{id}', [HomeController::class, 'remove_cart']);

// Route to process moving cart data into the orders table (Tutorial #14)
Route::post('/confirm_order', [HomeController::class, 'confirm_order']);

// Route for the adminPage (Tutorial 16)
Route::get('/orders', [AdminController::class, 'orders']);

// Route adminPage for on the way (Tutorial 17)
Route::get('on_the_way/{id}', [AdminController::class, 'on_the_way']);

// Route adminPage for delivered(Tutorial 17)
Route::get('delivered/{id}', [AdminController::class, 'delivered']);

// Route adminPage for cancel(Tutorial 17)
Route::get('cancel/{id}', [AdminController::class, 'cancel']);

// Route for the userPage (Tutorial 18)
Route::post('/book_table', [HomeController::class, 'book_table']);
```

**Controllers**
  1. **HomeController:** Handles all customer-facing functionalities of the Bakery Management System. This includes displaying the homepage, browsing bakery products, managing the shopping cart, processing customer orders, handling table reservations and allowing customers to view their order information.
  
  2. **AdminController:** Manages all administrative functionalities of the system. This includes performing CRUD operations for bakery products (Create, Read, Update, Delete), managing customer orders, updating delivery statuses (On the Way, Delivered, Cancelled) and reviewing customer table reservations.

**Models and Relationships**

**CART.PHP**
```
<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{use HasFactory;
    protected $fillable = [
        'title',
        'details',
        'price',
        'image',
        'quantity',
    ];}
```
**FOOD.PHP**
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'detail',
        'price',
        'image',
    ];
}
```
**ORDER.PHP**
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'title',
        'price',
        'quantity',
        'image',
        'delivery_status',
        'payment_status',
    ];
}
```
**USER.PHP**
```
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    / @use HasFactory<UserFactory> */
    use HasFactory;

    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address'
    ];

    /
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```
**Views and User Interface**

Blade Templates Structure:
- `layouts/app.blade.php` - Main application layout containing shared navigation menus, authentication components and page structure.
- `home.blade.php` - Public store landing page displaying the bakery catalog, featured cookies/pastries, and the custom table booking form.
- `my_cart.blade.php` - Shopping cart page where customers can review selected items, update quantities, remove products and confirm orders.
- `admin/orders.blade.php` - Order management page where administrators can view customer orders and update delivery statuses.
- `admin/add_product.blade.php` - Admin interface used to add new bakery products, including title, description, price and image upload.
- 'admin/show_food.blade.php' – Product management page displaying all products with Update and Delete functionalities.

Design Features:
- *Responsive User Interface*: Developed using Bootstrap and Blade Templates to ensure compatibility across desktop.
- *Role-Based Navigation*: Different menus and functionalities are displayed based on whether the user is an Administrator or Customer.
- *Interactive CRUD Operations*: Administrators can efficiently manage bakery products through Create, Read, Update and Delete operations.
- *Shopping Cart & Order Processing*: Customers can add products to the cart, modify quantities and place orders through an intuitive interface.
- *Table Reservation System*: Customers can submit reservation requests, while administrators can review and manage booking records.

**User Authentication System**

Authentication Feature:
* **Registration System:** Allows new users to create accounts securely using Laravel Jetstream.
* **Login System:** Protected authentication login interface processing user credentials with direct support for session token persistence.
* **Password Reset:** Provides account recovery functionality for users who forget their passwords (in the future).
* **Role-Based Access Control (RBAC):** Separates customer and administrator privileges to protect administrative functionalities.
* **Profile Management:** Allows authenticated users to manage and update their account information.
  
**Security Measures : **
* **Password Encryption:** All password strings are fully encrypted and hashed using Laravel's built-in cryptographic hashing (`bcrypt`) prior to database insertion.
* **Cross-Site Request Forgery (CSRF) Protection:** Laravel automatically generates CSRF tokens to protect forms from unauthorized requests.
* **Input Validation & Sanitization:** Server-side validation rules enforced across input fields to clean incoming text, ensure proper pricing values, and prevent data corruption during store uploads.
* **Route Middleware Protection:** Authentication middleware restricts access to protected routes and prevents unauthorized access to administrative pages.

## 📹 9. Demo Video Link
* 🔗 [Watch Our Project Presentation & Demo Video Here](https://youtu.be/6lxmO-devk8)

## Installation and Setup Instructions
* **Prerequisites :**
* PHP >= 8
* Composer
* Node.js and NPM
* MySQL 8
* XAMPP

## Step-by-step Installation
1. Clone the Repository
bash/n git clone https://github.com/ainulsfwn/bakery-management-system-main

2. Install Dependencies
bashcomposer install npm install

3. Enviroment Configuration
bashcp.env.example.env php artisan key:generate

4. Database Setup
bash#Configure database in .env file artisan migrate php artisan db:bakery_db

5. Start Development Server
bashphp artisan serve npm run dev

## Testing and Quality Assurance
* **Functionality Testing**

USER FUNCTIONALITY TESTING 
* User registration and login system
* Product browsing and review
* Shopping cart add/remove functionality
* Order placement and confirmation
* Table reservation submission

ADMIN FUNCTIONALITY TESTING
* Admin registration and login system
* Product management (Create, Read, Update, Delete)
* Order management
* Delivery status updates (On the Way, Delivered, Cancelled)
* Reservation management
* Viewing customer table reservation
  
## Browser Compatibility
* Google Chrome
* Microsoft Edge

## Performance Testing

* Page load time maintained below 3 seconds under normal usage
* Image upload optimization for faster loading
* Database query optimization for improved performance
* Responsive design testing across desktop.
  
## Challenges Faced and Solutions

Challenge 1: Transferring Data from Cart to Orders
* Problem: When a customer completed the checkout process, all selected products needed to be transferred from the temporary cart table into the orders table while ensuring duplicate orders were not created.
* Solution: Used a laravel foreach loop in the controller to grab every item from the user's cart, save a copy into the orders table and the delete it from the cart.

Challenge 2: Preventing Accidental Order Status Changes
* Problem: The admin needs to update status, but we had to prevent accidental clicks that change a status by mistake.
* Solution: Created separate routes for each function in the controller and added a Javascript confirmation popup (onclick="return confirm(..)") to ask "Are You Sure?" before changing the database.

Challenge 3: Resolving Database and Code Mismatches
* Problem: During development, several application errors occurred because database column names did not always match the variable names used within the Laravel controllers and Blade templates.
* Solution: Laravel's debugging tools and error messages were used to identify problematic files and code sections.

Challenge 4: Image Upload and Storage Management
* Problem: Uploaded product images were not displaying correctly because image paths and storage locations were not configured consistently.
* Solution: A dedicated food_images directory was created within the public folder. Uploaded files were assigned unique names using timestamps, stored correctly and linked to the corresponding product records in the database.

## Future Enhancements
Phase 2 features (Potential Improvements)

* **Online Payment Integration :** Allow customers to pay using online banking, debit cards or e-wallets.
* **Iventory Management System :** Automatically track ingredient stock level and notify admins when supplies are low.
* **Customer Reviews and Rating :** Enable customers to rate bakery products and provide feedback
* **Mobile Friendly Application :** Develop a dedicated mobile application for Android and IOS users
* **Loyalty and Reward Program :** Provide points or discounts for returning customers to encourage repeat purchases.
* **Email Verification and Password Recovery:** Implement email verification and secure password reset functionality to improve account security and user authentication.
* **User's Order History and Order Tracking:** Provide customers with a dedicated dashboard to view previous purchases, review order history and track the status of current orders in real time (in process, completed or cancel).

## Scalability CONSIDERATION

* **Database optimization for larger datasets :** Optimizing MySQL queries and implementation indexing to handle growing volume of customer orders, menu items and table booking smoothly
* **Caching implementation for improved performance :** Utilizing caching solution to store frequently accessed data like bakery menus, reducing the database load during peak hours.
* **API development for mobile app integration :** Developing secure RESTful APIs using laravel to allow future integration with native ios/Android mobile applications or third-party delivery services
* **Load balancing for high traffic scenarios :** Planning for multi-server load balancers to distribute web traffic evenly, ensuring the system remains online during high-demand periods like festive seasons

## Learning Outcomes

* **Technical Skills Gained**
  
* **Laravel Framework & MVC Architecture :** Understand the Model-View-Controller(MVC) structure and routing system management properly.
* **User Authentication System :** Successfully implement secure login & registration functions and role divison(Admin & Customer) using Laravel Breeze
* **Complete CRUD Operation Development :** Proficient in building CRUD functions for bakery menu management, order status, updates, delete and table booking system
* **Databased Design(MySQL) :** Learn how to design relational database tables and manage them through Laravel Migrations
* **Responsive Frontend(Blade & Bootstrap :** Able to build user-friendly and responsive interface(UI) on various screen sizes using Blade Template and Bootstrap
* **Version Control(Git & GitHub):** Improve skills in managing, sharing and merging project code in groups using GitHub

* **Soft Skills Develop**

* **Group Collaboration :** Learn to divide tasks fairly and communicate effectively with group members in order to complete projects on time.
* **Problem Solving :** Improve critical thinking skills when detecting bugs(debugging) and finding logical solutions to erroneous code.
* **Time & Project Management :** Skilled in planning the system development phases in stages to ensure that all major bakery functions can be completed before deadline.
* **Documentation Skills:** Learn the importance of organizing technical documentation such as README file clearly, so that code is easy for others understand.

## References

1. W3Schools. (n.d.). W3Schools online web tutorials. Retrieved from https://www.w3schools.com/
2. Laravel Documentation. (2024). Laravel 10.x Documentation. Retrieved from https://laravel.com/docs/10.x
3. Bootstrap Documentation. (2024). Bootstrap 5.3 Documentation. Retrieved from https://getbootstrap.com/docs/5.3/getting-started/introduction/
4. Code With Dary. (2023, November 23). Laravel 10 tutorial for beginners - Full course [Video]. YouTube. Retrieved from https://youtu.be/nnD-D1MZC7Q?si=6A9IXA7t6eKYtRSK
5. phpMyAdmin. (n.d.). phpMyAdmin: Bring MySQL to the web. Retrieved from https://www.phpmyadmin.net/

## Conclusion

* The Bakery Management System successfully demonstrates the implementation of a comprehensive online bakery platform using the Laravel framework. The project showcase proficiency in web application fundamentals including MVC architecture, database design, user authentication and responsive web design.

## Key Achivements

* Successfully developed a functional Bakery Management System with dynamic features like product, order product and a table booking.
* Successfully separated the website into two layouts such as customer interface and a private management dashboard for the admin interface.
* Implemented full CRUD operations, allowing the admin to add, view, update and delete the products easily.
* Designed a clean and user-friendly interface using Bootstrap that looks good on laptop screens.
* Combined everyone's code smoothly using GitHub without losing files, allowing us to complete the project on time.

## Project Impact

* This project gave us great hands-on experience in full-stack web application. We did not just improve our coding skills, but we also learned how to work together as a team, solve coding errors and manage our time well. Professional web development scenarios can immediately benefit from the abilities acquired through this project.

* **Project Completion Date:** 11 June 2026
* Course:BIIT 2305 Web Application Development
