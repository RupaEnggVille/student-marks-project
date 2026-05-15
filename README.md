# student-marks-projectClean Project Structure
```text
student-management-system/
│
├── docker-compose.yaml
├── README.md
├── .gitignore
│
├── mysql/
│   └── init.sql
│
├── php-app/
│   ├── Dockerfile
│   ├── config.php
│   ├── style.css
│   │
│   ├── login.php
│   ├── logout.php
│   │
│   ├── admin_dashboard.php
│   ├── student_dashboard.php
│   │
│   ├── add_student.php
│   ├── edit_student.php
│   ├── delete_student.php
│   ├── search.php
│   │
│   ├── student_subjects.php
│   ├── add_subject.php
│   │
│   ├── attendance.php
│   ├── view_attendance.php
│   │
│   └── save_student.php
│
└── python-service/
    ├── app.py
    └── requirements.txt
```

# 1. mysql/init.sql
CREATE DATABASE IF NOT EXISTS studentdb;

USE studentdb;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin','student'),
    student_id INT NULL,
    FOREIGN KEY (student_id)
    REFERENCES students(id)
    ON DELETE CASCADE
);

CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    subject_name VARCHAR(100),
    marks INT,
    FOREIGN KEY (student_id)
    REFERENCES students(id)
    ON DELETE CASCADE
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    attendance_date DATE,
    status ENUM('Present','Absent'),
    FOREIGN KEY (student_id)
    REFERENCES students(id)
    ON DELETE CASCADE
);

# 2. docker-compose.yaml
version: '3.9'

services:

  php:
    build:
      context: ./php-app

    container_name: php-app

    ports:
      - "8080:80"

    volumes:
      - ./php-app:/var/www/html

    depends_on:
      - mysql

  mysql:
    image: mysql:8.0

    container_name: mysql

    command: --default-authentication-plugin=mysql_native_password

    environment:
      MYSQL_ROOT_PASSWORD: root123
      MYSQL_DATABASE: studentdb

    ports:
      - "3306:3306"

    volumes:
      - mysql_data:/var/lib/mysql
      - ./mysql:/docker-entrypoint-initdb.d

  python:
    image: python:3.11

    container_name: python-service

    working_dir: /app

    volumes:
      - ./python-service:/app

    command: bash -c "pip install -r requirements.txt && python app.py"

    ports:
      - "5000:5000"

volumes:
  mysql_data:

# 3. php-app/Dockerfile
FROM php:8.2-apache

RUN docker-php-ext-install mysqli

COPY . /var/www/html/
4. php-app/config.php
<?php

$conn = mysqli_connect(
    "mysql",
    "root",
    "root123",
    "studentdb"
);

if(!$conn){
    die("Database Connection Failed");
}

?>
5. login.php

Handles:

Admin login
Student login
Auto admin creation
6. admin_dashboard.php

Features:

View students
Add student
Edit/Delete student
Search student
Manage attendance
Manage subjects
7. student_dashboard.php

Features:

View own profile
View subjects & marks
View attendance
8. add_student.php

Creates:

Student record
Student login automatically

Default student password:

student123
9. student_subjects.php

Features:

View marks
Add subject
Add marks
10. attendance.php

Features:

Mark attendance
Save attendance
11. view_attendance.php

Features:

View attendance report
12. search.php

Features:

Search student by name
13. style.css

Common styling for:

Login page
Tables
Buttons
Dashboard
14. python-service/app.py

Optional analytics service.

Example:

from flask import Flask

app = Flask(__name__)

@app.route("/")
def home():
    return "Python Analytics Service Running"

app.run(host="0.0.0.0", port=5000)
15. requirements.txt
flask
16. README.md

Include:

Project setup
Docker commands
Login credentials
Screenshots
Architecture
Build & Run
docker compose down -v
docker compose up --build -d
Access URLs

PHP App:

http://PUBLIC-IP:8080

Python Service:

http://PUBLIC-IP:5000
Default Credentials

Admin:

Email: admin@gmail.com
Password: admin123

Student:

Password: student123
