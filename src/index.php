<?php require_once 'includes/header.inc.php' ?>
<div class="container">
  <h2 class="pagehead">Home
    <span style="font-size: 20px;color: #FFC0CB" class=" glyphicon glyphicon-home "></span>
  </h2>
  <br>
  <div class="container-fluid">
    <?php
      require 'dbh.php';
      $sql = "SELECT items.name 'itemname',items.collection 'collectionid' , items.status 'status', collections.name 'collectionName' FROM collections LEFT JOIN items on collections.id = items.collection ORDER BY collections.id desc LIMIT 1";
      $result = mysqli_query($conn,$sql);

      while($row = mysqli_fetch_assoc($result)){
          $collectionName = $row['collectionName'];
          $collectionid = $row['collectionid'];
          echo "<h2>$collectionName</h2>";
    ?>
      <div class="row-fluid">
        <div class="col-md-2">
          <?php
            $sql_prog = "SELECT * FROM collections WHERE id='$collectionid'";
            $result_prog = mysqli_query($conn,$sql_prog);

            while($row_prog = mysqli_fetch_assoc($result_prog)) {
                $collection_latest = $row_prog['id'];
                $collection_latest_name = $row_prog['name'];

                $sql_items_all = "SELECT count(*) 'transactTotal' FROM transactions JOIN orders on transactions.transactid = orders.transactid
                WHERE collectionid = '$collection_latest'";
                $result_items_all = mysqli_query($conn,$sql_items_all);
                $row_items_all = mysqli_fetch_assoc($result_items_all);
                $itemNum = $row_items_all['transactTotal'];

                $sql_item_sold = "SELECT count(*) 'transactPaid' FROM transactions JOIN orders ON transactions.transactid = orders.transactid WHERE collectionid='$collection_latest' and transactions.status = 'paid'";

                $result_item_sold = mysqli_query($conn,$sql_item_sold);
                $row_item_sold= mysqli_fetch_assoc($result_item_sold);
                $itemPaid = $row_item_sold['transactPaid'];

                $sql_item_unpaid = "SELECT count(*) 'transactPaid' FROM transactions JOIN orders ON transactions.transactid = orders.transactid WHERE collectionid='$collection_latest' and transactions.status = 'unpaid'";

                $result_item_unpaid = mysqli_query($conn,$sql_item_unpaid);
                $row_item_unpaid = mysqli_fetch_assoc($result_item_unpaid);
                $itemUnpaid = $row_item_unpaid['transactPaid'];

                if ($itemNum == 0) {
                  $progress_latest_collection_unpaid = 0;
                  $progress_latest_collection = 0;
                  $progress_latest_collection_percent_unpaid = (int) $progress_latest_collection_unpaid;
                  $progress_latest_collection_percent = (int) $progress_latest_collection;
                } else {
                  $progress_latest_collection_unpaid = ($itemUnpaid/$itemNum)*100;
                  $progress_latest_collection = ($itemPaid/$itemNum)*100;
                  $progress_latest_collection_percent_unpaid = (int) $progress_latest_collection_unpaid;
                  $progress_latest_collection_percent = (int) $progress_latest_collection;
                }

                echo <<<FRAG
                <div class="progress_nav">

                <div>
                    <p>
                        <strong class="progress_head">Paid</strong>
                        <span class="pull-right text-muted"> $progress_latest_collection_percent%</span>
                    </p>
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar" role="progressbar" aria-valuenow=" $progress_latest_collection" aria-valuemin="0" aria-valuemax="100" style="width: $progress_latest_collection%">
                            <span class="sr-only">$progress_latest_collection Sold</span>
                        </div>
                    </div>
                </div>
                </div>
                <div class="progress_nav">
                    <div>
                        <p>
                            <strong class="progress_head">Unpaid</strong>
                            <span class="pull-right text-muted"> $progress_latest_collection_percent_unpaid%</span>
                        </p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar" role="progressbar" aria-valuenow=" $progress_latest_collection_percent_unpaid" aria-valuemin="0" aria-valuemax="100" style="width: $progress_latest_collection_percent_unpaid%">
                                <span class="sr-only">$progress_latest_collection Sold</span>
                            </div>
                        </div>
                    </div>
                </div>
FRAG;
        }
        ?>
        </div>
        <div class="col-md-10">
          <div class="container">
            <div id="container_chart" style="max-width: 600px; margin: 0 auto"></div>
              <?php
                $sql_per = "SELECT count(*) 'totalitems' FROM items WHERE collection = '$collectionid'";
                $result_per = mysqli_query($conn,$sql_per);
                $row_per = mysqli_fetch_assoc($result_per);

                $totalItems = $row_per['totalitems'];

                $sql_avail = "SELECT count(*) 'availitems' FROM items WHERE collection = '$collectionid' and status='available'";
                $result_avail = mysqli_query($conn,$sql_avail);
                $row_avail = mysqli_fetch_assoc($result_avail);

                $sql_res = "SELECT count(*) 'resitems' FROM items WHERE collection = '$collectionid' and status='reserved'";
                $result_res = mysqli_query($conn,$sql_res);
                $row_res = mysqli_fetch_assoc($result_res);

                $sql_sold = "SELECT count(*) 'solditems' FROM items WHERE collection = '$collectionid' and status='sold'";
                $result_sold = mysqli_query($conn,$sql_sold);
                $row_sold = mysqli_fetch_assoc($result_sold);

                if ($totalItems == 0){
                  $availItems = 0;
                  $resItems = 0;
                  $soldItems = 0;
                } else {
                  $availItems = ($row_avail['availitems']/$totalItems) *100;
                  $resItems = ($row_res['resitems']/$totalItems) *100;
                  $soldItems = ($row_sold['solditems']/$totalItems) *100;
                }

                echo <<<FRAG
            <script>
                $(document).ready(function() {

                    // Build the chart
                    Highcharts.chart('container_chart', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: '$collectionName Items'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: true
                            }
                        },
                        credits: {
                            enabled: false
                        },
                        series: [{
                            name: 'Status',
                            colorByPoint: true,
                            data: [{
                                name: 'Available',
                                y: $availItems,
                                color: '#FFC0CB'
                            }, {
                                name: 'Reserved',
                                y: $resItems,
                                sliced: true,
                                selected: true,
                                color: '#FFD491'
                            }, {
                                name: 'Sold',
                                y: $soldItems,
                                color: '#735D78'
                            }]
                        }]
                    });
                });

                 Highcharts.setOptions({
                    chart: {
                        style: {
                            fontFamily: 'Quicksand'
                        }
                    }
                   });

            </script>
FRAG;
            ?>
            </div>
        </div>
      </div>
  </div>
</div>

<?php require_once 'includes/footer.inc.php' ?>
