# Social Media App

This project utilizes PHP version 8.1.13, Laravel Installer version 4.5.0, and a MySQL database.

## Getting Started

These instructions will help you set up the project on your local machine.

### Prerequisites

To run this project, you will need the following installed on your machine:

- PHP 8.1.13
- Composer
- Laravel Installer 4.5.0
- MySQL

### Installing

1. Clone the repository:

git clone https://github.com/aqibmehraj20/social_media_app.git

2. Navigate to the project directory:

cd social_media_app

3. Install dependencies:

composer install


4. Create a copy of the `.env.example` file and rename it to `.env`. Update the file with your database configuration details.

5. Generate a new application key:

php artisan key:generate


6. Run database migrations:

php artisan migrate


7. Start the local development server:

php artisan serve


8. Access the application in your web browser at `http://localhost:8000`.

