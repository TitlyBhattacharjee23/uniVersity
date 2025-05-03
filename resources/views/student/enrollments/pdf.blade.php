<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enrollment History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .student-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .semester-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .semester-header {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 10px;
        }
        .course-list {
            margin-left: 20px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Enrollment History</h1>
    </div>

    <div class="student-info">
        <p><strong>Student Name:</strong> {{ $student->name }}</p>
        <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
    </div>

    @foreach($student->enrollments->sortByDesc('created_at') as $enrollment)
        <div class="semester-section">
            <div class="semester-header">
                <h3>{{ $enrollment->semester->name }} - {{ $enrollment->session->name }}</h3>
                <p>
                    <strong>Enrollment Date:</strong> {{ $enrollment->created_at->format('M d, Y h:i A') }} |
                    <strong>Status:</strong> {{ ucfirst($enrollment->status) }} |
                    <strong>Advisor:</strong> {{ $enrollment->semester->advisor->name }}
                </p>
            </div>

            <div class="course-list">
                <h4>Enrolled Courses:</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Teacher</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollment->semester->courses as $course)
                            <tr>
                                <td>{{ $course->code }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->teacher->name }}</td>
                                <td>{{ $course->credit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <div class="footer">
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
