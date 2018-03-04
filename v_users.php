<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: v_users.php
    DESCRIPTION: Shows all users
 ----------------------------------------------------------------------------------------------------*/

include 'mod/header.php';
 ?>
    <form id="formTableUsers" method="post">
<?php
include_once 'mod/deleteModal.php'; // -- Modal for delete confirmation
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH); // -- Creates a connection to the database

?>
  <div class="row col-sm-offset-1 col-sm-12">
        <div class='col-sm-3 btnsAdmin'>
            <button value='Delete' name='btnDelete' data-toggle='modal' data-target='#modalDelete' data-id='Delete' id='btnDelete' class='btn btn-warning label label-primary btnAction'>Delete Selected</button>
        </div>

        <div class='col-sm-9'>

            <table class='table table-striped table-hover'>
                <thead class='thead'>
                    <tr>
                        <th class="centerLabel xsCell"></th>
                        <th class="centerLabel smCell">ID</th>
                        <th class="centerLabel lgCell">Username</th>
                        <th class="centerLabel lgCell">Name</th>
                    </tr>
                </thead>
                <tbody>

<?php
$users = $dao->getUsers();

if (isset($users))
{
    foreach ($users as $item)
    {
        echo "<tr>";
            echo "<td align='middle' class='xsCell' ><input type='checkbox' name='chk_UsrSel[]' id='chk_UsrSel' value='".$item->getUserId()."'></td>";
            echo "<td align='middle' class='smCell' >".$item->getUserId()."</td>";
            echo "<td align='middle' class='lgCell' >".$item->getUsername()."</td>";
            echo "<td align='middle' class='lgCell' >".$item->getFullName()."</td>";
        echo "</tr>";
    }
}
?>
                </tbody>
            </table><!-- /.main table -->
        </div><!-- /.tableDiv -->
    </form><!-- /.formTable -->
</div><!-- /.contentMain -->

<?php include "mod/footer.php";
