<?php require_once 'includes/header.inc.php' ?>
  <div class="container">
    <h2>Orders</h2>
    <a href="#" class="btn btn-default" data-toggle="modal" data-target="#addOrder"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Order</a>
    <div class="container">
    <br>
    <table id="orderTable" class="table table-striped table-bordered dt-responsive" width="100%">
      <thead>
          <th>Item</th>
          <th>Collection</th>
          <th>Price</th>
          <th></th>
      </thead>
      <?php
        require 'dbh.php';
        $transactid = $_GET['transactid'];

        $sql = "SELECT orders.transactid, orders.orderid,items.name 'item', collections.name 'collection', orders.price, items.id 'itemid', collections.id 'collectionid' FROM orders JOIN items on items.id = orders.item JOIN collections on collections.id = items.collection WHERE orders.transactid = '$transactid'";
        $result = mysqli_query($conn, $sql);
        while ($row =mysqli_fetch_assoc($result)){
          $orderid = $row['orderid'];
          $item = $row['item'];
          $collection = $row['collection'];
          $collectionid = $row['collectionid'];
          $price = number_format($row['price']);
          $itemid = $row['itemid'];

          echo <<<FRAG
            <tr>
              <td>$item</td>
              <td>$collection</td>
              <td>$price</td>
              <td>
              <a href="editorder.php?itemid=$itemid&itemname=$item&collectionid=$collectionid&collection=$collection&transactid=$transactid&orderid=$orderid" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a>
              <a href="includes/deleteorder.inc.php?transactid=$transactid&orderid=$orderid&item=$itemid" class="btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="true" style="color: #e74c3c"></span></a></td>
            </tr>
FRAG;
          }
      ?>
    </table>
  </div>
</div>

<div id="addOrder" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Add Order</h4>
      </div>
      <div class="modal-body">
        <form id="addOrderForm" action="includes/addorder.inc.php" method="POST">
          <input type="hidden" name="transactid" value="<?php echo $transactid;?>">
          <div class="form-group">
            <label for="collectionid">Collection</label>
            <select name="collectionid" id="collectionselect" class="form-control">
              <option select="selected">Select Collection</option>
              <?php
                require 'dbh.php';

                $sql_collect = "SELECT id,name FROM collections";
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

                $sql = "SELECT id,name, collection FROM items where status='available'";
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
    $(document).ready(function() {
        $('#orderTable').DataTable();
        var allOptions = $('#itemselect option')
        $('#collectionselect').change(function() {
            $('#itemselect option').remove();
            var classN = $('#collectionselect option:selected').prop('class');
            var opts = allOptions.filter('.' + classN);
            $.each(opts, function(i, j) {
                $(j).appendTo('#itemselect');
            });
        });

    });
</script>

<?php require_once 'includes/footer.inc.php' ?>
