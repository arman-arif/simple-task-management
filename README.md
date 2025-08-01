# Simple Task Management System

A comprehensive task management application built with Laravel 12 and modern frontend technologies, featuring both list and Kanban board views for optimal task organization.

## Project Overview

This project was developed as a technical assessment to demonstrate proficiency in Laravel architecture, JavaScript/AJAX implementation, and modern web development practices. The application provides a complete task management solution with user authentication, CRUD operations, and advanced UI features.

## Development Approach

### 1. **Architecture & Design Patterns**

#### **MVC Implementation**

-   **Models**: Clean Eloquent models with proper relationships and attribute casting
-   **Controllers**: RESTful controllers following single responsibility principle
-   **Views**: Blade components for reusable UI elements and maintainable templates

#### **Service Layer Pattern**

-   Implemented `TaskService` class to encapsulate business logic
-   Separation of concerns between controllers and business operations
-   Centralized query logic for better maintainability

#### **Repository Pattern Elements**

-   Service classes act as data access abstractions
-   Consistent API for task operations across different contexts

### 2. **Database Design**

#### **Migration Strategy**

-   Clean, focused migration for tasks table with proper column types
-   Enum-based status field for data integrity
-   Foreign key relationships with users table

#### **Model Implementation**

-   Used Laravel's native enum casting for type safety
-   Proper fillable attributes and relationships
-   Factory classes for testing and seeding with realistic sample data

#### **Testing & Development Data**

-   **DatabaseSeeder**: Creates test user and sample tasks for development
-   **TaskFactory**: Generates realistic task data with random titles, descriptions, and due dates
-   **UserFactory**: Standard Laravel user factory with proper password hashing

### 3. **Validation & Security**

#### **Form Request Classes**

-   `TaskStoreRequest`: Comprehensive validation for task creation/updating
-   `TaskStatusUpdateRequest`: Dedicated validation for status changes
-   Custom validation rules (`TaskStatusRule`) for enum validation

#### **Authorization**

-   Gate-based authorization for task operations
-   User ownership verification for all task actions
-   Middleware protection for authenticated routes

### 4. **Frontend Architecture**

#### **JavaScript Organization**

-   Modular JavaScript with separate files for different functionalities
-   `tasks.js`: Core task operations and AJAX handling
-   `kanban.js`: Drag-and-drop Kanban board functionality
-   Global configuration for CSRF tokens and toast notifications

#### **UI/UX Implementation**

-   **Bootstrap 5**: Modern, responsive design
-   **Blade Components**: Reusable form inputs and UI elements
-   **Dual View System**: Both list and Kanban board interfaces
-   **Real-time Feedback**: Toast notifications and loading states

### 5. **Advanced Features Implementation**

#### **Drag-and-Drop Kanban Board**

-   jQuery UI integration for smooth drag-and-drop experience
-   Real-time status updates via AJAX
-   Visual feedback during drag operations
-   Automatic board state management

#### **Search & Filtering**

-   Server-side filtering by status and keywords
-   Real-time search with immediate results
-   Sort functionality (newest/oldest)
-   URL-based filter persistence

#### **AJAX Integration**

-   Complete AJAX implementation for all CRUD operations
-   Non-blocking UI updates
-   Error handling with user-friendly messages
-   Progress indicators for better UX

## Technical Implementation

### **Core Requirements Met**

✅ **CRUD Operations**: Full Create, Read, Update, Delete functionality  
✅ **Task Fields**: Title, description, status (pending/in progress/completed), due date  
✅ **AJAX Status Updates**: Inline status changes without page reload  
✅ **Bootstrap 5 UI**: Modern, responsive design implementation  
✅ **Laravel Validation**: Request classes with comprehensive validation rules  
✅ **MVC Pattern**: Proper separation of concerns and Laravel best practices

### **Bonus Features Implemented**

✅ **Search/Filter**: Advanced filtering by title, description, and status  
✅ **Kanban Board**: Drag-and-drop interface with visual status columns  
✅ **Enhanced UX**: Toast notifications, modals, and loading states

### **Additional Enhancements Beyond Requirements**

🚀 **Modern Laravel Features**:

-   Laravel 12 with latest PHP 8.2+ features
-   Enum implementation for type safety
-   Service layer architecture
-   Gate-based authorization

🚀 **Advanced Frontend**:

-   Vite build system for modern asset compilation
-   SASS preprocessing for enhanced styling
-   jQuery UI for enhanced interactions
-   SweetAlert2 for beautiful confirmations
-   Flatpickr for advanced date picking
-   iziToast for elegant notifications

🚀 **Developer Experience**:

-   Blade components for code reusability
-   Custom validation rules
-   Proper error handling and logging
-   Clean, documented code structure

