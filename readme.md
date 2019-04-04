# ModusCreate PHP API Test Solution
This solution is implemented with php (lumen Framework)

# System requirement
1. Docker
2. PHP (version 7.2) 
3. Composer 


# Get started

### Clone the repo
```
    git clone https://github.com/adekoder/modus-api-test.git
```

### Project setup

#### Installing project dependencies
Change directory into the project 
```
    cd modus-test/src
```
Next run
```
    composer install or composer update
```

This will install all the dependencies of the project


#### Runing project
Once you have docker installed on the machine
1. CD back to the root folder of the project 

``` cd modus-test```

2. Next is to build the docker image 

```
    docker-compose build
```
This will setup the project for using docker

3. Run the project.
```
    docker-compose up
```
This will start the docker server and you can access the project at http://localhost:8000


#### Setting environent variable
Inside the src folder you will see an a file name .env.example rename it to .env

then add 
```
    NHTSA_BASE_URL=https://one.nhtsa.gov/webapi
```
to the env file


## Api Documentation

### Getting a vechile infomation 
``` 
    Method: GET
    URL: localhost:8000/vehicles/<year>/<manufacturer>/<model>
```

##### Example :

Request:

 ```localhost:8000/vehicles/2017/Audi/A3 ```

Response:

```
    {
    "Count": 4,
    "Results": [
        {
            "Description": "2017 Audi A3 4 DR AWD",
            "VehicleId": 11043
        },
        {
            "Description": "2017 Audi A3 4 DR FWD",
            "VehicleId": 11044
        },
        {
            "Description": "2017 Audi A3 C AWD",
            "VehicleId": 11388
        },
        {
            "Description": "2017 Audi A3 C FWD",
            "VehicleId": 11389
        }
    ]
}
```

### Getting vehicle infomation + crash rating 
``` 
    Method: GET
    URL: localhost:8000/vehicles/<year>/<manufacturer>/<model>?withRating=true
```

##### Example:

Request:

``` localhost:8000/vehicles/2017/Audi/A3?withRating=true```

Response:

```{
    "Count": 4,
    "Results": [
        {
            "Description": "2017 Audi A3 4 DR AWD",
            "VehicleId": 11043,
            "CrashRating": "5"
        },
        {
            "Description": "2017 Audi A3 4 DR FWD",
            "VehicleId": 11044,
            "CrashRating": "5"
        },
        {
            "Description": "2017 Audi A3 C AWD",
            "VehicleId": 11388,
            "CrashRating": "Not Rated"
        },
        {
            "Description": "2017 Audi A3 C FWD",
            "VehicleId": 11389,
            "CrashRating": "Not Rated"
        }
    ]
}
```
### Getting vehicle information with json payload
```
    Method: "POST"
    URL: "localhost:8000/vehicles"
    payload: {
        "manufacturer": "Audi",
        "model": "A3",
        "modelYear": "2015"
    }
```

##### Example

Request: 

```
    payload {
        "manufacturer": "Audi",
        "model": "A3",
        "modelYear": "2015"
    }
```

Response:

```
{
    "Count": 4,
    "Results": [
        {
            "Description": "2015 Audi A3 4 DR AWD",
            "VehicleId": 9403
        },
        {
            "Description": "2015 Audi A3 4 DR FWD",
            "VehicleId": 9408
        },
        {
            "Description": "2015 Audi A3 C AWD",
            "VehicleId": 9405
        },
        {
            "Description": "2015 Audi A3 C FWD",
            "VehicleId": 9406
        }
    ]
}
```

### Getting vehicle information with json payload + crash rating
```
    Method: "POST"
    URL: "localhost:8000/vehicles?withRating=true"
    payload: {
        "manufacturer": "Audi",
        "model": "A3",
        "modelYear": "2015"
    }
```

##### Example

Request: 

```
    payload {
        "manufacturer": "Audi",
        "model": "A3",
        "modelYear": "2015"
    }
```

Response:

```
{
    "Count": 4,
    "Results": [
        {
            "Description": "2015 Audi A3 4 DR AWD",
            "VehicleId": 9403,
            "CrashRating": "5"
        },
        {
            "Description": "2015 Audi A3 4 DR FWD",
            "VehicleId": 9408,
            "CrashRating": "5"
        },
        {
            "Description": "2015 Audi A3 C AWD",
            "VehicleId": 9405,
            "CrashRating": "Not Rated"
        },
        {
            "Description": "2015 Audi A3 C FWD",
            "VehicleId": 9406,
            "CrashRating": "Not Rated"
        }
    ]
}
```

## Thank You.



