<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="application-name" content="Shop Lyssa Nicole" />

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>


    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Shop Lyssa Nicole</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="css/main.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    
    <style>
        
        img[src*="https://cdn.rawgit.com/000webhost/logo/e9bd13f7/footer-powered-by-000webhost-white2.png"] {
    display: none;}
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
                    <a class="navbar-brand" href="#">shop.lyssanicole <span class="glyphicon glyphicon-heart-empty" style="color: #FFC0CB"></span></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php"><span class=" glyphicon glyphicon-home"></span> Home</a></li>
                        <li><a href="collections.php"><span class="  glyphicon glyphicon-th"></span> Collections</a></li>
                        <li><a href="transactions.php"><span class="  glyphicon glyphicon-transfer"></span>  Transactions</a></li>
                        <li><a href="clearancesale.php"><span class="  glyphicon glyphicon-flash"></span> Clearance Sale</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right tasks">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tasks"></span> Statistics <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php
                                    require_once 'dbh.php';
                                    $sql_prog = "SELECT * FROM collections WHERE not(id='31') order by id desc limit 2";
                                    $result_prog = mysqli_query($conn,$sql_prog);
                                    
                                    while($row_prog = mysqli_fetch_assoc($result_prog)){
                                        $collection_latest = $row_prog['id'];
                                        $collection_latest_name = $row_prog['name'];
                                        
                                        $sql_items_all = "SELECT count(*) 'itemNum' FROM items WHERE collection = '$collection_latest'";
                                        $result_items_all = mysqli_query($conn,$sql_items_all);
                                        $row_items_all = mysqli_fetch_assoc($result_items_all);
                                        $itemNum = $row_items_all['itemNum'];

                                        $sql_item_sold = "SELECT count(*) 'itemSold' FROM orders JOIN items on orders.item = items.id WHERE collectionid='$collection_latest' and items.status = 'sold'";

                                        $result_item_sold = mysqli_query($conn,$sql_item_sold);
                                        $row_item_sold= mysqli_fetch_assoc($result_item_sold);
                                        $itemSold = $row_item_sold['itemSold'];
                                        if ($itemNum == 0){
                                            $progress_latest_collection = 0;
                                        }else{
                                            $progress_latest_collection = ($itemSold/$itemNum)*100;
                                        }
                                        
                                        $progress_latest_collection_percent = (int) $progress_latest_collection;
                                        echo <<<FRAG
                                        <li class="progress_nav">

                                        <div>
                                            <p>
                                                <strong class="progress_head">$collection_latest_name</strong>
                                                <span class="pull-right text-muted"> $progress_latest_collection_percent% Sold</span>
                                            </p>
                                            <div class="progress progress-striped active">
                                                <div class="progress-bar progress-bar" role="progressbar" aria-valuenow=" $progress_latest_collection" aria-valuemin="0" aria-valuemax="100" style="width: $progress_latest_collection%">
                                                    <span class="sr-only">$progress_latest_collection Sold</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
FRAG;
                                    } 
                                ?>
                                    <li class="divider"></li>
                                    <?php
                                    require_once 'dbh.php';
                                    $sql_prog = "SELECT * FROM collections WHERE id='31'";
                                    $result_prog = mysqli_query($conn,$sql_prog);
                                    
                                    while($row_prog = mysqli_fetch_assoc($result_prog)){
                                        $collection_latest = $row_prog['id'];
                                        $collection_latest_name = $row_prog['name'];
                                        
                                        $sql_items_all = "SELECT count(*) 'itemNum' FROM items WHERE collection = '$collection_latest'";
                                        $result_items_all = mysqli_query($conn,$sql_items_all);
                                        $row_items_all = mysqli_fetch_assoc($result_items_all);
                                        $itemNum = $row_items_all['itemNum'];

                                        $sql_item_sold = "SELECT count(*) 'itemSold' FROM orders JOIN items on orders.item = items.id WHERE collectionid='$collection_latest' and items.status = 'sold'";

                                        $result_item_sold = mysqli_query($conn,$sql_item_sold);
                                        $row_item_sold= mysqli_fetch_assoc($result_item_sold);
                                        $itemSold = $row_item_sold['itemSold'];

                                        if($itemSold == 0){
                                            $progress_latest_collection = 0;
                                        }else{
                                            $progress_latest_collection = ($itemSold/$itemNum)*100;
                                        }
                                        $progress_latest_collection_percent = (int) $progress_latest_collection;
                                        echo <<<FRAG
                                        <li class="progress_nav">

                                        <div>
                                            <p>
                                                <strong class="progress_head">$collection_latest_name</strong>
                                                <span class="pull-right text-muted"> $progress_latest_collection_percent% Sold</span>
                                            </p>
                                            <div class="progress progress-striped active">
                                                <div class="progress-bar progress-bar" role="progressbar" aria-valuenow=" $progress_latest_collection" aria-valuemin="0" aria-valuemax="100" style="width: $progress_latest_collection%">
                                                    <span class="sr-only">$progress_latest_collection Sold</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
FRAG;
                                    } 

                                    
                                ?>

                                        <li class="divider"></li>
                                        <li>
                                            <a class="text-center" href="statistics.php">
                                                <strong><span style="font-size: 20px;color: #FFC0CB" class=" glyphicon glyphicon-stats "></span> See All Statistics <span style="color: #FFC0CB" class=" glyphicon glyphicon-arrow-right"></span></strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>
