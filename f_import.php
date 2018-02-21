<?php
include 'mod/header.php';
session_start();
extract($_POST);


if(isset($btnSubmit)){
    $result = "";
   
    
    //Output result message
    if ($error == false) {
        $result='<div class="alert alert-success" style="text-align: center;"><strong>Import Successful!</strong></div>';
    }else {
        $result='<div class="alert alert-danger">Sorry there was an error importing your file. Please check file and try again.</div>';
    }
}

?>
<form id="form_import" method="post" action="f_import.php" enctype="multipart/form-data">
    <div class="offset-sm-2 col-sm-6">
       <h1 class="pb-5">Import a Semester CSV</h1>
    </div>
    <div class="form-group">
        <div class="offset-sm-4 col-sm-6 pb-4">
            <input type="file"> 
        </div>
        <div class="offset-sm-6 col sm-4 pb-2">
            <input type="submit" name="btnSubmit" text="Import"></input>
        </div>
    </div>
    <div class="form-group">
        <div class="offset-sm-3 col-sm-6">
        <?php echo $result; ?> 
        </div>
    </div>
</form>

<?php include_once 'mod/footer.php' ?>