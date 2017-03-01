<?php
    
    function get_http_response_code($url)
    {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }
    
    $create_url = "http://www.shiksha.com/b-tech/colleges/b-tech-colleges-". $_GET["city_name"] ;
    
    if( get_http_response_code($create_url) != "200")
    {
        $json = [['error' => 1]];
        header("Content-type: application/json");
        print(json_encode($json, JSON_PRETTY_PRINT));
    }
    
    else
    {
        $data = file_get_contents($create_url);
        
        //finding the number of pages
        $page = '@(\d)</a></li>\s*<li class="next linkpagination">@';
        if(!preg_match($page, $data, $pages))
            $pages[1] = 1;
        //print($pages[1]);
    
        $json = [['pages' => $pages[1], 'error' => 0]];
    
        header("Content-type: application/json");
        print(json_encode($json, JSON_PRETTY_PRINT));
    }
?>