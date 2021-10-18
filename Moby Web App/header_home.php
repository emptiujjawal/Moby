<head>
  <title>Moby</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      height: 100px;
      background: #fc5f43;
      color: #fff;
      padding-top: 25px;
      padding-bottom: 25px;
      border-bottom: 4px solid #eee;
    }
    .navbar-inverse {
      border: none;
      border-bottom: 4px solid #ff8f66;
    }
    .carousel-control.left  {
      background-image: none;
    }
    .carousel-control.right  {
      background-image: none;
    }
    body {
      background: #eee;
    }
    .content {
      padding-top: 15px;
      padding-bottom: 15px;
    }
    #main_content {
      background: #ffb499;
    }
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    /*.row.content {height: 450px}*/
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    .nav li:hover {
      background-color: #ffb499;
    }
    /* Set black background color, white text and some padding */
    footer {
      background: #fc5f43;
      color: white;
      padding: 25px;
      height: 100px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
</head>