# Project Title 
Student Quest Task Tracker

## Project Description
Student Quest Task Tracker is a simple PHP web application for students. It allows users to register, login, logout, and manage their school tasks using Create, Read, Update, and Delete features.

## Chosen System
Student Task Tracking System

## Technologies Used
- HTML
- CSS
- JavaScript
- PHP
- MySQL 

## Folder Structure
- assets - contains CSS and JavaScript files
- auth - contains register, login, and logout files
- config - contains database connection
- crud - contains create, read, update, and delete files
- database - contains SQL database file
- screenshots - contains project screenshots

## Database Structure

### users table
- id
- name
- email
- password
- created_at

### tasks table
- id
- user_id
- title
- subject
- description
- status
- created_at

## Features Implemented
- User registration
- User login
- User logout
- PHP session authentication
- Protected dashboard
- Create task
- Read task list
- Update task
- Delete task
- MySQL database
- Password hashing using password_hash()
- Password verification using password_verify()
- Basic input validation
- Input output protection using htmlspecialchars()
- Organized folder structure

## How to Run
1. Start Apache and MySQL in XAMPP.
2. Place the project folder inside htdocs.
3. Create a database named student_quest_tracker.
4. Import database/schema.sql in phpMyAdmin.
5. Open http://localhost/student-quest-tracker in the browser.

## Screenshots

### Register Page
![Register Page](screenshots/register.png)

### Login Page
![Login Page](screenshots/login.png)

### Dashboard
![Dashboard](screenshots/dashboard.png)

### Task List
![Task List](screenshots/task-list.png)

### Add Task
![Add Task](screenshots/add-task.png)

### Edit Task
![Edit Task](screenshots/edit-task.png)

### Delete Task
![Delete Task](screenshots/delete-task.png)