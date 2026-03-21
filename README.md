# CCS Sit-in Monitoring System
**University of Cebu - College of Computer Studies**

## 📌 Project Overview
The CCS Sit-in Monitoring System is a web-based application designed to manage and track student "sit-in" sessions in the computer laboratories. It allows students to register, manage their profiles, and make laboratory reservations, while providing a structured interface for monitoring laboratory usage.

## 🚀 Features
* **Student Registration & Login:** Secure access for students using their ID numbers.
* **Profile Management:** Students can update their personal information, change passwords (min. 8 characters), and upload profile pictures.
* **Sit-in History:** View a detailed log of past laboratory sessions, including purposes and timestamps.
* **Lab Reservation:** Request specific slots in the laboratory (e.g., Lab 524) for programming or research.
* **Session Tracking:** Displays the remaining allowed sit-in sessions for each student.

## 🛠️ Tech Stack
* **Frontend:** HTML5, CSS3 (Modern, clean UI matching UC aesthetic)
* **Backend:** PHP (Procedural & Prepared Statements)
* **Database:** MySQL (via XAMPP/phpMyAdmin)
* **Tools:** Cisco Packet Tracer (for network design integration)

## 📋 Database Setup
1. Open **phpMyAdmin**.
2. Create a new database named `ccs_db`.
3. Import the provided SQL files or run the following column updates:
   ```sql
   ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) DEFAULT 'default.png';
