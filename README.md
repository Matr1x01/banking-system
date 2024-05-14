## Project Description

This is a banking system project that utilizes MySQL for data storage. It provides various functionalities for managing bank accounts, transactions, and customer information.

## Installation

To run this project locally, follow these steps:

1. Clone the repository:

    ```bash
    git clone https://github.com/Matr1x01/banking-system.git
    ```

2. Install the required dependencies using Composer:

    ```bash
    composer install
    ```

3. Set up the MySQL database:

    - Create a new MySQL database.
    - Update the database configuration in the `.env` file with your MySQL credentials.

4. Run the database migrations:

    ```bash
    php artisan migrate
    ```

5. Start the application:

    ```bash
    php artisan serve
    ```
