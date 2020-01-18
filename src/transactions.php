<?php require_once 'includes/header.inc.php' ?>

<div class="container">
  <h2 class="pagehead">Transactions
    <span style="font-size: 20px;color: #FFC0CB" class=" glyphicon glyphicon-transfer "></span>
  </h2>
  <a href="#" class="btn btn-default" data-toggle="modal" data-target="#addTransaction"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    Add Transaction
  </a>

  <div class="container">
    <br>
    <table id="transacttable" class="table table-bordered dt-responsive " width="100%">
      <thead>
          <th>Customer</th>
          <th>Amount</th>
          <th>Status</th>
          <th></th>
      </thead>
        <?php
          require 'dbh.php';
          $sql = "SELECT * FROM transactions ORDER BY status desc";
          $result = mysqli_query($conn, $sql);
          while ($row =mysqli_fetch_assoc($result)){
            $transactid = $row['transactid'];
            $customer = $row['customer'];
            $amount = $row['amount'];
            $status = ucfirst($row['status']);

            if ($status == 'Paid'){
              echo <<<FRAG
              <tr style="background-color: #FFC0CB">
FRAG;
            } else {
              echo "<tr>";
            }

              echo <<<FRAG
              <td>$customer</td>
              <td>&#x20B1; $amount</td>
              <td>$status</td>
              <td>
                <a href="orders.php?transactid=$transactid" class="btn btn-default"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>

FRAG;
              if ($status == 'Unpaid'){
                echo <<<FRAG

                    <a href="includes/unpaid.inc.php?transactid=$transactid" class="btn btn-default"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></a>
FRAG;
            }
            echo <<<FRAG
                    <a href="#" id="removeCollectionButton" class="btn btn-default"  data-toggle="modal" data-target="#remove$transactid"><span class="glyphicon glyphicon-trash" aria-hidden="true" style="color: #e74c3c;"></span></a>

                    <div id="remove$transactid" class="modal fade" role="dialog" style="color: #000">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Remove Transaction</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="includes/deletetransact.inc.php" method="GET">
                                        <p>Are you sure you want to delete this transaction? </p>
                                        <input type="hidden" name="transactid" value="$transactid">
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
        ?>
      </table>
  </div>
</div>

<div id="addTransaction" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Add Transaction</h4>
      </div>
      <div class="modal-body">
        <form id="addTransactionForm" action="includes/addtransaction.inc.php" method="POST">
          <div class="form-group">
              <label for="price">Customer</label>
              <input type="text" class="form-control" name="customer">
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
    $('#transacttable').DataTable({
        responsive: true,
        order: [[3, 'desc']],
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [3]
        }]
    });
  });
</script>

<?php require_once 'includes/footer.inc.php' ?>
