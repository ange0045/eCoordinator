<?php

// !!!!!!!!! CURRENTLY NOT USED, WE MAY NEED TO LATER !!!!!!!!!!!!



/*---------------------------------------------------------------------------------------------------/
           NAME: search.php
    DESCRIPTION: Included in table views, to reduce having to recreate code in each view.
 ----------------------------------------------------------------------------------------------------*/
extract($_POST);
$valVal = "";

    // ---- Search value field
if(isset($btnSearch)){
    $valVal = trim($inv_SearchVal);
    $_SESSION['ses_searchVal'] = $valVal;
}
?>

<div class="navbar-form navbar-left" role="search">
    <div class="input-group">
        <input id="inv_SearchVal" name="inv_SearchVal" type="search" class="form-control" placeholder="Search" value="<?php echo $valVal;?>"/>
        <span class="input-group-btn">
            <button type="submit" id="btnSearch" value="btnSearch" name="btnSearch" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
        </span>
    </div>
    <button type="submit" id="btnFilter" value="btnFilter" name="btnFilter" title="Filter: Currently in testing." class="btn btn-default" data-toggle="modal" data-target="#view-modal"><i class="fa fa-search-plus fa-lg" aria-hidden="true"></i></button>
</div>
