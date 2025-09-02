# Gym Management Web Application

A **full-stack web application** for managing gym operations including member registration, trainer assignments, workout plans, payments, and attendance.  
This project demonstrates **modern web development practices** with a structured Java backend (Servlets & JSP) and MySQL database integration.

---

## ✨ Features

### 🔐 Authentication & Authorization
- Secure login system with **role-based access control** (Admin, Trainer, Member)
- Session management with automatic redirects
- Logout functionality with session invalidation

### 🧑‍🤝‍🧑 Member Management
- Register new members with personal details
- Update or delete member profiles
- Search/filter members
- View active/inactive status

### 🏋️ Trainer Management
- Register and manage trainer details
- Assign trainers to members
- Manage trainer schedules

### 📅 Workout & Diet Plans
- Create personalized workout routines
- Add diet charts for members
- Update, assign, and track plans

### 💳 Payments
- Manage membership fees
- Record transactions
- Generate and print invoices

### 🕒 Attendance Tracking
- Daily attendance logging
- Reports for member activity
- Track trainer/member check-ins

### 📊 Dashboard & Reports
- Real-time statistics: Total Members, Active Trainers, Revenue, Attendance
- Data visualization for admin
- Downloadable monthly reports

---

## 🛠️ Tech Stack

- **Frontend:** JSP, HTML5, CSS3, JavaScript, Bootstrap  
- **Backend:** Java Servlets, JSP, JDBC  
- **Database:** MySQL (with SQL scripts)  
- **Server:** Apache Tomcat 9/10/11  
- **Build Tool:** Maven  
- **Testing:** JUnit  
- **Architecture:** MVC pattern with DAO design  

---

## 📂 Project Structure

Gym-Management-Web/
├── src/
│ ├── controller/ # Servlets (MemberServlet, TrainerServlet, PaymentServlet, etc.)
│ ├── dao/ # DAO classes for DB operations
│ ├── model/ # Entity/DTO classes (Member, Trainer, Plan, Payment)
│ ├── service/ # Business logic services
│ ├── util/ # DB connection utilities, validators
│ └── test/ # JUnit test cases
├── webapp/
│ ├── WEB-INF/ # web.xml configuration
│ ├── jsp/ # JSP pages (UI templates)
│ └── index.jsp # Home page
├── database/
│ └── gym_management.sql # Database schema & seed data
└── pom.xml # Maven configuration

yaml
Copy code

---

## ⚙️ Installation & Setup

### Prerequisites
- JDK 11+  
- Apache Tomcat 9/10/11  
- MySQL Server  
- Maven  

### Steps
1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/Gym-Management-Web.git
   cd Gym-Management-Web
Database setup

Create MySQL database gym_management

Import the provided SQL script:

bash
Copy code
mysql -u root -p gym_management < database/gym_management.sql
Configure DB credentials in db.properties

properties
Copy code
db.url=jdbc:mysql://localhost:3306/gym_management
db.username=root
db.password=your_password
Build and deploy

bash
Copy code
mvn clean install
Deploy the generated .war file to Tomcat.

Access the application

arduino
Copy code
http://localhost:8080/Gym-Management-Web
🔑 Key Modules
Admin
Manage members, trainers, payments, workout/diet plans, and generate reports.

Trainer
View assigned members, manage workout/diet plans, and mark attendance.

Member
View assigned workout and diet plans, check fee status, and attendance logs.

📸 Screenshots
(Add screenshots here: Login Page, Dashboard, Member Management, Payment Section)

🧪 Testing
DAO Layer tested with JUnit + H2 in-memory DB

Unit testing for service classes

Servlet testing with mock request/response objects

🛡️ Security
Session-based authentication

SQL Injection protection with PreparedStatements

Input validation on both frontend and backend

Role-based access for critical modules

🚀 Deployment
Frontend
Runs as JSP pages deployed on Tomcat server

Backend
Java Servlets packaged as .war deployed on Tomcat

Database
MySQL hosted locally or on a cloud instance

🤝 Contribution
Contributions, issues, and feature requests are welcome.
Please open an issue or submit a pull request for improvements.
