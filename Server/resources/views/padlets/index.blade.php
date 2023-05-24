<!DOCTYPE html>
<html>
<head>
    <title>KWM lernt Laravel</title>
</head>
<body>
<ul>
    @foreach($padlets as $padlet)
        <li><a href="/padlets/{{$padlet->id}}">{{$padlet->title}}</a></li>
    @endforeach
</ul>
</body>
</html>
