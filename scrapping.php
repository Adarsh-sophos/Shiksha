<?php
    $data = file_get_contents("http://engineering.shiksha.com/be-btech-courses-in-jaipur-ctpg");
    
    $regex = '<a class="institute-title-clr" href="([^"]+)" title="([^"]+)">';
    
    $page = '@(\d)</a></li>\s*<li><a href="[^"]+" class="next">Next@';
    if(!preg_match($page, $data, $pages))
        print("Pages not found");
    print($pages[1]);
    
    if(!preg_match_all($regex, $data, $matches))
        print("No matches found\n");
    
    //print(sizeof($matches[1]));
    
    print($matches[2][0]);
    
    $first = file_get_contents($matches[1][0]);
    
    $esta = '@<label>Established in (\d+)<\/label>@';
    if(!preg_match($esta, $first, $year))
        print("Establishment year not found");
    print($year[1]);
    
    $address = '@<span class="flLt add-details">([^<]+)</span>@';
    if(!preg_match($address, $first, $add))
        print("Address not found");
    $add[1] = trim($add[1]);
    print($add[1]);
    
    $web = '@<span class="flLt add-details" itemprop="url">\s+<a href="([^"]+)"@';
    if(!preg_match($web, $first, $website))
        print("website not found");
    print($website[1]);
    
    $course_offered = '@<span class="flLt">([^<]+)</span>\s+</h3>@';
    if(!preg_match_all($course_offered, $first, $course))
        printf("Offered courses not found");
    print(sizeof($course[1]));
    print($course[1][3]);
    
    //$com = '@<div class="overview overview_h" style="[^"]+">\s+<ul>(?:<li>(.*)<\/li>|\s)*<\/ul>@';
    //preg_match($com, $first, $company);
    //print($company[1][0]);
    
    
?>