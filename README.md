# Web-Based Per Diem Request Management System

A full-stack web application to automate per diem request submission, approval, and tracking for organizations.

## Features
- User authentication with role-based access (employee, manager, finance).
- Per diem request submission with policy enforcement.
- Manager approval workflow.
- Real-time request tracking.
- Reporting tools for finance teams.

## Tech Stack
- **Frontend**: HTML, CSS, JavaScript (vanilla)
- **Backend**: Core PHP
- **Database**: MySQL
- **Server**: Apache

## Setup Instructions
1. **Install XAMPP**: Download and install XAMPP (includes Apache, PHP, MySQL).
2. **Database Setup**:
   - Import `/db/schema.sql` into MySQL via phpMyAdmin.
   - Update `/db/db_connect.php` with your MySQL credentials (username, password).
3. **Deploy Project**:
   - Copy the `per_diem_system` folder to `htdocs` (e.g., `C:/xampp/htdocs`).
4. **Run the Application**:
   - Start Apache and MySQL in XAMPP.
   - Open `http://localhost/per_diem_system` in your browser.
5. **Test Users**:
   - Use the sample users from `schema.sql` (e.g., `employee1`, `manager1`, `finance1`) with password `password123` (after hashing).

## Folder Structure
- `/public`: CSS, JS, and images.
- `/src`: Models, controllers, and views.
- `/db`: Database connection and schema.
- `index.php`: Entry point.

## Team
- Musab Hassen (Backend, Team Leader)
- Gifti Hussein (Frontend)
- Mohammed Shifa (Documentation)
- Murad Dawid (Testing)
