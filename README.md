# Gym Management Web Application

A **full-stack web application** for managing gym operations including member registration, trainer assignments, workout plans, payments, and attendance.  
This project demonstrates **modern web development practices** with a structured backend and an interactive frontend.

---

## 🚀 Features
- 🔐 **Authentication & Authorization**  
  Secure login and role-based access (Admin, Trainer, Member)

- 🧑‍🤝‍🧑 **Member Management**  
  Add, edit, delete, and view members with personal details

- 🏋️ **Trainer Management**  
  Assign trainers to members and manage their schedules

- 📅 **Workout & Diet Plans**  
  Create, assign, and update personalized workout and diet plans

- 💳 **Payments**  
  Track membership fees, generate invoices, and manage transactions

- 🕒 **Attendance Tracking**  
  Record daily attendance of members

- 📊 **Dashboard & Reports**  
  Real-time statistics for admin with visualizations (members, revenue, attendance)

---

## 🛠️ Tech Stack
- **Frontend:** HTML, CSS, JavaScript, Bootstrap  
- **Backend:** Java (Servlets, JSP), JDBC  
- **Database:** MySQL  
- **Server:** Apache Tomcat  
- **Build Tool:** Maven  
- **Testing:** JUnit  

---

## 📂 Project Structure
src/
├── controller/ # Servlets (MemberServlet, TrainerServlet, PaymentServlet, etc.)
├── dao/ # DAO classes for DB operations
├── model/ # Entity classes (Member, Trainer, Plan, Payment)
├── service/ # Business logic
├── util/ # DB connection, validators
├── webapp/
│ ├── WEB-INF/ # web.xml
│ ├── jsp/ # JSP pages (frontend)
│ └── index.jsp # Landing page
└── test/ # JUnit test cases

yaml
Copy code

---

## ⚙️ Installation & Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/Gym-Management-Web.git
   cd Gym-Management-Web
Configure the database:

Create MySQL DB gym_management

Import gym_management.sql from /database folder

Update DB credentials in db.properties:

properties
Copy code
db.url=jdbc:mysql://localhost:3306/gym_management
db.username=root
db.password=your_password
Build and deploy:

bash
Copy code
mvn clean install
Deploy .war to Tomcat.

Access the app:

arduino
Copy code
http://localhost:8080/Gym-Management-Web
🔑 Key Modules
Admin: Manage members, trainers, plans, and reports

Trainer: Assign workout/diet plans, track attendance

Member: View assigned workout/diet plans, check payment status

