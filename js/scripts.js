$(function(){
    
    $("#form").submit( function(){
        
        //event.preventDedault();
        var ci = $("#form").find('input[name="city"]').val().toLowerCase();
        var city = {
            city_name: ci
        };
        
        $("#middle").html('<img alt="please wait" src="/img/ajax-loader.gif">');
        
        $.getJSON("/getpages.php", city)
        .done(function(data, textStatus, jqXHR) {
            
            if( Number(data[0].error) == 1 )
            {
                $("#middle").html("<h3>Sorry!! City doensn't exist</h3></br><p>redirecting you in 3 seconds...</p>");
                setTimeout(function(){$.redirect('/');}, 3000);
                
                return;
            }
            
            var pages = data[0].pages;
            
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
            
            $(document).ajaxStop( function() {
                
                $.redirect('/table.php', {'city': ci}, "POST");
                
            });
            
        })
            
        .fail(function(jqXHR, textStatus, errorThrown) {

        // log error to browser's console
        console.log(errorThrown.toString());
        });
        
        return false;
    });
    
    
});