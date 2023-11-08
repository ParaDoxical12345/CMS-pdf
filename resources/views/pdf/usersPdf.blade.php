<!DOCTYPE html>
<html>
<head>
    <title>MEDICAL CERTIFICATE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>

    <p class="image" style="text-align: left; margin-bottom: 18pt">
    <img src="{{public_path('images/mdclogo.jpg')}}" style="width: 125px;" alt=""> <br>
    <br>
    </p>

    <div class="intro text-align text-center">
        <h1>{{ $title }}</h1>
        <h3>{{ $header }}</h3>
        <h4>{{ $address }}</h4>
        <h5>{{ $facility }}</h5>

    </div>
    <br>
    <p class="text-align text-end">{{ $date }}</p>
    @foreach($users as $user)

    <p>This is to certify that I have personally examined {{$user->firstname}} {{$user->lastname}}  {{$user->gender}}</p>
    <p>From  Course Have found the he/she is Physically and mentally fit during the time of the examnination</p>

    <br>

    <p>This certificate is issued upon his/her request and should not be used for any medico-legal purposes.</p>
    @endforeach

    {{-- {{$patient->age}}
    {{$patient->course}}
    {{$patient->address}} --}}
</body>
</html>

<style>
    * {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif';

    }
    image{

    }
</style>
