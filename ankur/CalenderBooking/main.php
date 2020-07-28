<html>
<head>
    <link href="calendar.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php
include 'Calender.php';
include 'booking.php';
include 'BookBox.php';
 
 
$booking = new Booking(
    'tutorial',
    'localhost',
    'root',
    
);
 
$bookablebox = new BookBox($booking);
 
$calendar = new Calender();
 
$calendar->check_type('showCell', $bookableCell);
 
$bookablebox->routeActions();
 
echo $calendar->show();
?>
</body>
</html>