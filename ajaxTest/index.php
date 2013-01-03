<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/site.css" />
    <link rel="stylesheet"  href="css/jquery.mobile-1.2.0.css" />
    <script type="text/javascript" src="js/jquery182.js"></script>
    <script src="js/jquery.mobile-1.2.0.js"></script>
    
    <script type="text/javascript">

    $(document).ready( function() 
    {
            
        //To hold color rgb values
        var rgbColor = {};
        rgbColor.red = 0;
        rgbColor.green = 0;
        rgbColor.blue = 0;
    
        //Attach events to when sliders are released
        $("#slider-red").on( 'slidestop', function( event ) {
            ajaxSetColor(event);
        });
        $("#slider-green").on( 'slidestop', function( event ) {
            ajaxSetColor(event);
        });
        $("#slider-blue").on( 'slidestop', function( event ) {
            ajaxSetColor(event);
        });
        
        
        function ajaxSetColor(event){
            
            rgbColor.red = $('#slider-red').val();
            rgbColor.green = $('#slider-green').val();
            rgbColor.blue = $('#slider-blue').val();
            $.ajax({
                    type: 'POST',
                    url:'ajax.php/slideStopHandler',
                    //data: {json:event},
                    data: {json:JSON.stringify(rgbColor)},
                    global:false,
                    async: true,
                    dataType: 'json',
                    success: function(result) {
                        
                        //Populate page element with result from server
                        $('#response-div-2').attr('style','background: rgba(' + result.red + ',' + result.green + ',' + result.blue +', 1);');
                    
                    },
                    error: function(xhr,err){
                        
                        $('#error-div').html(xhr.responseText);
                        $('#error-div').fadeIn();
                    }
                });
        }
        
        $('.btnDo').bind('click', function(){

            //Open popup and show something is happening
            $('#response-div').fadeOut('fast', function(){
                $('#response-div').html('<img src="images/ajax-loader.gif"></img>');
                $( '#response-div-popup' ).popup('open');
            });
            
            $('#response-div').fadeIn();

            //Collect data to post
            var textData =
            {
                'text':$('.txtDo').val()

            };

            //Post data to server
            $.ajax({
                    type: 'POST',
                    url:'ajax.php/ajaxCalledFunction',
                    data: {json:JSON.stringify(textData)},
                    global:false,
                    async: true,
                    dataType: 'json',
                    success: function(result) {
                        
                        //Populate page element with result from server
                        
                        $('#response-div').fadeOut('fast', function(){
                        
                            $('#response-div').html(result.text);
                        });

                        $('#response-div').fadeIn();

                        
                    },
                    error: function(msg)
                    {
                        alert(msg.d)
                    }
                });
        });
    });
    </script>
<title><?php echo "Ajax Test"; ?></title>
</head>
<body>
    <div data-role="page" class="type-home">
        <div data-role="content">
            <div id="jqm-homeheader">
                <h1>Nothing fancy!</h1>
                <p>A  mobile web-app doing capable of serverside text reversing and  changing background color of a DIV.</p>
            </div>
            <div id="inputs-div">
                <p class="intro"><strong>Ajax text reverser</strong> This input sends submitted text as JSON to ajax.php, which in turn reverses the text and returns JSON result.</p>
                <input type="text" class="txtDo"/>
                <input type="button" value="Reverse" class="btnDo"/>
                <p class="intro"><strong>Color picker</strong> This input sends submitted text as JSON to ajax.php, which in turn reverses the text and returns JSON result.</p>
                <label for="slider-red">Red:</label>
                <input type="range" name="slider-fill" id="slider-red" value="60" min="0" max="255" data-highlight="true" />
                <label for="slider-green">Green:</label>
                <input type="range" name="slider-fill" id="slider-green" value="60" min="0" max="255" data-highlight="true" />
                <label for="slider-blue">Blue:</label>
                <input type="range" name="slider-fill" id="slider-blue" value="60" min="0" max="255" data-highlight="true" />
            </div>
            <div data-role="popup"  id="response-div-popup">
                
                <div id="response-div"></div>
                
            </div>
                
                <div id="response-div-2"></div>
                <div id="error-div"></div>
        </div> 
    </div>
</body>

</html>