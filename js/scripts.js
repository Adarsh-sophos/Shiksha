$(function(){
    
    $("#form").submit( function(){
        
        var city_name = {
            city: $("#form").find('input[name="city"]').val()
        };
        
        $.getJSON("getpages.php", city_name)
        .done(function(data, textStatus, jqXHR) {
            var pages = data[0].pages;
            
            for(var i=1; i<=Number(pages); i++)
            {
                if(i==1)
                    var web_url = "http://engineering.shiksha.com/be-btech-courses-in-jaipur-ctpg";
                else
                    var web_url = "http://engineering.shiksha.com/be-btech-courses-in-jaipur-"+String(i)+"-ctpg";
                
                $.ajax({
                    url: '/scrapping.php',
                    type: 'POST',
                    data: { url : web_url },
                    success: function(output) {
                      alert(output);
                  }
                });
            }
            
            
        })
            
        .fail(function(jqXHR, textStatus, errorThrown) {

        // log error to browser's console
        console.log(errorThrown.toString());
        });
    });
});