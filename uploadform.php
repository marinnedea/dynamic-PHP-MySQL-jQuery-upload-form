
<?php 
  
  if (!isset($_POST['add_account'])) { 

?> 

<form method="post" action="" enctype="multipart/form-data">

<p id="add_field"><a class="btn btn-default" href="#">Add Rows</a></p>
<table id="myTable">
<thead>
    <tr>
        <th>#</th>
        <th>First Name:</th>
        <th>Last Name:</th>
        <th>E-mail:</th>
        <th>Upload file</th>            
        <th></th>           
    </tr>
</thead>
<tbody id="container">
</tbody>
</table>

<input class="btn btn-default" type="submit" name="add_account"  value="Submit"  />
</form>


<?php } ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">

    $(function(){
        var counter = 0;
        $('p#add_field').click(function(){
            counter += 1;
            $('#container').append(
            '<tr><td>' + counter + '</td><td><input name="fields['+counter+'][first]" type="text"  placeholder="First Name" required/></td><td><input name="fields['+counter+'][last]" type="text"  placeholder="Last Name" required/></td><td><input name="fields['+counter+'][email]" type="email"  placeholder="email" required/></td><td><input id="userfile" name="fields['+counter+'][file_uploaded][]" type="file" /></td><td><input type="button" value="Remove" onclick="delRow(this)"></td></tr>');

        });
    });

    function delRow(currElement) {
         var parentRowIndex = currElement.parentNode.parentNode.rowIndex;
         document.getElementById("myTable").deleteRow(parentRowIndex);
    }

</script>
