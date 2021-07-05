## Spis treści
* [Project description](#project-description)
* [Used technogies](#used-technologies)
* [ENV Laravel](#env-laravel)
* [Project start](#project-start)

## Project description
Procject shows REST API about match predictions. You can easily check, add and update match predictions. 
To test this application use the program POSTMAN.

Project was created for recruitment requests.

### Used technogies 

- Php v. 7.4.9
- Laravel v. 8.0+
- MySQL

#### ENV Laravelowy
    It is necessary to connect to basic database.
    Standard env file looks like:
   
    DB_HOST=localhost
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    
#### Project start

After you open project enter to POSTMAN program and use it by typing correct POSTMAN collection url.
Remember about migration

```
php artisan migrate
```

GET api/v1/predictions - shows all match predictions

POST api/v1/predictions - create new prediction

PUT api/v1/predictions/{id}/status - modify existing prediction


    Readme created 2021-07-02
