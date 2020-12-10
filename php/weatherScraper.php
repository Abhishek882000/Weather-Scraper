<?php

$weatherSummary = "";
$error = "";
if ($_GET['city']) {

    $city = str_replace(' ', '', $_GET['city']);

    $file_headers = @get_headers("https://www.weather-forecast.com/locations/" . $city . "/forecasts/latest");

    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        $error = "That city could not be found";
    } else {

        $forecastPage = file_get_contents("https://www.weather-forecast.com/locations/" . $city . "/forecasts/latest");

        $pageArray = explode('1&ndash;3 days):</div><p class="location-summary__text"><span class="phrase">', $forecastPage);

        if (sizeof($pageArray) > 1) {
            $secondArray = explode('</span></p></div>', $pageArray[1]);

            if (sizeof($secondArray) > 1) {
                $weatherSummary = $secondArray[0];
            } else {
                $error = "That city could not be found";
            }

            $weatherSummary = $secondArray[0];
        } else {
            $error = "That city could not be found";
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Weather Scraper</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            background: none;
        }

        html {
            background: url(back.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .container {
            margin-top: 90px;
        }

        .form-container {
            text-align: center;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-white text-center pt-5">What's The Whether?</h1>
        <p class="lead text-white text-center pt-1">Enter the name of a city</p>
    </div>

    <div class="form-container w-50">
        <form method="GET">
            <div class="form-group">
                <input type="text" class="form-control" name="city" placeholder="Eg.London, Tokyo" value="<?php echo $_GET['city']; ?>">
            </div>
            <button type="submit" class="btn btn-primary mt-2 mb-2" id="submitBtn">Submit</button>

            <div id="weather"><?php
                                if ($weatherSummary) {
                                    echo '<div class="alert alert-success" role="alert">
                                    ' . $weatherSummary . '
                                  </div>';
                                } else if ($error) {
                                    echo '<div class="alert alert-danger" role="alert">
                                    ' . $error . '
                                  </div>';
                                }
                                ?></div>
        </form>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>