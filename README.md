## Laravel + Vue single page application (SPA)  
by Andrii Sushko [stafilokoks@gmail.com](mailto:stafilokoks@gmail.com)

This app is created as a single page application driven by Vue and interacts with the Laravel driven API.
It allows registering a new user, login, creating, and deleting entities (simple Countries in this case).

Auth part is created in a more simple way. Still, the Countries part implements the Controller->Service->Repository structure, which is redundant in such a simple project, but can provide an excellent example of the "REAL" projects.

### Run app

To run the app you need to clone the project from this repository, open it and run the next commands one by one. 

    composer install

    npm install

    npm run build

    php artisan serve


After that application can be opened in the browser by the url [http://127.0.0.1:8000](http://127.0.0.1:8000)

For the first time you need to create a new user by clicking "Sign Up"

### Testing

Because controllers don't contain any logic, unit tests are not efficient in this case. I prefer to use feature tests while testing API endpoints.
To run tests next command can be used. It uses an "in memory" DB instead of the regular one.

    php artisan test --env=testing
