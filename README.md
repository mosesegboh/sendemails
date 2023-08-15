Send Emails
An MVP app built for sending emails.

Prerequisites
Before you begin, ensure you have the following software installed on your PC:

Git: https://git-scm.com/downloads
PHP (7.4 or higher): https://www.php.net/downloads
Composer: https://getcomposer.org/download/
Node.js and npm: https://nodejs.org/en/download/
Laravel: https://laravel.com/

Installation and Setup
Clone the repository: Open your terminal or command prompt and navigate to the desired directory where the project will be cloned. Run the following command: -git clone https://github.com/mosesegboh/sendemails.git

Navigate to the project directory: After cloning the repository, navigate to the project directory by running:

cd teams
- Install PHP dependencies: Run the following command to install the required PHP dependencies for the Laravel application:
run composer install
- JQuery was used in the app so no need to Install JavaScript dependencies.
- Configure the environment: Copy the .env.example file to create a new .env.local file, which will store your local environment variables. Edit database credentials accordingly. 
- (DB_CONNECTION=mysql,DB_HOST=127.0.0.1,DB_PORT=3306,DB_DATABASE=YOUR DATABASE NAME,DB_USERNAME=YOUR USERNAME DB_PASSWORD=YOUR PASSWORD)
run mv .env.example .env.local
- Edit the .env.local file to configure any necessary variables, such as database connection settings, API keys, or other configurations specific to the local environment.
- Set up the database (if applicable):
- I used mailtrap for sending data. Let me know if you my credentials and I will forward to you, if not you can us your own credentials. Edit accordingly. (MAIL_HOST, MAIL_POST, MAIL_USERNAME, MAIL_PASSWORD).
- To make things easier I have also attached my database file in the root dir called sendemails.sql. just import this into your database and use accordingly.
- Or if you like you can migrate the necessary tables to use your own data.
To create the necessary tables.
Run php artisan migrate
- Run the development servers: Start the development server by running:
php artisan serve


Points and Reasons For Some functionality decisions made regarding the application.
- Due to the time constraints, I used jquery for the javascript in contrast to react or vuejs. Which is easier to set up. The decision was intentional
- I purposely employed the use of modals which I feel was better for aesthetics. My personal opinion.
- Due to time limitation I also delpoyed laravel authentication scaffolding for faster development.
- Due to the fact that I employed the use of modals and I need data populated in real time without refreshing the page, I employed the use 
    of javascript for populating some of the tables. I indicated this in comments in the code.
- All features has been added regarding the test requirements and unnecessary features were intentionally omitted due to time constraints.
- The application works fine in my on my local environment, so kindly let me know if you are experiencing any errors.

