<?php
    require_once 'includes/header.inc.php';
    require_once 'dbh.php';
?>
      <script>
        $(document).ready(function() {
            $('#collectionTable').dataTable({
                "lengthChange": false,
                "ordering": true,
                "info": false,
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [-1]
                }]
            });
        });

    </script>
    <div class="container">
       <h2 class="pagehead">Collections <span style="font-size: 20px;color: #FFC0CB" class=" glyphicon glyphicon-th "></span> </h2>
        <a href="#" class="btn btn-default" data-toggle="modal" data-target="#addCollection"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Collection</a>

        <div class="container">
            <br>
            <table id="collectionTable" class="table table-striped table-bordered dt-responsive">
                <thead>
                    <th>Collection</th>
                    <th>Capital</th>
                    <th></th>
                </thead>
                <?php
                $sql = "SELECT id, name, capital FROM collections WHERE name != 'Clearance Sale' order by id";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)){
                    $id = $row['id'];
                    $name = $row['name'];
                    $capital = number_format($row['capital']);
                    
                    echo <<<FRAG
                    <tr>
                        <td class="collectionNametd"><a href='collection.php?name=$name'>$name</a></td>
                        <td>&#x20B1; $capital</td>
                        <td class="no-sort">
                        <a href="editcollection.php?collectionid=$id&collection=$name&capital=$capital" class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                        
                        <a href="#" id="removeCollectionButton" class="btn btn-default"  data-toggle="modal" data-target="#remove$id"><span class="glyphicon glyphicon-trash" aria-hidden="true" style="color: #e74c3c;"></span></a>
                        
                            <!-- Delete Collection Modal -->
                        <div id="remove$id" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Remove $name</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="includes/deletecollection.inc.php" method="POST">
                                            <p>Are you sure you want to delete this collection? </p>
                                            <input type="hidden" name="collectionid" value="$id">
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

    <!-- Modal -->
    <div id="addCollection" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Collection</h4>
                </div>
                <div class="modal-body">
                    <form id="addCollectionForm" method="POST" action="includes/addcollection.inc.php">
                        <div class="form-group">
                            <label for="name">Collection Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="collectionCapital">Capital</label>
                            <input type="number" step="0.01" class="form-control" name="collectionCapital">
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


 

    <?php
    require_once 'includes/footer.inc.php';
?>
