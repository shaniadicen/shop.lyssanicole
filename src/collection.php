<?php
    require_once 'includes/header.inc.php';
    

    $collectionName= $_GET['name'];
?>

    <div class="container">
        <h3>
            <?php
                require_once 'dbh.php';
                
                $sql_pk = "SELECT * from collections where name='$collectionName'";
                $result_pk = mysqli_query($conn, $sql_pk);
                $row_pk=mysqli_fetch_assoc($result_pk);
                $collection_id = $row_pk['id'];
                $collection_capital = $row_pk['capital'];
            
                echo $row_pk['name'];
            ?>

        </h3>
        <a href="#collectionDetails" data-toggle="collapse" class="btn btn-default btn-circle">
            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
        </a>
        <a href="#" class="btn btn-default" data-toggle="modal" data-target="#addCollectionItem"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Item</a>

        <div>
            <br>
            <div id="collectionDetails" class="collapse">
                <table class="table table-striped table-bordered dt-responsive">
                    <thead>
                        <th>Gross Sales</th>
                        <th>Capital</th>
                        <th>Revenue</th>
                    </thead>
                    <tr>
                        <td>&#x20B1;
                            <?php
                                $sql_gross = "SELECT DISTINCT transactions.transactid, transactions.amount 'gross_sales' FROM transactions join orders on transactions.transactid = orders.transactid WHERE orders.collectionid='$collection_id' and transactions.status='paid'";
                                $result_gross = mysqli_query($conn, $sql_gross);
                                $totalGross = 0;
                                while($row_gross = mysqli_fetch_assoc($result_gross)){
                                    $totalGross += $row_gross['gross_sales'];
                                }
                                echo number_format($totalGross);
                            ?>

                        </td>
                        <td> &#x20B1;
                            <?php echo number_format($collection_capital)?>
                        </td>
                        <td><b>&#x20B1;
                            <?php 
                                if (($totalGross - $collection_capital) < 0){
                                    echo "0";
                                }else{
                                    echo number_format($totalGross-$collection_capital);
                                }
                            ?>
                            </b>
                        </td>
                    </tr>
                </table>
            </div>
            <table id="collectionItemTable" class="table table-bordered dt-responsive table-responsive" width="100%">
                <thead>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th></th>
                </thead>
                <?php
                    $sql_items = "SELECT * FROM items where collection='$collection_id'";
                    $result_items = mysqli_query($conn, $sql_items);
                
                    if (mysqli_num_rows($result_items) > 0){
                        while($row_items = mysqli_fetch_assoc($result_items)){
                            $itemid = $row_items['id'];
                            $itemName = $row_items['name'];
                            $itemStatus = ucfirst($row_items['status']);
                            $itemPrice = number_format($row_items['price']);
                            
                            if($itemStatus == 'Available'){
                                echo <<<FRAG
                            <tr style="background-color: #FFC0CB;">
                                <td>$itemName</td>
                                <td>&#x20B1; $itemPrice</td>
                                <td>$itemStatus</td>
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
                                </td>
                                
                            </tr>
FRAG;
                            }else if ($itemStatus == 'Reserved'){
                                echo <<<FRAG
                            <tr style="background-color: #FFD491">
                                <td>$itemName</td>
                                <td>&#x20B1; $itemPrice</td>
                                <td>$itemStatus</td>
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
                                
                                </td>
                                
                            </tr>
FRAG;
                            }else{
                                echo <<<FRAG
                            <tr style="background-color: #735D78;color: #fff">
                                <td>$itemName</td>
                                <td>&#x20B1; $itemPrice</td>
                                <td>$itemStatus</td>
                                <td>
                                <a href="edititem.php?itemid=$itemid&itemname=$itemName&collectionid=$collection_id&collection=$collectionName" class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                
                                <a href="#" id="removeCollectionButton" class="btn btn-default"  data-toggle="modal" data-target="#remove$itemid"><span class="glyphicon glyphicon-trash" aria-hidden="true" style="color: #e74c3c;"></span></a>
                        
                                    <!-- Delete Item Modal -->
                                <div id="remove$itemid" class="modal fade" role="dialog" style="color: #000">
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
                                </td>
                                
                            </tr>
FRAG;
                            }
                            
                        }
                    }
                    
                
                ?>


            </table>
        </div>

    </div>


    <!-- Modal -->
    <div id="addCollectionItem" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <?php echo $collectionName?>: Add New Item</h4>
                </div>
                <div class="modal-body">
                    <form id="addItemForm" action="includes/additem.inc.php" method="POST">
                        <div class="form-group">
                            <label for="itemName">Item Name</label>
                            <input type="text" class="form-control" name="itemName">
                        </div>
                        <input type="hidden" value="<?php echo $collection_id?>" name="collection">
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price">
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
        $(document).ready(function() {
            $('#collectionItemTable').DataTable({
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [3]
                }]
            });
        });

    </script>
    <?php
    require_once 'includes/footer.inc.php';
?>
