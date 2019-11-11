# myzone-products
rest-api for myzone products

Steps to setup project
1. Go to your http server document directory e.g C:/xampp/htdocs if using xampp on windows
2. Clone the the project using command into the created folder: 
  git clone https://github.com/johnraygarcia/myzone-products.git 
3. Run composer install to download dependencies
4. Create a database
5. Edit the .env file to adjust the db user/password/host
6. Run the migration: 
   bin/console doctrine:migration:migrate
7. Run the fixture to populate the db with sample data by running command: 
   bin/console doctrine:fixtures:load
   

# API Documentation
The api documentation can be accessed via route
http://127.0.0.1/api/doc

