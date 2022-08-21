# Laravel Student resource REST Apis App

> Laravel(version 8) backend API that uses the student API resource

## Quick Start

``` bash
# Install Dependencies
composer install

# Add virtual host if using Apache else localhost with port 8000 is default server

Database Name: "student_crud_rest_api"
Please check the "student_crud_rest_api.sql" at root directory .
Postman APIs import file at root "Postman_Api_Import_File" directory. 

For Backend - Laravel : 
in Terminal: 
php artisan serve
path: http://localhost:8000

```

## Endpoints

### JWT Authentication Routes
### Login
``` bash
POST api/login
```
### Register
``` bash
POST api/register
```
### Logout
``` bash
GET api/logout
```

### Student resource routes
### List all students
``` bash
GET api/students
```
### Create/add student
``` bash
POST api/student/create
```
### Details of a student
``` bash
GET api/student/1
```
### Update student
``` bash
PUT api/student/update/1
```
### Delete student
``` bash
DELETE api/student/delete/1
```
### Find Students
``` bash
GET api/findStudents
```



```

## App Info

### Author

Sanjay Sorathiya
steel1985@gmail.com

### Version

1.0.0

### License

This project is licensed under the MIT License