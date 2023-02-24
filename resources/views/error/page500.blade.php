<!DOCTYPE html>
<html>
<head>
    <title>500</title>
</head>

<body>
<h1>500</h1>
<h2>status：{{ $statusCode ?? 'unknown' }}</h2>
<h3>@if($statusCode == 419){{ '閒置時間過久已逾時，請回首頁後再重新進入' }}@else{{ '啊呀！目前網頁無法正常運作....' }}@endif</h3>

</body>
</html>



