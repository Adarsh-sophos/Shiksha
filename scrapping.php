<?php

    $link = mysqli_connect("localhost", 'adarsh_jain', 'v1kCjsvLYytrBTGV', 'shiksha');
    if ($link -> connect_errno)
    {
        printf("Connect failed: %s\n", $link -> connect_error);
        exit();
    }
    
    //getting source of main page
    $data = file_get_contents("http://engineering.shiksha.com/be-btech-courses-in-jaipur-ctpg");
    
    //extracting every colleges' link and title
    $regex = '<a class="institute-title-clr" href="([^"]+)" title="([^"]+)">';
    
    //finding the number of pages
    $page = '@(\d)</a></li>\s*<li><a href="[^"]+" class="next">Next@';
    if(!preg_match($page, $data, $pages))
        print("Pages not found");
    print($pages[1]);
    
    if(!preg_match_all($regex, $data, $matches))
        print("No matches found\n");
    
    //print(sizeof($matches[1]));
    
    print($matches[2][1]);
    
    
    //Getting html of one college
    $first = file_get_contents($matches[1][1]);
    
    //Establishement year
    $esta = '@<label>Established in (\d+)<\/label>@';
    if(!preg_match($esta, $first, $year))
        print("Establishment year not found");
    print($year[1]);
    
    //Address of college
    $addr = '@<span class="flLt add-details">([^<]+)</span>@';
    if(!preg_match($addr, $first, $address))
        print("Address not found");
    $address[1] = trim($address[1]);
    print($address[1]);
    
    //Website of college
    $web = '@<span class="flLt add-details" itemprop="url">\s+<a href="([^"]+)"@';
    if(!preg_match($web, $first, $url))
        print("website not found");
    print($url[1]);
    
    //Courses offered
    $course_offered = '@<span class="flLt">([^<]+)</span>\s+</h3>@';
    if(!preg_match_all($course_offered, $first, $course))
        printf("Offered courses not found");
    //print(sizeof($course[1]));
    print(implode("#",$course[1]));
    
    //companies visited
    $com = '@<div class="overview overview_h">\s*<ul>\s*(<li>.*<\/li>|\s)*<\/ul>@';
    if(!preg_match($com, $first, $company))
        print("Can not found details\n");
    print_r($company[0]);
    
    
    //SQL queries
    $sql = sprintf("INSERT INTO `colleges` (`name`,`address`,`year`,`courses`,`company`,`url`) VALUES ('%s','%s','%s','%s','%s','%s') ",$matches[2][1], $address[1], $year[1], implode('#',$course[1]), $company[0], $url[1]);
    
    $check = mysqli_query($link, $sql);
    if($check === false)
        printf("Can not insert");
?>