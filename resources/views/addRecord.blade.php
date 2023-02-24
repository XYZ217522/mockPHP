<!DOCTYPE html>
<html>
<head>
    <title>add games</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<h2>You can add a game Record here.</h2>

<form method="POST" action="{{route('update-game-records')}}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="event_id">event ID:</label><br>
        <input type="text" id="event_id" name="event_id"><br>
        @if ($errors->any())
            <p class="text-danger">{{$errors->first('event_id')}}</p>
        @endif
    </div>
    <div class="form-group">
        <label for="got_money">got money:</label><br>
        <input type="text" id="got_money" name="got_money"><br><br>
        @if ($errors->any())
            <span class="text-danger">{{ $errors->first('got_money') }}</span>
        @endif
    </div>
    <button type="submit">add a game Record</button>
</form>


</body>
</html>



