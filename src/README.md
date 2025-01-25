## About Laravel project

Is simple REST API on Laravel framework. This api used for manage tasks. Authenticated user can do CRUD operations for this needed use Bearer Token. User can registration by unique email and password with confirmation.

## Stack
- Laravel
- PostgreSQL

## Deploy with Docker

### Build and run Dockerfile
- Build docker image
```docker build -t task-manager```

- Run docker container
```docker run -d --name task-manager-container -p 8000:8000 task-manager```

- Copy ==.env.example== as ==.env== and change database configuration for connection

- Access to the app container and install independencies
```
docker exec -it task-manager-container bash
composer install
```

- Genarate application key
```php artisan key:generate```

- Make database migration
```php artisan migrate```

- (Optional) Can insert fake data to database
```php artisan migrate --seed```

- Check access [localhost:8000](http://localhost:8000) in browser or other way send request

- Stop container
```docker stop task-manager-container```

- Delete docker container
```docker rm task-manager-container```

- Delete docker image
```docker rmi task-manager```

### Deploy with Docker-compose

- Build and pull Docker containers and run they
```docker-compose up -d```

- Copy ==.env.example== as ==.env== and change database configuration for connection
```
    # Example
    DB_CONNECTION=pgsql
    DB_HOST=db
    DB_PORT=5432
    DB_DATABASE=task-manager
    DB_USERNAME=task-manager
    DB_PASSWORD=task-manager
```

- Access to the app container and install independencies
```
docker exec -it app-task-manager bash
composer install
```

- Genarate application key
```php artisan key:generate```

- Make database migration
```php artisan migrate```

- (Optional) Can insert fake data to database
```php artisan migrate --seed```

- Check access [localhost:8000](http://localhost:8000) in browser or other way send request

- For get access to [PGAdmin4](http://localhost:8080) used creadential
    - Username: ==admin@task-manager.com==
    - Password: ==password==
    - And need add our PGSQL server
        Hostname: ==db==
        Port: ==5432==
        Username: ==task-manager==
        Password: ==task-manager==

- Stop containers
```docker-compose stop```

- Start containers
```docker-compose start```

- Delete docker containers
```docker-compose down```

## Endpoints

### Authorization
- Get access token [localhost:8000/api/login](http://localhost:8000/api/login) POST request with: email and password
    ```
    #Example
    {
        "email": "test@example.com",
        "password": "password"
    }
    ```
    Need save token from response and use for next requests.

- Delete all access tokens current user [localhost:8000/api/logout](http://localhost:8000/api/logout) POST request with Athorization header 

- Register new user [localhost:8000/api/register](http://localhost:8000/api/register) POST request with: unique email, name and password confirmation
    ```
    #Example
    {
        "name": "user1",
        "email": "user1@example.com",
        "password": "password",
        "password_confirmation": "password"
    }
    ```

### Tasks CRUD

- Get all tasks [localhost:8000/api/tasks](http://localhost:8000/api/tasks) GET request with parameters is_done (optional)

- Get task by id [localhost:8000/api/tasks/1](http://localhost:8000/api/tasks/1) GET request with task id in uri

- Create new task [localhost:8000/api/tasks](http://localhost:8000/api/tasks) POST request with parameters name and description
    ```
    {
        "name": "task 1",
        "description": "description 1"
    }
    ```

- Update task [localhost:8000/api/tasks/1](http://localhost:8000/api/tasks/1) PUT request with parameters which need update
    ```
    {
        "name": "task updated",
        "description": "description"
    }
    ```

- Delete task [localhost:8000/api/tasks/1](http://localhost:8000/api/tasks/1) DELETE request with task id in uri

## For generate documentation used knuckleswtf/scribe 
Get access to documentation [localhost:8000/docs](http://localhost:8000/docs)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
