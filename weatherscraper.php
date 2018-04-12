<?php
    $weather="";
    $error="";

    if(array_key_exists('city', $_GET)) {
        
        $city = str_replace(' ', '', $_GET['city']);
        
        $file_headers = @get_headers("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $error = "That city could not be found.";
        } else {
    
        $forecastPage = file_get_contents("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        $pageArray= explode('3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">',$forecastPage);
        
            if (sizeof($pageArray) > 1){
                $secondpageArray= explode('</span></span></span>',$pageArray[1]);
                
                if(sizeof($secondpageArray) > 1){
                    
                    $weather = $secondpageArray[0];
                    
                } else {
                    $error= "The city could not be found.";
                    }
            }else{
                $error = "The city could not be found.";
                }
        
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      
      
    <style type="text/css">
      
        html { 
              background: url(background.jpg) no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
            }
        body{
            background: none;
        }
        .container{
            text-align: center;
            margin-top: 100px;
            width: 450px;
        }
        input{
            margin: 20px 0;
        }
        #weather{
            margin-top: 15px;
        }
      
    </style>  
  </head>
  
    
  <body>
    <div class="container">    
        <h1>What's the weather?</h1>
        
        
        
        <form>
            
            <div class="form-group">
                <label for="city">Enter the name of a city</label>
                <input type="text" class="form-control" name= "city" id="city" placeholder="Eg. London, Tokyo" value="<?php                                                  if(array_key_exists('city', $_GET)){                                                                echo $_GET['city'];                                                          }       
                                ?>"> 
            </div>
            
            
            <button type="submit" class="btn btn-primary">Submit</button>
            <div id="weather"><?php
                
                if ($weather){
                    echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';

                }else if($error){
                    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
                }
                
                ?>
                
            
            </div>
            
            
        </form>
    </div> 
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>