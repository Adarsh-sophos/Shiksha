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
        
        <!-- jquery.redirect/jquery.redirect.js -->
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
                
                <form id="form">
                    <fieldset>
                        <div class="form-group">
                            <input autocomplete="off" autofocus class="form-control" name="city" placeholder="Enter City Name(Not URL)" type="text"/>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default" type="submit">
                                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                                Submit
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div id="bottom">
                Brought to you by <a href="http://sophomores.in">Sophomores</a>.
            </div>

        </div>

    </body>

</html>
