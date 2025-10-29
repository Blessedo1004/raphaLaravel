<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('images/icon1.png') }}" type="image/png" sizes="16x16">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Reservation Details</title>
</head>
<body>
  <h3>Room Type : {{$pending->room->name}}</h3>
  <h3>Check In Date : {{$pending->check_in_date}}</h3>
  <h3>Check Out Date : {{$pending->check_out_date}}</h3>
  <h3>Reservation ID : {{$pending->reservation_id}}</h3>
  <h3>Expiry Date : {{$pending->expires_at}}</h3>
</body>
</html>


