<?php
$mysql_db_hostname = "localhost";
$mysql_db_user = "uploaduser";
$mysql_db_password = "your_password";
$mysql_db_database = "testupload";

$dbc = mysqli_connect('' . $mysql_db_hostname . '', '' . $mysql_db_user . '', '' . $mysql_db_password . '', '' . $mysql_db_database .  '') OR die('Could not connect because: '.mysqli_connect_error());


if (isset($_POST['add_account'])) { 

	
    	if($_POST['fields']) {
			foreach($_POST['fields'] as $key=>$fieldArray ) {														
			
			$keys = array_keys($fieldArray);				
			
			if (!empty($_FILES)) {				
			
				if($_FILES['fields']['name'][$key]['file_uploaded'][0] != ''){				
					// Get e-mail used for registration 	
					if($_POST['fields'][$key]['email'] !=''){  	
									
						//Set the upload directory	
						$uploaddir = 'uploads/'; 
						//Get time to use in file name
						$newname = time(); 
						//Generate random number to add in file name
						$rand = rand(100,999);
						//Construct the name using the above values + original file name						
						$name = $newname.'-'.$rand.'-'.$_FILES['fields']['name'][$key]['file_uploaded'][0]; 
						//Get the temporary file name
						$tempFile = $_FILES['fields']['tmp_name'][$key]['file_uploaded'][0]; 
						//Set the path and file name as it will be saved in the db
						$uploadfile = $uploaddir.$name;								
						
						//If the file was NOT moved from /tmp/ to our upload directory
						if (move_uploaded_file($tempFile, $uploadfile)) {   															
														
							//Get the email value in $_POST						
							$email = $_POST['fields'][$key]['email'];
							$first = $_POST['fields'][$key]['first'];
							$last =  $_POST['fields'][$key]['last'];
							
							//Construct the query to insert the data
							$q = "INSERT INTO accounts (first, last, email,  uploaded_file) VALUES ('".$first."','".$last."','".$email."', '".$uploadfile."')";		
							$r = mysqli_query($dbc, $q);																
						
							//If the query is successfull 						
							if($r){ 			
								
								echo 'Name: '.$first.' '.$last.' <br />Email:'. $email.' <br /><img src="'. $uploadfile.'" style="max-width:120px; height: auto;"><br /><div style="color: green;"><strong>Success</strong></div>'; 
								
								//Else if the query is not successfull, check if there is already a record with same data
								
							} else {																					
							
								echo '<div class="alert alert-danger">The request failed! Please try again later or open a ticket';

								
							}
							
						} else {  //If the file was not attached to the request  -- check can be skipped, as the field is required anyway
						
							echo '<br />
									<div class="alert alert-danger" role="alert">
									The data could not be saved to DB.													
									</div>';
						}			
					} // end if $_FILES
				} // end for each loop
			}
       
		}
	}
	
	  echo '<hr /><div style="width: 100%;"><i><h2><strong>' . count($_POST['fields']) . '</strong> Account(s) Added</h2></i> ';
	  echo '<p><a href="javascript:history.back();" class="btn btn-default">Go Back</a></p></div>'; 
	  
	
}

if (!isset($_POST['add_account'])) {
	
// The form 	?> 
<form method="post" action="" enctype="multipart/form-data">
<?php // adding a button to add new rows ?>
<p id="add_field"><a class="btn btn-default" href="#">Add Rows</a></p>

<?php //building our form as a table. Also, adding a 1st line in the form. ?>
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
	<tr>
		<td>1</td>
		<td><div class="form-group"><input class="form-control" name="fields[1][first]" 	type="text"  	placeholder="First" required/></div></td>
		<td><div class="form-group"><input class="form-control" name="fields[1][last]" 		type="text"  	placeholder="Last" required/></div>	</td>
		<td><div class="form-group"><input class="form-control" name="fields[1][email]" 	type="email"  	placeholder="email" required/></div></td>
		<td><input class="btn btn-primary" id="userfiles" name="fields[1][file_uploaded][]" type="file"  	required = "required"/>				</td>
		<td><input class="btn btn-danger" type="button" value="Remove" onclick="delRow(this)">													</td>
	</tr>							
</tbody>
</table>

<input class="btn btn-success" type="submit" name="add_account"  value="Submit Form"  />
</form>
<?php } ?>
	
<?php //jQuery (necessary for Bootstrap's JavaScript plugins) ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<script type="text/javascript">

// function to build our form rows every time we click on the "Add row" button
$(function(){
	var counter = 1;
	$('p#add_field').click(function(){
		counter += 1;
		$('#container').append(
		'<tr> \
		<td>' + counter + '</td> \
		<td><div class="form-group"><input class="form-control" name="fields['+counter+'][first]" 		type="text"  	placeholder="First" required/></div></td> \
		<td><div class="form-group"><input class="form-control" name="fields['+counter+'][last]" 		type="text"  	placeholder="Last" required/></div>	</td> \
		<td><div class="form-group"><input class="form-control" name="fields['+counter+'][email]" 		type="email"  	placeholder="email" required/></div></td> \
		<td><input class="btn btn-primary" id="userfiles" name="fields['+counter+'][file_uploaded][]" 	type="file"  	required = "required"/>				</td> \
		<td><input class="btn btn-danger" type="button" value="Remove" onclick="delRow(this)">																</td> \
		</tr>');

	});
});

// function to remove selected row
function delRow(currElement) {
	 var parentRowIndex = currElement.parentNode.parentNode.rowIndex;
	 document.getElementById("myTable").deleteRow(parentRowIndex);
}
</script>
