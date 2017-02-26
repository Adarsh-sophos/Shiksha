<!DOCTYPE html>

<html>

    <head>

        <!-- http://getbootstrap.com/ -->
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>

        <link href="/css/styles.css" rel="stylesheet"/>

        <title>Scrapping</title>

        <!-- https://jquery.com/ -->
        <script src="/js/jquery-1.11.3.min.js"></script>

        <!-- http://getbootstrap.com/ -->
        <script src="/js/bootstrap.min.js"></script>

        <script src="/js/scripts.js"></script>
        
        <script src="js/jquery.redirect.js"></script>

    </head>

    <body>

        <div class="container">

            <div id="top">
                <div>
                    <a href="/"><img alt="Shiksha.com" src="/img/logo.png"/></a>
                </div>
                
                
            </div>

            <div id="middle">

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th style="text-align:center;">Number</th>
                        <th style="text-align:center;">Name</th>
                        <th style="text-align:center;">Addess</th>
                        <th style="text-align:center;">Year</th>
                        <th style="text-align:center;">Courses Offered</th>
                        <th style="text-align:center;">Top Recruiting Companies OR Infra./Teaching Facilities</th>
                        <th style="text-align:center;">Website</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                            $link = mysqli_connect("localhost", 'adarsh_jain', 'v1kCjsvLYytrBTGV', 'shiksha');
                            if ($link -> connect_errno)
                            {
                                printf("Connect failed: %s\n", $link -> connect_error);
                                exit();
                            }
                            
                            $sql = sprintf("SELECT * FROM colleges WHERE city = '%s'", $_POST["city"]);
                            $rows = mysqli_query($link, $sql);
                            if($check === false)
                                print("Can not fetch data");
                            
                            
                            $i = 1;
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
                                
                                print("<td>" . $row["company"] . "</td>");
                                print("<td>" . $row["url"] . "</td>");
                                print("</tr>");
                                $i = $i+1;
                            }
                            
                            mysqli_close($link);
                        ?>
                        
                    </tbody>
    
                </table>

            </div>

            <div id="bottom">
                Brought to you by <a href="http://sophomores.in">Sophomores</a>.
            </div>

        </div>

    </body>

</html>