🚀 **UI/UX Enhancements**:

-   Responsive design across all devices
-   Smooth animations and transitions
-   Intuitive navigation between list and board views
-   Visual status indicators with color coding
-   Real-time feedback for all user actions

## Technology Stack

### **Backend**

-   **Laravel 12**: Latest framework version with modern PHP features
-   **PHP 8.2+**: Type declarations, enums, and performance improvements
-   **SQLite**: Lightweight database for development and testing
-   **Spatie Laravel HTML**: Enhanced HTML generation helpers

### **Frontend**

-   **Bootstrap 5**: Responsive CSS framework
-   **jQuery 3.7**: DOM manipulation and AJAX requests
-   **jQuery UI**: Drag-and-drop functionality
-   **Vite**: Modern build tool for asset compilation
-   **SASS**: CSS preprocessing for maintainable styles

### **Additional Libraries**

-   **SweetAlert2**: Beautiful alert dialogs
-   **iziToast**: Elegant toast notifications
-   **Flatpickr**: Advanced date picker
-   **Day.js**: Modern date manipulation
-   **Bootstrap Icons**: Comprehensive icon set

## Development Methodology

### **Best Practices Applied**

1. **Clean Code**: Readable, maintainable code with proper naming conventions
2. **SOLID Principles**: Single responsibility, dependency injection, and interface segregation
3. **Laravel Conventions**: Following framework standards and conventions
4. **Progressive Enhancement**: Graceful degradation with JavaScript disabled
5. **Security First**: CSRF protection, input validation, and authorization checks

### **Code Organization**

-   Feature-based file organization
-   Reusable components and services
-   Consistent error handling patterns
-   Comprehensive inline documentation

This implementation demonstrates a production-ready approach to building modern web applications with Laravel, showcasing both technical proficiency and attention to user experience details.

## Installation & Setup

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   Node.js & npm/pnpm
-   SQLite (default) or MySQL

### Quick Start

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd simple-task-management
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies**

    ```bash
    npm install
    # or
    pnpm install
    ```

4. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Database setup**

    ```bash
    php artisan migrate
    php artisan db:seed  # Optional: adds sample data
    ```

    The seeder creates:
    - A test user account: `test@example.com` / `password`
    - 10 sample tasks with random titles, descriptions, and due dates

6. **Build frontend assets**

    ```bash
    npm run build
    # or for development
    npm run dev
    ```

7. **Start the application**
    ```bash
    php artisan serve
    ```

Visit `http://localhost:8000` to access the application.

### Quick Demo

For immediate testing, use the seeded test account:
- **Email**: `test@example.com`
- **Password**: `password`

This account comes with 10 pre-created sample tasks to explore all features immediately.

## Usage

### **Authentication**

-   Register a new account or login with existing credentials
-   All task operations require authentication

### **Task Management**

-   **Create Tasks**: Use the "Add Task" button on either view
-   **Edit Tasks**: Click the edit button on any task card
-   **Delete Tasks**: Use the delete button with confirmation
-   **Update Status**:
    -   List View: Use the dropdown selector
    -   Kanban View: Drag tasks between columns

### **Views**

-   **List View** (`/`): Traditional table-like view with search and filters
-   **Kanban Board** (`/kanban`): Visual board with drag-and-drop functionality

### **Features**

-   **Search**: Filter tasks by title or description
-   **Status Filter**: Show tasks by specific status
-   **Sort Options**: Order by newest or oldest
-   **Responsive Design**: Works on desktop and mobile devices

## API Endpoints

### Task Routes (Authentication Required)

-   `GET /task` - List all user tasks
-   `POST /task` - Create new task
-   `GET /task/{id}` - Show specific task
-   `PUT /task/{id}` - Update task
-   `DELETE /task/{id}` - Delete task
-   `PUT /task/{id}/update-status` - Update task status only

## Project Structure

```
app/
├── Enums/TaskStatus.php          # Task status enumeration
├── Http/
│   ├── Controllers/
│   │   └── TaskController.php    # Task CRUD operations
│   └── Requests/
│       ├── TaskStoreRequest.php  # Task validation
│       └── TaskStatusUpdateRequest.php
├── Models/
│   ├── Task.php                  # Task model
│   └── User.php                  # User model
├── Rules/
│   └── TaskStatusRule.php        # Custom validation rule
└── Services/
    └── TaskService.php           # Business logic layer

resources/
├── js/
│   ├── tasks.js                  # Task operations & AJAX
│   └── kanban.js                 # Kanban board functionality
├── sass/
│   └── app.scss                  # Custom styles
└── views/
    ├── task/                     # Task-related views
    ├── components/               # Reusable Blade components
    └── layouts/                  # Layout templates
```

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
