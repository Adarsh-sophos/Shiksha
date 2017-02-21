<?php
    $data = file_get_contents("http://engineering.shiksha.com/be-btech-courses-in-jaipur-ctpg");
    
    $regex = '<a class="institute-title-clr" href="([^"]+)" title="([^"]+)">';
    
    if(!preg_match_all($regex, $data, $matches))
        print("No matches found\n");
    
    //print(sizeof($matches[1]));
    
    print($matches[2][0]);
    
    $first = file_get_contents($matches[1][0]);
    
    $esta = '@<label>Established in (\d+)<\/label>@';
    preg_match($esta, $first, $year);
    print($year[1]);
    
    $address = '@<span class="flLt add-details">([^<]+)</span>@';
    preg_match($address, $first, $add);
    $add[1] = trim($add[1]);
    print($add[1]);
    
    $web = '@<span class="flLt add-details" itemprop="url">\s+<a href="([^"]+)"@';
    preg_match($web, $first, $website);
    print($website[1]);
    
    $course_offered = '@<span class="flLt">([^<]+)</span>\s+</h3>@';
    preg_match_all($course_offered, $first, $course);
    print(sizeof($course[1]));
    print($course[1][3]);
    
    //$com = '@<div class="overview overview_h" style="[^"]+">\s+<ul>(?:<li>(.*)<\/li>|\s)*<\/ul>@';
    //preg_match($com, $first, $company);
    //print($company[1][0]);
?>