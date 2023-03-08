<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th>Title</th>
            <th>Image</th>
        </tr>
        @foreach ($sliders as $slider)
        <tr>
           <td>{{$slider['Title']}}</td>
            <td>{{$slider['Image']}}</td>
             @endforeach

        </tr>
    </table>
</body>
</html>
