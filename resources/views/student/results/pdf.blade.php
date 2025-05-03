<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Semester Results</title>
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
   </style>
</head>
<body>
   <div class="header">
       <h1>Semester Results</h1>
       <h2>{{ $enrollment->semester->name }} - {{ $enrollment->session->name }}</h2>
   </div>


   <div class="student-info">
       <p><strong>Student Name:</strong> {{ $enrollment->student->name }}</p>
       <p><strong>Student ID:</strong> {{ $enrollment->student->student_id }}</p>
       <p><strong>Semester:</strong> {{ $enrollment->semester->name }}</p>
       <p><strong>Academic Session:</strong> {{ $enrollment->session->name }}</p>
   </div>


   <table>
       <thead>
           <tr>
               <th>Course Code</th>
               <th>Course Name</th>
               <th>Teacher</th>
               <th>Marks</th>
               <th>Grade</th>
               <th>Remarks</th>
           </tr>
       </thead>
       <tbody>
           @foreach($enrollment->results as $result)
               <tr>
                   <td>{{ $result->course->code }}</td>
                   <td>{{ $result->course->name }}</td>
                   <td>{{ $result->course->teacher->name }}</td>
                   <td>{{ $result->marks ?? '-' }}</td>
                   <td>{{ $result->grade ?? '-' }}</td>
                   <td>{{ $result->remarks ?? '-' }}</td>
               </tr>
           @endforeach
       </tbody>
   </table>


   <div class="footer">
       <p><strong>Semester GPA:</strong> {{ number_format($gpa, 2) }}</p>
       <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
   </div>
</body>
</html>
