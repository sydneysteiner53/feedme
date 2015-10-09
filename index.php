<!doctype html>
<html>
<head>
    <title> hungry? </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<h1> Hungry? </h1>
<h2> Starving. </h2>
<h3> Where are you looking for a restaurant? </h3>


<form action="search.php" method="POST">
    <div class="form-group">
        <label> Location: <br> (Town, City) </label>
        <input type="text" class="form-control" name="location" id="location">
    </div>
    <div class="form-group">
        <label for="filter">Filter by:</label>
        <select name="group" class="form-control" id="filter">
            <option value="no filter"> No Filter </option>
            <option value="outdoor seating">Outdoor Seating</option>
            <option value="credit cards">Accepts Credit Cards</option>
<!--            <option value="Wheelchair Accessible"> Wheelchair Accessible</option>-->
            <option value="reservations">Accepts Reservation</option>
        </select>
        <br>
        <input type="submit" class="btn btn-success btn-lg btn-block">
    </div>


    </select>
    </div>
<div class="col-md-4 col-md-offset-4">

</div>
</form>
</body>
</html>


