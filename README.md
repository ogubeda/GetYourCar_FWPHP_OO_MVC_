# PHP_Project__OO_MVC__GetYourCar

Get Your Car is a web application designed to rent or sell a car. You wil have an admin side for managing the current brands, cars, concessionaires and user. And a client side to rent or sell a car.

## Build with

* **JavaScript** - Frontend
* **JQuery** - Frontend
* **PHP 7** - Backend
* **Framework PHP** - Backend
* **MySQL** - Database

### Widgets
* **DataTables**
* **Owl-Slider**
* **jqWidgets.DataTable**
* **Google Maps API**
* **JWT**

## Features

Module | Description
-------|------------
Home | It's the main page of the application, with a slider and most visited brands.
Shop | Where the clients can see all the cars, select your favorites and rent one.
Our Cars | It's the admin module for managing the application.
Contact Us | Used for contact with the company.
Log In | A basic log in system made with JWT and extra security Session.
Cart | This module is used for purchase the cars.

## Structure
```bash
├── model
│   ├── api-keys
├── module
│   ├── aboutus
│   ├── cars
│   ├── cart
│   ├── contact
│   ├── home
│   ├── login
│   ├── search
│   ├── shop
│   │   ├── controller
│   │   ├── model
│   │   ├── resources
│   │   └── view
│   └── userOrder
├── resources
│   └── modules
├── router
│   └── router
├── test
│   ├── mailgun
│   ├── mod_rewrite
│   └── social_login
├── utils
└── view
    ├── assets
    │   ├── css
    │   ├── fonts
    │   ├── img
    │   ├── js
    │   └── sass
    ├── css
    ├── img
    │   └── allCarsImg
    ├── inc
    ├── js
    │   ├── jqwidgets
    │   │   └── styles
    │   └── slick  
    └── lang
 ```

## Author

* **Oscar Gandia Ubeda**
