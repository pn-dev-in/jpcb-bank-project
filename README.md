# 🏦 JPCB Bank Administration & Support System

A secure **Bank Administration and Support Management System** built using **PHP**, **CodeIgniter 4**, and **MySQL** during my **Software Development Internship**. The project is an enterprise-grade web application that enables bank administrators to manage website content, users, complaints, internal operations, and communication with the software development team through a centralized administration portal.

> **Disclaimer**
>
> This repository contains my internship work and contributions completed during my Software Development Internship.
>
> The original project is protected under a **Non-Disclosure Agreement (NDA)**. This repository is maintained **privately** for personal reference and version control. Any confidential information, production configurations, credentials, customer information, uploaded documents, and sensitive business data have been removed.

---

# 🚀 My Contributions

During my internship, I worked on several major modules of the application, focusing primarily on authentication, administration, CMS, complaint management, and internal communication systems.

## 🔐 Admin Authentication & Security

- Designed and implemented the complete Admin Authentication System.
- Developed secure login functionality with session management.
- Protected administrative routes and restricted unauthorized access.
- Improved authentication flow and backend security.

---

## 👥 Role-Based Access Control (RBAC)

Designed and implemented a complete Role-Based Access Control (RBAC) system.

Implemented role-specific dashboards and permissions for:

- Super Admin
- Administrator
- CMS Manager
- Branch Manager
- Complaint Manager
- ATM Manager
- Other operational staff

Built a Permission Matrix that controls access to different modules based on user roles.

---

## 📊 Admin Dashboard

Designed and developed the complete administrative dashboard.

Implemented:

- Dashboard statistics
- Navigation modules
- User management interface
- Administrative controls
- System overview

Developed an Activity Log system that records important administrative actions performed by users.

---

## 📰 Content Management System (CMS)

Developed the complete CMS administration panel.

Implemented:

- Dynamic website content management
- Homepage content updates
- Informational page management
- Banner/content management

Integrated the CMS with the public website so that updates made by administrators are reflected dynamically on the frontend without code changes.

---

## 🎫 Complaint Management System

Designed and developed the complete Complaint Management workflow.

Features include:

- Complaint/Ticket creation
- Complaint notifications
- Ticket assignment
- Status tracking
- Ticket resolution
- Ticket closure

Administrators can assign complaints to responsible managers, monitor progress, and close tickets after successful resolution.

---

## 💬 Internal Support & Communication Portal

One of my major internship contributions was building an internal communication platform between **JPCB Bank** and **JBB Technologies**.

Implemented:

- Dedicated support dashboard for JBB Technologies
- Internal ticket-based communication system
- Real-time conversation workflow
- Email integration for issue updates
- Bidirectional communication between Bank Administrators and the Development Team

Whenever bank administrators encounter issues within the application, they can directly raise support requests from the admin panel. These requests are received by the JBB Technologies support dashboard, allowing developers and bank administrators to communicate, track progress, and resolve issues efficiently.

---

## ⚙ Backend Development

Contributed to backend development across multiple modules.

Responsibilities included:

- Developing new backend functionality
- Database integration
- Feature enhancements
- Bug fixing
- Application maintenance
- Improving existing workflows

---

# ✨ Application Features

- Secure Admin Authentication
- Role-Based Access Control (RBAC)
- Permission Matrix
- Multi-role Dashboard
- CMS Management
- Dynamic Frontend Content Management
- Complaint Management System
- Ticket Management
- Activity Logs
- Internal Support Portal
- Real-time Communication
- Email Notifications
- User Management
- Branch Management
- ATM Management
- Database-driven Administration

---

# 🛠 Tech Stack

## Backend

- PHP
- CodeIgniter 4

## Database

- MySQL

## Frontend

- HTML5
- CSS3
- Bootstrap
- JavaScript
- jQuery

## Development Tools

- Composer
- Apache (XAMPP)
- Git
- GitHub

---

# 📂 Project Structure

```text
app/
├── Controllers/
├── Models/
├── Views/
├── Config/
├── Filters/
├── Helpers/
└── Database/

public/

public_html/

writable/

composer.json
composer.lock
spark
preload.php
```

---

# 🚀 Installation

## Clone Repository

```bash
git clone https://github.com/pn-dev-in/JPCB-Bank-Management-System.git
```

---

## Install Dependencies

```bash
composer install
```

---

## Configure Environment

Copy the environment template:

```bash
cp env .env
```

or on Windows

```bash
copy env .env
```

Update the database configuration inside the `.env` file.

---

## Database Setup

Create a MySQL database and import the required schema or sample database.

Update your database credentials inside the `.env` file.

---

## Start Development Server

```bash
php spark serve
```

Open:

```
http://localhost:8080
```

---

# 🔒 Security Features

- Secure Authentication
- Session Management
- Role-Based Access Control
- Permission Matrix
- Activity Logging
- Input Validation
- Protected Administrative Routes
- Secure File Upload Handling

---

# 📸 Screenshots

Screenshots will be added soon.

Suggested screenshots:

- Admin Login
- Dashboard
- CMS Dashboard
- Complaint Management
- Activity Logs
- User Management
- Permission Matrix
- Support Dashboard
- Internal Chat Interface

---

# 📚 Learning Outcomes

This internship project provided practical experience in:

- Enterprise PHP Development
- CodeIgniter 4 Framework
- MVC Architecture
- Authentication & Authorization
- Role-Based Access Control (RBAC)
- Permission Matrix Design
- Enterprise Dashboard Development
- CMS Development
- Dynamic Content Management
- Complaint & Ticket Management Systems
- Internal Support Portal Development
- Real-time Communication Workflow Design
- Email Integration
- Activity Logging
- MySQL Database Integration
- Debugging & Feature Enhancement
- Git-based Collaborative Development
- Working within a large enterprise codebase

---

# 🔮 Future Enhancements

- REST API Integration
- Dashboard Analytics
- Advanced Reporting
- Performance Optimization
- Email Automation
- Mobile Responsive Improvements
- Audit Reports
- Enhanced Notification System

---

# 📄 Repository Notice

This repository is maintained for documentation and version control purposes only.

The original enterprise application was developed during my internship and remains protected under a **Non-Disclosure Agreement (NDA)**. Sensitive business information, customer data, production configurations, and confidential resources have been removed.

---

# 👨‍💻 Developer

**Pravesh Nandanwar**

**Software Developer | Backend Developer | Full Stack Developer**

- GitHub: https://github.com/pn-dev-in
- LinkedIn: https://www.linkedin.com/in/pravesh-nandanwar/

---

⭐ This repository showcases my internship contributions and the backend engineering experience I gained while working on an enterprise banking administration platform.
