<!DOCTYPE html>
<html>
<head>
    <title>KWM lernt Laravel</title>
</head>
<body>
<ul>
    @foreach($padlets as $padlet)
        <li>{{$padlet->title}}</li>
    @endforeach
</ul>
</body>
</html>
