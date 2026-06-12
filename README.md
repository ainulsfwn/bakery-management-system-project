## 1. Group Members (BIIT 2305 - Sect 2)
* PUTRI AIRISYA IRWAYU BINTI MEGAT MOHD SHUKRI (2328526)
* NUR AINUL MARDHIAH BINTI MUHAMMAD SAFWAN (2324500)
* NUR ATHIRAH AMNI BINTI ZAILANI (2416156)
* RASHINA BINTI RAFEEK (2416522)
* SITI ROSDIYANAH BINTI IDRIS (2415502)

## 2. Project Overview
The Bakery Management System is a web-based application developed to streamline daily bakery operations. It provides an efficient platform for managing customer orders, tracking bakery inventories (such as cookies and pastry ingredients), and monitoring sales records. This system helps bakery owners manage and oversee shop operations more efficiently online.

## 3. Project Objectives
* To understand full-stack development by applying the MVC architecture and creating complete CRUD features for managing menus, orders, and table statuses via GitHub.
* To secure backend access using user authentication, supported by a relational database schema mapped accurately through ERD and Sequence Diagrams.
* To design an intuitive, easy-to-use interface for staff while ensuring all menu categories and operations strictly adhere to Islamic and halal standards.

## 4. Target Users
* **Customers:** Authenticated end-users who browse the halal-certified product catalogue (cookies and pastries), manage their shopping cart, choose fulfillment methods (delivery or self-pickup), and track their order histories.
* **Administrators (Admin):** Management users holding the highest access levels to run system CRUD operations, manage menu items (pricing, descriptions, halal status), track lifecycle order stages (Pending, Preparing, Completed), and review real-time sales summaries via the dashboard.

## 5. Features and Functionalities
**Customer Features:**
* User Registration & Login: Secure account creation, authentication, and role-based login built using Laravel Breeze.
* Halal-Certified Product Browsing: View available bakery items (cookies and pastries) organized by category with descriptions, images, and prices.
* Shopping Cart System: Dynamically add items to the cart, adjust quantities, or remove bakery goods before finishing a transaction.
* Fulfillment Method Selection: Choose between delivery or self-pickup at checkout, providing a delivery address and preferred time if delivery is chosen.
* Order Placement & Confirmation: Secure checkout that saves transactions directly to the system database and delivers an order confirmation receipt.
* Order History & Real-Time Status Tracking: Review comprehensive past order details and monitor active orders through lifecycle stages (*Pending, Preparing, and Completed*).

**Admin Features:**
* Admin Dashboard & Reporting: Real-time visibility into daily bakery performance metrics, tracking total revenue, active orders, and data-driven popular products.
* Menu Management (CRUD): Full authority to add new items to the catalogue, upload product photos, update pricing/descriptions, or delete retired recipes while setting their halal certification status.
* Order Lifecycle Management: Oversee incoming requests and systematically update order fulfillment workflows from *Pending* to *Preparing* and *Completed* in real time.
* Customer Account Management: Monitor registered customer profiles, review their cumulative order metrics, and track customer contact records.

## 6. Tech Stack & Requirements
* **Framework:** Laravel (PHP)
* **Database:** MySQL
* **Local Server:** XAMPP / Apache
* **Frontend:** Blade Templates, Bootstrap / CSS
  
## 7. Database Design & Key Relationships
**Database Schema Overview**
Our database consists of **8 tables** designed to handle user authentication, item categorization, menu details, and transactional order records, fully supporting the system's requirements:

**Core Application Tables:**
* users – Stores user credentials, contact information, and role definitions (Admin vs. Customer) managed via Laravel Breeze.
* categories – Holds food and beverage categories (e.g., Cookies, Pastries) to ensure systematic menu organization.
* menus – Contains details of bakery items, including product names, pricing, descriptions, stock availability, and image storage paths.
* orders – Records customer transactions, storing total amounts, chosen fulfillment methods (Delivery or Self-Pickup), specific delivery details, and order tracking statuses (*Pending, Preparing, Completed*).
* order_items – Acts as a pivot table that links orders to specific menus, keeping track of the chosen quantity and price for each item in a transaction.

**Laravel System Tables:**
* migrations – Tracks database schema versions and structural modifications.
* failed_jobs – Logs any background queue actions or asynchronous operations that failed.
* password_reset_tokens – Stores secure, temporary tokens used for the account password recovery flow.

