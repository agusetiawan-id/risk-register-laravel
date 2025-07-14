# Risk Register Application

This is a simple web application built with Laravel to manage a Risk Register. It allows users to create, read, update, and delete risks. The application automatically calculates the risk level based on user input for likelihood and consequences, and provides a feature for bulk uploading data via a CSV file.

## Features

- **CRUD Operations:** Full functionality to Create, Read, Update, and Delete risk entries.
- **Automatic Risk Level Calculation:** The risk level (Low, Medium, High, Critical) is automatically determined based on a 5x5 risk matrix.
- **Color-Coded Risk Levels:** The main table is color-coded to provide a quick visual reference for risk levels:
    - **Critical:** Red (`#dc3545`)
    - **High:** Orange (`#ffc107`)
    - **Medium:** Yellow (`#ffc107` with a lighter shade, using Bootstrap's `table-warning`)
    - **Low:** Green (`#198754`)
- **Bulk Data Upload:** Easily import multiple risk entries at once by uploading a CSV file.
- **Database Support:** Uses SQLite out-of-the-box for easy setup, with no external database installation required.
- **Responsive UI:** Built with Bootstrap for a clean and responsive user interface that works on all devices.

## Installation & Setup

1.  **Clone the Repository:**
    ```bash
    git clone <your-repository-url>
    cd risk-register-laravel
    ```

2.  **Install Dependencies:**
    Make sure you have [Composer](https://getcomposer.org/) installed. Run the following command to install the required PHP packages:
    ```bash
    composer install
    ```

3.  **Setup Environment File:**
    Copy the example environment file.
    ```bash
    cp .env.example .env
    ```
    This project is configured to use SQLite by default, so no further database configuration is needed.

4.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

5.  **Create the Database File:**
    Create the empty SQLite database file.
    ```bash
    touch database/database.sqlite
    ```

6.  **Run Database Migrations:**
    This will create all the necessary tables in your database with the correct schema.
    ```bash
    php artisan migrate:fresh
    ```

7.  **Start the Development Server:**
    ```bash
    php artisan serve
    ```
    The application will now be running at `http://127.0.0.1:8000`.

## How to Use

### Adding a New Risk

1.  Navigate to the home page.
2.  Click the "**Create New Risk**" button.
3.  Fill in the form with the risk name and description.
4.  Select the appropriate **Likelihood** and **Consequences** from the dropdown menus.
5.  Click "**Submit**". The risk level will be calculated and saved automatically.

### Editing and Deleting a Risk

-   To **edit** a risk, click the "Edit" button on the corresponding row in the main table.
-   To **delete** a risk, click the "Delete" button on the corresponding row.

### Bulk Uploading Risks

1.  Click the "**Bulk Upload**" button on the home page.
2.  Prepare a CSV file with the following four columns in this specific order: `risk_name`, `description`, `likelihood`, `consequences`.
    - The first row of the CSV **must be a header row** and will be skipped during the import process.
    - **Important:** The values for `likelihood` and `consequences` must exactly match the options available in the dropdowns.

3.  **Example CSV Format:**
    ```csv
    risk_name,description,likelihood,consequences
    "Server Overload","Production server slows down during peak hours","High","Moderate"
    "Third-party API Failure","An external API service is unavailable","Low","Minor"
    "Data Breach","Sensitive customer data is exposed","Very Low","Severe"
    ```
4.  Click "**Choose File**", select your CSV file, and click "**Upload and Process**".

## Risk Matrix

The risk level is calculated automatically based on the following 5x5 matrix:

| Likelihood  | Insignificant | Minor  | Moderate | High     | Severe   |
|-------------|---------------|--------|----------|----------|----------|
| **Very High** | Medium        | High   | High     | Critical | Critical |
| **High**      | Medium        | Medium | High     | Critical | Critical |
| **Equal**     | Low           | Medium | High     | High     | Critical |
| **Low**       | Low           | Low    | Medium   | Medium   | High     |
| **Very Low**  | Low           | Low    | Low      | Medium   | High     |

The table rows on the main page are color-coded according to the calculated risk level for easy identification.