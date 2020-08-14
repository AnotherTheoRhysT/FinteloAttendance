<!DOCTYPE HTML>
<html>
<head>
    <title>Create a Student</title>
      
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
          
</head>
<body>
  
    <!-- container -->
    <div class="container">
   
        <div class="page-header">
            <h1>Create Student</h1>
        </div>
      
    <!-- PHP insert code will be here -->
    <?php
        if($_POST){
        
            // include database connection
            include 'config/config.php';
        
            try{
            
                // insert query
                $query = "INSERT INTO students SET first_name=:first_name, middle_name=:middle_name, last_name=:last_name, sex=:sex, group_number=:group_number";
        
                // prepare query for execution
                $stmt = $con->prepare($query);
        
                // posted values
                $first_name=htmlspecialchars(strip_tags($_POST['first_name']));
                $middle_name=htmlspecialchars(strip_tags($_POST['middle_name']));
                $last_name=htmlspecialchars(strip_tags($_POST['last_name']));
                $sex=htmlspecialchars(strip_tags($_POST['sex']));
                $group_number=htmlspecialchars(strip_tags($_POST['group_number']));
        
                // bind the parameters
                $stmt->bindParam(':first_name', $first_name);
                $stmt->bindParam(':middle_name', $middle_name);
                $stmt->bindParam(':last_name', $last_name);
                $stmt->bindParam(':sex', $sex);
                $stmt->bindParam(':group_number', $group_number);
                
                // Execute the query
                if($stmt->execute()){
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                }else{
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
                
            }
            
            // show error
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }

        
    ?>
 
<!-- html form here where the product information will be entered -->
    <form action="" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td> First Name</td>
                <td><input type='text' name='first_name' class='form-control' /></td>
            </tr>
            <tr>
                <td> Middle Name</td>
                <td><input type='text' name='middle_name' class='form-control' /></td>
            </tr>
            <tr>
                <td> Last Name</td>
                <td><input type='text' name='last_name' class='form-control' /></td>
            </tr>
            <tr>
                <td>Sex</td>
                <td > <input class="form-check-input" type="radio" name="sex" id="sex" value="M" checked>
                    <label class="form-check-label" for="gridRadios1">M </label> 
                    <input class="form-check-input" type="radio" name="sex" id="sex" value="F">
                    <label class="form-check-label" for="gridRadios2"> F </label> </td>
                <!-- <td><textarea name='sex' class='form-control'></textarea></td> -->
            </tr>
            <tr>
                <td>Group Number</td>
                <td > <input class="form-check-input" type="radio" name="group_number" id="group_number" value="1" checked>
                    <label class="form-check-label" for="gridRadios1">1</label> 
                    <input class="form-check-input" type="radio" name="group_number" id="group_number" value="2">
                    <label class="form-check-label" for="gridRadios2"> 2 </label> </td>
                <!-- <td><input type='text' name='group_number' class='form-control' /></td> -->
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='index.php' class='btn btn-danger'>Back to read students</a>
                </td>
            </tr>
        </table>
    </form>
          
    </div> <!-- end .container -->
      
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>