**Entity Relationship Diagram (ERD):**
[https://docs.google.com/document/d/1028O5yPoMcmtIEJNZl8K9L12L-x8kHVW8fdmnf2-XnM/edit?usp=sharing](url)

* Users to Orders (One-to-Many): A registered customer can place multiple bakery orders, but each individual order belongs to exactly one user.
* Categories to Menus (One-to-Many): A specific category can contain various baked items, while each menu item is assigned to exactly one category.
* Orders to Order Items (One-to-Many): A single order record can contain multiple specific items, breakdown inside the `order_items` table.
* Menus to Order Items (One-to-Many): A specific menu item can appear across different customer order receipts.

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
  1. **HomeController:** Handles all public-facing and customer operations. This includes displaying the bakery landing page, filtering the menu by halal categories, managing the shopping cart session, processing the order checkout, and displaying the customer's real-time order tracking page.
  
  2. **AdminController:** Manages all restricted administrative and backend functionalities. This handles full CRUD operations for the bakery menu (adding, updating, and deleting items), tracking low stock levels, reviewing total sales summaries, and updating order lifecycle tracking statuses (*Pending, Preparing, Completed*).

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
- `layouts/app.blade.php` - Main application skeleton layout configured with responsive navigation bars.
- `home.blade.php` - Public store landing page displaying the bakery catalog, featured cookies/pastries, and the custom table booking form.
- `my_cart.blade.php` - Customer's dynamic shopping cart page summarizing selected bakery items, breakdown pricing metrics, and the checkout confirmation trigger.
- `admin/orders.blade.php` - Administrative master console for the bakery owner to oversee customer requests and update delivery life cycles (*On the way, Delivered, Cancel*).
- `admin/add_product.blade.php` - Administrative dashboard workspace for uploading new bakery items into the system with images, pricing, and description data.
- `admin/view_product.blade.php` - Master product inventory grid interface allowing administrators to update bakery item details or trigger product deletions (CRUD).

Design Features:
- **Responsive Architecture:** Built using standard CSS framework guidelines to ensure clean, mobile-first compatibility on smartphones, tablets, and desktop viewports.
- **Role-Based Layout Rendering:** Blade authentication components dynamically alter navigation bar menu options based on user access levels (Admin dashboard links vs. Customer storefront tools).
- **Interactive Core Elements:** Session-driven customer shopping cart updates, immediate validation error alerts, and intuitive confirmation triggers for custom table reservations.

**User Authentication System**

Authentication Feature:
* **Registration System:** Secure account creation handling unique user credentials, email logging, and automatic password confirmation fields.
* **Login System:** Protected authentication login interface processing user credentials with direct support for session token persistence.
* **Password Reset:** Secured fallback mechanisms allowing registered accounts to recover or update credentials when locked out.
* **Role-Based Access Control (RBAC):** Strict security boundaries separating access levels; verified customers are routed to the storefront checkout pages, while bakery administrators are directed to the main backend product management tools.
* **Profile Management:** Basic personalized configuration options letting active users oversee their core account data safely within the platform.

Security Measures :
* **Password Encryption:** All password strings are fully encrypted and hashed using Laravel's built-in cryptographic hashing (`bcrypt`) prior to database insertion.
* **Cross-Site Request Forgery (CSRF) Protection:** Active application state security tokens embedded automatically inside every frontend web form to block unauthorized third-party command executions.
* **Input Validation & Sanitization:** Server-side validation rules enforced across input fields to clean incoming text, ensure proper pricing values, and prevent data corruption during store uploads.
* **Route Middleware Protection:** Restrictive route middleware mapping implemented across `web.php` to immediately block unauthenticated access attempts and auto-redirect guests back to the safe login panel.

## 📹 9. Demo Video Link
* 🔗 [Watch Our Project Presentation & Demo Video Here](MASUKKAN_LINK_VIDEO_RAKAMAN_KUMPULAN)

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
* Bakery browsing and menu display
* Shopping cart add/remove functionality
* Order placement and confirmation
* User can do for booking table 

ADMIN FUNCTIONALITY TESTING
* Bakery owner menu management
* Admin user management
* Admin can add product
* Admin can view product
* Admin can update and delete the product
* Admin can change the status either status is 'On The Way', 'Delivered', 'Cancel'.
* Admin can view the reservation that customer book.

## Browser Compatibility

* Google Chrome
* Microsoft Edge

## Performance Testing

* Page load time unser 3 seconds
* Optimisation of database queries
* Implemented compression of image
* Testing responsive design across a range of screen size

## Challenges Faced and Solutions

Challenge 1: Transferring Data from Cart to Orders
* Problem: When a customer checks out, the system must copy multiple items from the temporary cart table into the permanent orders table and clear the cart immediately to prevent double charging.
* Solution: Used a laravel foreach loop in the controller to grab every item from the user's cart, save a copy into the orders table and the delete it from the cart.

Challenge 2: Managing Order Status Safely
* Problem: The admin needs to update status, but we had to prevent accidental clicks that change a status by mistake.
* Solution: Created separate routes for each function in the controller and added a Javascript confirmation popup (onclick="return confirm(..)") to ask "Are You Sure?" before changing the database.

Challenge 3: Troubleshooting Database & Code Mismatches
* Problem: Customizing the tutorial code into our bakery project caused bakend crashes because database column names and variables did not match perfectly.
* Solution: Read Laravel's error debugging screens to find the exact file names and broken lines of code, then fixed the column mismatches and syntax typos to stabilize the system.


## Future Enhancements
Phase 2 features (Potential Improvements)

* **Online Payment Integration :** Allow customers to pay using online banking, debit cards or e-wallets.
* **Iventory Management System :** Automatically track ingredient stock level and notify admins when supplies are low.
* **Customer Reviews and Rating :** Enable customers to rate bakery products and provide feedback
* **Mobile Friendly Application :** Develop a dedicated mobile application for Android and IOS users
* **Loyalty and Reward Program :** Provide points or discounts for returning customers to encourage repeat purchases.

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
* **Version Control(Git & GitHub): ** Improve skills in managing, sharing and merging project code in groups using GitHub

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

* Successfully developed a functional Bakery Management System with dynamic features like menus, order product and a table booking.
* Successfully separated the website into two layouts such as customer interface and a private management dashboard for the admin interface.
* Implemented full CRUD operations, allowing the admin to add, view, update and delete the products easily.
* Designed a clean and user-friendly interface using Bootstrap that looks good on laptop screens.
* Combined everyone's code smoothly using GitHub without losing files, allowing us to complete the project on time.

## Project Impact

* This project gave us great hands-on experience in full-stack web application. We did not just improve our coding skills, but we also learned how to work together as a team, solve coding errors and manage our time well. Professional web development scenarios can immediately benefit from the abilities acquired through this project.

* Project Completion Date:11/6/2026
* Course:BIIT 2305 Web Application Development
