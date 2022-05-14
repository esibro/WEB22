<!DOCTYPE html>
<html lang="de">
<head>
    <title>Go Student</title>
</head>
<body>
<h1>Go Student</h1>

<ul>
    @foreach ($courses as $course)
        <li><a href="courses/{{$course->id}}"> {{$course->subject}}</a> </li>
    @endforeach
</ul>
</body>
</html>
