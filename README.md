# Notify

Notify is a Laravel application designed for universities to post notifications to various departments. Students can log in and read these notifications. The application includes features such as email verification, registration, and multiple user authentication.

## Features

- Post notifications to university departments
- Student login to read notifications
- Email verification for users
- User registration system
- Multiple user authentication
- Students can search notifications using names, short descriptions, and tags
- Sections for important notifications, my notifications, and all notifications
- Student profile update option
- Faculty profile update option
- Faculty can update student profiles
- Designation of a department head among faculty members

## Requirements

- PHP >= 8.0
- Composer
- Laravel >= 9.x
- MySQL or any other supported database

## Installation

1. **Clone the repository:**
    ```bash
    git clone https://github.com/nymul-islam-moon/notify.git
    cd notify
    ```

2. **Install dependencies:**
    ```bash
    composer install
    npm install
    npm run dev
    ```

3. **Environment setup:**
    - Copy the `.env.example` file to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Update the `.env` file with your database and email credentials:
      ```
      APP_NAME=Notify
      APP_ENV=local
      APP_KEY=base64:YOUR_APP_KEY
      APP_DEBUG=true
      APP_URL=http://localhost

      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=your_database
      DB_USERNAME=your_username
      DB_PASSWORD=your_password

      MAIL_MAILER=smtp
      MAIL_HOST=smtp.mailtrap.io
      MAIL_PORT=2525
      MAIL_USERNAME=null
      MAIL_PASSWORD=null
      MAIL_ENCRYPTION=null
      MAIL_FROM_ADDRESS=hello@example.com
      MAIL_FROM_NAME="${APP_NAME}"
      ```

4. **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5. **Run migrations and seed the database:**
    ```bash
    php artisan migrate --seed
    ```

6. **Serve the application:**
    ```bash
    php artisan serve
    ```

    The application will be available at `http://localhost:8000`.

## Usage

- **Registration and Email Verification:**
  - Register as a new user through the registration page.
  - Verify your email address using the link sent to your email.

- **Login:**
  - Login using your registered email and password.

- **Notifications:**
  - Once logged in, you will be able to view notifications posted by the university departments.
  - Search for notifications using names, short descriptions, or tags.
  - View notifications in sections such as important notifications, my notifications, and all notifications.

- **Profile Management:**
  - Students can update their profiles.
  - Faculty can update their profiles.
  - Faculty can update student profiles.
  - A designated department head among faculty members can manage notifications and profiles.

## Contribution

If you want to contribute to this project, feel free to fork the repository and submit a pull request.

## License

This project is open-source and available under the [MIT License](LICENSE).

## Contact

If you have any questions or need further assistance, feel free to contact [towkir1997islam@gmail.com](mailto:towkir1997islam@gmail.com).
