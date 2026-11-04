# uniVersity – University Courses and Result Management System

A web-based University Management System developed using **PHP and Laravel** to simplify and organize academic activities. The system provides separate access for administrators, teachers, and students, allowing them to manage academic sessions, semesters, course enrollment, and student results through a centralized platform.

## Key Features

### 1. Role-Based Authentication
- Separate login access for administrators, teachers, and students.
- Student registration and authentication.
- Role-specific dashboards and protected routes.

### 2. Admin Panel
- Manage academic sessions.
- Create and update academic semesters.
- Add and update courses within semesters.
- Assign teachers as course instructors and semester advisors.

### 3. Student Panel
- Register and manage personal profiles.
- View academic information and enrollment history.
- Enroll in available academic sessions, semesters, and courses.
- View course results and academic performance.
- Download enrollment history and semester results as PDF files.

### 4. Teacher Panel
- Access teacher profiles and assigned academic information.
- Review student enrollment requests.
- Approve or reject enrollment requests.
- Add and update student marks, grades, and remarks.
- View results for assigned courses.

### 5. Course Enrollment Management
- Support student enrollment in academic sessions and semesters.
- Handle previously failed courses as retake courses.
- Apply a maximum credit limit of 28 during enrollment.
- Maintain enrollment status for administrative review.

### 6. Result Management
- Manage student marks, grades, and academic remarks.
- Calculate GPA based on course grades and credit hours.
- Generate downloadable PDF result reports.

## Technology Stack

| Category | Technologies |
|---|---|
| Backend | PHP 8.2+, Laravel 11 |
| Frontend | HTML, CSS, JavaScript, Bootstrap 5, Tailwind CSS |
| Database | Laravel-supported relational database |
| Build Tool | Vite |
| PDF Generation | Laravel DOMPDF |

## Project Structure

```text
uniVersity/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   └── web.php
├── tests/
├── .env.example
├── artisan
├── composer.json
└── package.json
```

## Installation and Setup

Follow these steps to run the project locally.

### Prerequisites

Make sure the following tools are installed:

- PHP 8.2 or later
- Composer
- Node.js and npm
- A supported database system

### Step 1: Clone the Repository

```bash
git clone https://github.com/TitlyBhattacharjee23/uniVersity.git
```

Navigate to the project directory:

```bash
cd uniVersity
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Configure Environment Variables

Copy the example environment file:

**Windows PowerShell:**
```powershell
Copy-Item .env.example .env
```

**Linux / macOS:**
```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### Step 4: Configure the Database

Update the database settings in the `.env` file according to your local database configuration.

The example environment file is configured to use SQLite by default. If using SQLite, ensure the database file exists before running migrations.

### Step 5: Run Database Migrations

```bash
php artisan migrate
```

### Step 6: Install Frontend Dependencies

```bash
npm install
```

Compile frontend assets:

```bash
npm run build
```

### Step 7: Start the Development Server

```bash
php artisan serve
```

Open the following URL in your browser:

```text
http://127.0.0.1:8000
```

## Future Improvements

- Enhanced academic reporting and analytics.
- Additional academic administration features.
- Improved user interface and accessibility.
- Expanded testing and validation.

## Contributing

Contributions, suggestions, and improvements are welcome. Feel free to fork the repository and submit a pull request.

## License

No specific project license is currently declared. Please contact the repository owner for usage and distribution permissions.

---

**Developed as an academic project using PHP and Laravel.**
