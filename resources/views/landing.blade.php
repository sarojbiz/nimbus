<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    
    <title>Siraha Supermarket</title>
    
    <link href="{{asset('landing/css/bootstrap.css')}}" rel="stylesheet" />
	<link href="{{asset('landing/css/coming-sssoon.css')}}" rel="stylesheet" />    
    
    <!--     Fonts     -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
  
</head>

<body>
<nav class="navbar navbar-transparent navbar-fixed-top" role="navigation">  
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">   
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>
<div class="main" style="background-image: url('{{asset('landing/images/default.jpg')}}')">
    
    <div class="cover black" data-color="black"></div>

    <div class="container">
        <h1 class="logo cursive">
          Siraha Supermarket
        </h1>
        
        <div class="content">
            <h4 class="motto">Our Ecommerce website will be ready soon.</h4>
            <div class="subscribe">
                <h5 class="info-text">
                    Join the waiting list for the beta. We keep you posted. 
                </h5>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 col-sm6-6 col-sm-offset-3 ">
                        <form method="POST" action="#" class="form-inline" role="form">
                          <div class="form-group">
                            <label class="sr-only" for="exampleInputEmail2">Email address</label>
                            <input type="email" class="form-control transparent" placeholder="Your email here...">
                          </div>
                          <button type="submit" class="btn btn-danger btn-fill">Notify Me</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
      <div class="container">
            Powered By <a href="http://ssm.com.np/" target="_blank"> Siraha Supermarket </a>
      </div>
    </div>
 </div>
 </body>
 
   <script src="{{asset('landing/js/jquery-1.10.2.js')}}" type="text/javascript"></script>
   <script src="{{asset('landing/js/bootstrap.min.js')}}" type="text/javascript"></script>

</html>