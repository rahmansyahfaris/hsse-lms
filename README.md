# HSSE LMS (Learning Management System) 🎓

A comprehensive Learning Management System built for Health, Safety, Security, and Environment (HSSE) training.

## 🚀 Features

-   **Role-Based Access Control (RBAC)**: Distinct roles for Students, Instructors, and Admins.
-   **Course Management**: Create courses, add sections (Video, Reading, Documents).
-   **Content Delivery**:
    -   Stream video content securely.
    -   Download course materials.
-   **Enrollment System**: Track student progress per course.
-   **Responsive Design**: Built with Tailwind CSS for a seamless experience on any device.

## 🛠️ Tech Stack

-   **Framework**: [Laravel 11](https://laravel.com)
-   **Frontend**: [Blade Templates](https://laravel.com/docs/blade) + [Tailwind CSS](https://tailwindcss.com)
-   **Database**: SQLite (Development)
-   **Authentication**: Laravel Breeze

## 📦 Setup & Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/rahmansyahfaris/hsse-lms.git
    cd hsse-lms
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database & Assets**
    ```bash
    touch database/database.sqlite
    php artisan migrate
    php artisan storage:link
    npm run build
    ```

5.  **Run the Server**
    ```bash
    php artisan serve
    ```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
