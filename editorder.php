<?php
    require_once 'includes/header.inc.php';
    require_once 'dbh.php';
    $collectionName= $_GET['collection'];
    $itemname = $_GET['itemname'];
    $itemid = $_GET['itemid'];
    $transactid = $_GET['transactid'];
    $orderid = $_GET['orderid'];

    $sql = "SELECT customer,price FROM transactions JOIN orders on transactions.transactid = orders.transactid WHERE orders.transactid = '$transactid'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $customer = $row['customer'];
    $price = $row['price'];
?>
   
    <div class="container">
        <h3> Add Discount or Shipping Fee</h3>
        <div class="container">
           <table class="table table-bordered table-striped">
               <thead>
                   <th>Customer</th>
                   <th>Item</th>
                   <th>Collection</th>
                   <th>Price</th>
               </thead>
               <tr>
                   <?php
                        echo <<<FRAG
                            <td>$customer</td>
                            <td>$itemname</td>
                            <td>$collectionName</td>
                            <td>$price</td>
FRAG;
                   ?>
               </tr>
           </table>
            <form action="includes/editorder.inc.php" class="form-inline" method="POST">
                <div class="form-group">
                    <label for="discount" class="col-sm-3 col-form-label">Discount</label>
                    <div class="col-sm-9">
                        <input type="number" name="discount" class="form-control">
                    </div>
                </div>
                <br>
                <input type="hidden" value="<?php echo $orderid?>" name="orderid">
                <input type="hidden" value="<?php echo $transactid?>" name="transactid">
                <div class="form-group">
                    <label for="shipping" class="col-sm-3 col-form-label"> Shipping </label>
                    <div class="col-sm-9">
                        <input type="number" name="shipping" class="form-control">
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-default form-control">Update</button>
            </form>

        </div>
    </div>

    </div>

    <?php
    require_once 'includes/footer.inc.php';
?>
