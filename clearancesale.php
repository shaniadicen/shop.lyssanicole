<?php
    require_once 'includes/header.inc.php';
    
?>

    <div class="container">
        <h2 class="pagehead">Clearance Sale <span style="font-size: 20px;color: #FFC0CB" class=" glyphicon glyphicon-flash "></span> </h2>
        <a href="#collectionDetails" data-toggle="collapse" class="btn btn-default btn-circle">
            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
        </a>
        <a href="#" class="btn btn-default " data-toggle="modal" data-target="#addOrder"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Item</a>

        <div id="collectionDetails" class="collapse">
            <br>
            <table class="table table-bordered" style="width:40%;">
                <thead>
                    <th>Revenue</th>
                </thead>
                <tr>
                    <td><b>&#x20B1;
                        <?php
                        require 'dbh.php';
                                $sql_gross = "SELECT sum(DISTINCT transactions.amount) 'gross_sales' FROM transactions join orders on transactions.transactid = orders.transactid WHERE orders.collectionid='31' and transactions.status='paid'";
                                $result_gross = mysqli_query($conn, $sql_gross);
                                $row_gross = mysqli_fetch_assoc($result_gross);
                                $sales = $row_gross['gross_sales'];
                            
                                echo $sales;
                            ?></b>

                    </td>
                </tr>
            </table>
        </div>
        <div class="container">
            <br>
            <table id="orderTable" class="table table-bordered dt-responsive" width="100%">
                <thead>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th></th>
                </thead>
                <?php
                    
            
                    $sql = "SELECT items.id 'itemid', collections.id 'collectionid', collections.name 'collectionName', items.name 'itemName', price, status FROM items JOIN collections on items.collection = collections.id where collection='31'";
                    $result = mysqli_query($conn, $sql);
                    while ($row =mysqli_fetch_assoc($result)){
                        $itemid = $row['itemid'];
                        $collectionid = $row['collectionid'];
                        $itemName = $row['itemName'];
                        $collectionName = $row['collectionName'];
                        $price = number_format($row['price']);
                        $status = ucfirst($row['status']);
                        
                        if($status == 'Available'){
                            echo "<tr style='background-color: #FFC0CB;'>";
                        }else if ($status == 'Reserved'){
                            echo "<tr style='background-color: #FFD491;'>";
                        }else{
                            echo "<tr style='background-color: #735D78;color: #fff'>";
                        }
                                echo <<<FRAG
                                <td>$itemName</td>
                                <td>&#x20B1; $price</td>
                                <td>$status</td>
                                <td>
                                <a href="edititem.php?itemid=$itemid&itemname=$itemName&collectionid=$collection_id&collection=$collectionName" class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                
                                <a href="#" id="removeCollectionButton" class="btn btn-default"  data-toggle="modal" data-target="#remove$itemid"><span class="glyphicon glyphicon-trash" aria-hidden="true" style="color: #e74c3c;"></span></a>
                        
                                    <!-- Delete Item Modal -->
                                <div id="remove$itemid" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Remove $itemName</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="includes/removeItem.inc.php" method="GET">
                                                    <p>Are you sure you want to delete this collection? </p>
                                                    <input type="hidden" name="itemid" value="$itemid">
                                                    <input type="hidden" name="collection" value="$collectionName">
                                                    <button type="submit">Delete</button>
                                                </form>
                                        </div>

                                    </div>
                                </div>
                            </tr>
FRAG;
                    }
                
                
                
                ?>
            </table>

        </div>

    </div>



    <!-- Modal -->
    <div id="addOrder" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> Add Order</h4>
                </div>
                <div class="modal-body">
                    <form id="addOrderForm" action="includes/addclearancesale.inc.php" method="POST">
                        <input type="hidden" name="transactid" value="<?php echo $transactid;?>">
                        <div class="form-group">
                            <label for="collectionid">Collection</label>
                            <select name="collectionid" id="collectionselect" class="form-control">
                                   <option select="selected">Select Collection</option>
                                <?php 
                                require 'dbh.php';
                                    $sql_collect = "SELECT id,name FROM collections WHERE not(name='Clearance Sale')";
                                    $result_collect = mysqli_query($conn, $sql_collect);
                                
                                    while($row_collect = mysqli_fetch_assoc($result_collect)){
                                        $collectionName = $row_collect['name'];
                                        $collectionid = $row_collect['id'];
                                        echo <<<FRAG
                                        <option class="$collectionid" value="$collectionid" name="collectionid">$collectionName</option>
                                        
FRAG;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group cont">
                            <label for="itemid">Item</label>
                            <select name="itemid" id="itemselect" class="form-control ">
                                <option select="selected">Select Item</option>

                            <?php 
                                require 'dbh.php';
                                    $sql = "SELECT id,name, collection FROM items where status='available' and not(collection = 31)";
                                    $result = mysqli_query($conn, $sql);
                                
                                    while($row= mysqli_fetch_assoc($result)){
                                        $itemname = $row['name'];
                                        $itemid = $row['id'];
                                        $collectionid = $row['collection'];
                                        echo <<<FRAG
                                        <option value="$itemid" name="collectionid" class="$collectionid">$itemname</option>
FRAG;
                                    }
                                ?>
                                </select>
                        </div>
                        <button type="submit" class="btn btn-default">Add</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#orderTable').DataTable({
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [3]
                }]
            });
            var allOptions = $('#itemselect option')
            $('#collectionselect').change(function () {
                $('#itemselect option').remove(); //remove all options
                var classN = $('#collectionselect option:selected').prop('class'); //get the 
                var opts = allOptions.filter('.' + classN); //selected option's classname
                $.each(opts, function (i, j) {
                    $(j).appendTo('#itemselect'); //append those options back
                });
            });

        });
    </script>
    <?php
    require_once 'includes/footer.inc.php';
?>