Here’s the updated installation guide with the NPM steps removed and the application name changed to "test-juicebox":

# Test Juicebox Installation Guide

Follow these steps to install Test Juicebox:

1. **Prerequisites**: Ensure you have the following software installed:
    - **PHP** (version 8.2 or higher)
    - A compatible database (e.g., MySQL, PostgreSQL)

2. **Clone the Repository**: Open your terminal and navigate to your desired installation directory. Run the following command to clone the Test Juicebox repository:

    ```bash
    git clone https://github.com/andrieone/test-juicebox.git
    ```

3. **Install Dependencies**: Change into the cloned Test Juicebox directory and install the project dependencies:

    ```bash
    cd test-juicebox
    composer install
    ```

4. **Create Database**: Create a new database for your Test Juicebox application using your preferred database management tool or command line. For example, if you're using MySQL:

    ```sql
    CREATE DATABASE test_juicebox;
    ```

5. **Create Environment File**: Copy the example environment file and rename it:

    ```bash
    cp .env.example .env
    ```

6. **Configure Database Settings**: Open the `.env` file in a text editor and update the database connection settings:

    ```
    DB_DATABASE=test_juicebox
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

7. **Generate Application Key**: Generate a unique application key with:

    ```bash
    php artisan key:generate
    ```

8. **Run Migrations**: If you're using a database, migrate the database tables:

    ```bash
    php artisan migrate
    ```

9. **Start the Development Server**: Start the Test Juicebox development server:

    ```bash
    php artisan serve
    ```

    You should see a message like `Test Juicebox development server started: http://127.0.0.1:8000`.

Congratulations! You have successfully installed Test Juicebox. You can now access your application at the provided URL.

For more details, refer to the official Laravel documentation: [Laravel Documentation](https://laravel.com/docs).

#### **Command for Manually Dispatching The Welcome Email Job**

Run the Artisan command to dispatch the welcome email job manually:

```bash
php artisan send:welcome-email {user_id}
```

Replace `{user_id}` with the ID of an actual user in your database.

---

### Final Notes:
- Ensure that your queue worker is running to process queued jobs. You can start a worker using:

   ```bash
   php artisan queue:work
   ```

