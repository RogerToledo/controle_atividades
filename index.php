<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="#">

        <title>Softplan | Login</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>

    <body style="background-image: url('system/index-image.jpg')">
        <?php
            $Data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            //var_dump($Data);
            require './system/login.class.php';
            if($Data['submit'] == 'login'):
                $login = new login;
                $login->loginSoft($Data);
                echo $login->getResult();
                    
            endif;
        ?>
        <div class="container">
            <div class="panel panel-primary" style="width: 45%; height: 282px; margin-left: 60%">
                <div class="panel-heading" ><h4>Softplan | Login</h4></div>
                <div class="panel-body" style="background: rgba(70, 130, 180, 0.4)">
                    <form class="form-horizontal" method="POST" action="" name="login_form">
                        <div class="form-group">
                            <label class="control-label col-sm-offset-1 col-sm-2" for="user">Email:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="user" name="usr_email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-offset-1 col-sm-2" for="pwd">Password:</label>
                            <div class="col-sm-6">          
                                <input type="password" class="form-control" id="pwd" name="usr_pass" required>
                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="col-sm-offset-4 col-sm-9" style="margin-top: 15px">
                                <button type="submit" class="btn btn-primary col-sm-5" name="submit" value="login">Submit</button>
                            </div>
                            
                        </div>
                        <div class="form-group"> 
                        <div class="col-sm-offset-9 col-sm-3">
                            <p><small>Versão: <?=VERSION?></small></p>
                            </div>
                        </div>    
                    </form>
                </div>
            </div>    
         </div>
      
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>

