<?php

    $create_url = "http://www.shiksha.com/b-tech/colleges/b-tech-colleges-". $_GET["city_name"] ;
    $data = file_get_contents($create_url);
    
    //finding the number of pages
    $page = '@(\d)</a></li>\s*<li class="next linkpagination">@';
    if(!preg_match($page, $data, $pages))
        print("Pages not found");
    //print($pages[1]);
    
    $json = [['pages' => $pages[1]]];
    
    header("Content-type: application/json");
    print(json_encode($json, JSON_PRETTY_PRINT));
    
?>