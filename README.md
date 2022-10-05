# Shiksha.com-

DOCUMENTATION For **Web Scrapper**

> Developed By
>
> ***Adarsh Jain***

<br/>

## About
- This is a web based application to scrape data of all the engineering colleges in a particular city from the website of Shiksha.com.
- This website takes a name of city as an input and scrape the data of all the engineering colleges located in that city. For e.g. if you go to: http://www.shiksha.com/b-tech/colleges/b-tech-colleges-bangalore, this URL shows a list of 85 engineering colleges based in Bangalore.
- This app takes one such **CITY NAME** from ***Shiksha.com*** of a particular city (BANGALORE in the aforementioned case) as an input using an HTML Form and scrape the following data of all the engineering colleges (85 in the case of Bangalore) located in that particular city:
  - College name
  - College address.
  - Year of establishment (if found)
  - Title of the courses offered.
  - Infrastructure/Teaching Facilities (if found)
  - URL of college's Website. (if found)

- The data scraped thereafter is placed and stored well in a MySQL database. The stored data is then displayed on the web page in an HTML Table.

<br/>

## Starting the server
To start the web and MySql Server, type the following commands-
```
apache50 start ~/workspace/Shiksha/
mysql50 start
```

<br/>

## Structure of Website
### index.php
It is the root of website. Whenever a request comes, it displays the index.php data which is a HTML Form. This HTML Form takes a city name as input.

### scripts.js
Here lies the main logic of app.
- There is a **submit event** on the HTML form of ***index.php***. As soon as submit button is clicked, _js_ file stores the inputted city name in a variable _ci_. It stores lowercase version of inputted city name.
  ```
  var ci = $("#form").find('input[name="city"]').val().toLowerCase();
  ```
  
- Then it shows a progress bar which is a gif file and stored in _"/img/ajax-loader.gif"_.
  ```
  $("#middle").html('<img alt="please wait" src="/img/ajax-loader.gif">');
  ```
  
 - Now it sends a request to ***getpages.php*** which returns the _number of pages_ in which colleges are displayed. This returned value is stored in data object. Then we check the **data[0].error** field, if it is 1 it means that city name was not valid and it displays an error.
    ```
    if( Number(data[0].error) == 1 )
    {
       $("#middle").html("<h3>Sorry!! City doensn't exist</h3></br><p>redirecting you in 3 seconds...</p>");
       setTimeout(function(){$.redirect('/');}, 3000);
                
       return;
    }
    ```
  
- Otherwise, we go in a loop _number of pages_ times, creates ***URL*** and send **AJAX** requests to ***scrapping.php*** file (which we will see little bit latter) in every iteration of loop.
  ```
    for(var i=1; i<=Number(pages); i++)
    {
        if(i==1)
            var web_url = "http://www.shiksha.com/b-tech/colleges/b-tech-colleges-"+ ci ;
        else
            var web_url = "http://www.shiksha.com/b-tech/colleges/b-tech-colleges-" + ci + "-" + String(i);
                
        $.ajax({
             url: '/scrapping.php',
             type: 'POST',
             data: { url : web_url, city: ci },
             success: function(output) {
             console.log(output);
             }
        });
     }
  ```
  
- When all the AJAX request made **stops**, it redirects to ***table.php*** which shows an _HTML table_ containing data.
  ```
  $(document).ajaxStop( function() {                
                $.redirect('/table.php', {'city': ci}, "POST");              
            });
  ```
  
### getpages.php
We have seen above that js file sends a request with city name to the getpages.php file.
- It has city name in the variable **$\_GET["city_name"]** from which it creates URL for inputted city.
  ```
  $create_url = "http://www.shiksha.com/b-tech/colleges/b-tech-colleges-". $_GET["city_name"] ;
  ```
  
- It checks that URL's response code, if it's not **200** then URL is not correct and it sets the error field 1.
  ```
  if( get_http_response_code($create_url) != "200")
  {
       $json = [['error' => 1]];
       header("Content-type: application/json");
       print(json_encode($json, JSON_PRETTY_PRINT));
  }
  ```
  
- Otherwise, it finds the _number of pages_ in webiste using following **RegEx**.
  ```
  $page = '@(\d)</a></li>\s*<li class="next linkpagination">@';
  ```
  
- Now it sends the ***JSON data*** to requested _js_ file.
  ```
  $json = [['pages' => $pages[1], 'error' => 0]];  
  header("Content-type: application/json");
  print(json_encode($json, JSON_PRETTY_PRINT));
  ```
  
### scrapping.php
This file scraps the data and stores data in the MySql database.
We have seen in scripts.js file that it sends **AJAX** request to scrapping.php file with the URL created.
- It gets the source data of the page.
  ```
  //getting source of main page
  $data = file_get_contents($_POST["url"]);
  ```
  
- Then we have a sequence of ***RegEx expressions*** getting the all of the data of the various colleges. You can see all of these in the scrapping.php file.
- Finally, we check that the scrapped data is already in the database or not. If it's already stored, then we just update the data otherwise, it is inserted in the database.
  ```
  //SQL queries
  $first = sprintf("SELECT * FROM colleges WHERE city='%s' AND name='%s'", $_POST["city"], $matches[2][$i]);
  $result = mysqli_query($link, $first);
  $n = mysqli_num_rows($result);

  if($n == 0)
       $sql = sprintf("INSERT INTO colleges (city,name,address,year,courses,infra,url) VALUES ('%s','%s','%s','%s','%s','%s','%s') ", $_POST["city"], $matches[2][$i], $address[1], $year[1], implode('#',$course[1]), implode('#',$inf[1]) , $url[1]);
  else
       $sql = sprintf("UPDATE colleges SET courses='%s',infra='%s',url='%s' WHERE city='%s' AND name='%s' ", implode('#',$course[1]), implode('#',$inf[1]), $url[1], $_POST["city"], $matches[2][$i]);
  ```

### table.php
This file shows the HTML Table containing data of colleges.
```
while($row = mysqli_fetch_array($rows))
{
	print("<tr>");
	print("<td>" . $i . "</td>");
	print("<td>" . $row["name"] . "</td>");
	print("<td>" . $row["address"] . "</td>");
	print("<td>" . $row["year"] . "</td>");
	
	print("<td><ul>");
	$course = explode("#",$row["courses"]);
	for($j=0; $j< sizeof($course); $j++)
		print("<li>". $course[$j] ."</li>");
	print("</ul></td>");
	
	print("<td><ul>");
	$infra = explode("#",$row["infra"]);
	for($j=0; $j< sizeof($infra); $j++)
		print("<li>". $infra[$j] ."</li>");
	print("</ul></td>");

	print("<td>" . $row["url"] . "</td>");
	print("</tr>");
	$i = $i+1;
}
