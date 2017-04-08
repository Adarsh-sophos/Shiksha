<?php

    $link = mysqli_connect("localhost", 'adarsh_jain', 'v1kCjsvLYytrBTGV', 'shiksha');
    if ($link -> connect_errno)
    {
        printf("Connect failed: %s\n", $link -> connect_error);
        exit();
    }
    
    //getting source of main page
    $data = file_get_contents($_POST["url"]);
    
    //extracting every colleges' link and title
    $regex = '@<h2 class="tuple-clg-heading"><a href="([^"]*)" target="_blank">([^<]*)</a>@';
    
    if(!preg_match_all($regex, $data, $matches))
        print("No matches found\n");
    
    //print(sizeof($matches[1]));
    
    for($i=0; $i<sizeof($matches[1]); $i++)
    {
        print($matches[2][$i]." => ");
    
    
        //Getting html of one college
        $first = file_get_contents($matches[1][$i]);
    
        //Establishement year
        $esta = '@Established (\d*)@';
        if(!preg_match($esta, $first, $year))
        {
            print(" Establishment year not found ");
            $year[1] = "-";
            //print($year[1]);
        }
    
        //Address of college
        $addr = '@Address</p>\s*<p class="c-num">([^<]*)</p>@';
        if(!preg_match($addr, $first, $address))
        {
            $addr = '@Address</p>\s*<p class="c-num">([a-z A-Z.,\d&;/<>\s-]*)@';
            if(!preg_match($addr, $first, $address))
            {
                print(" Address not found ");
                $address[1] = "-";
            }
    
            $address[1] = explode("</p>", $address[1])[0];
        }
        
        $address[1] = trim($address[1]);
        //print($address[1]);
    
        //Website of college
        $web = '@Website<\/p>\s*<p class="c-num"><a href="([^"]*)"@';
        if(!preg_match($web, $first, $url))
        {
            print(" website not found ");
            $url[1] = "-";
        }
        //print($url[1]);
    
        //Courses offered
        
        $course_offered = '@VIEW_ALL_POPULAR_COURSES" href="([^"]*)"@';
        if(!preg_match($course_offered, $first, $course))
        {
            $course_offered = '@<div class="offered-name">\s*<p class="para-1" title="([^"]*)">@';
            if(!preg_match_all($course_offered, $first, $course))
            {
                printf(" Offered courses not found ");
                $course[1] = "-";
            }
            
        }
        else
        {
            $off = file_get_contents($course[1]);
            $new = '@<h5 class="tpl-course-name"><a target="_blank" href="[^"]*">([^<]*)</a></h5>@';
            if(!preg_match_all($new, $off, $course))
            {
                printf(" Offered courses not found ");
                $course[1] = "-";
            }
        }
        //print(sizeof($course[1]));
        //print(implode("#",$course[1]));
      
        //infrastructure
        $infra = '@<li class="">\s*<a class="[^"]*">([^<]*)\s*</a></li>@';
        if(!preg_match_all($infra, $first, $inf))
        {
            print(" Infrastructure not found ");
            $inf[0] = "-";
        }
        //print_r($inf);
    
    
        //SQL queries
        $first = sprintf("SELECT * FROM colleges WHERE city='%s' AND name='%s'", $_POST["city"], $matches[2][$i]);
        $result = mysqli_query($link, $first);
        $n = mysqli_num_rows($result);

        if($n == 0)
            $sql = sprintf("INSERT INTO colleges (city,name,address,year,courses,infra,url) VALUES ('%s','%s','%s','%s','%s','%s','%s') ", $_POST["city"], $matches[2][$i], $address[1], $year[1], implode('#',$course[1]), implode('#',$inf[1]) , $url[1]);
        else
            $sql = sprintf("UPDATE colleges SET courses='%s',infra='%s',url='%s' WHERE city='%s' AND name='%s' ", implode('#',$course[1]), implode('#',$inf[1]), $url[1], $_POST["city"], $matches[2][$i]);
        
        
        $check = mysqli_query($link, $sql);
        if($check === false)
            printf(" Can not insert ");
        
        sleep(1.5);
        
        print("\n");
    }
    
    mysqli_close($link);

?>