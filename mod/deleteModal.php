<?php
// !!!!!!!!! CURRENTLY NOT USED, LEFT IT IN AS AN EXAMPLE, USED TO TRIGGER RECORD SPECIFIC DELETION !!!!!!!!!!!!




/*---------------------------------------------------------------------------------------------------/
           NAME: deleteModal.php
    DESCRIPTION: Delete confirmation modal with specific onclick action depending on where its used
                 Originally was with the header.php file. Though as it needs to be within a form,
                 it gets included under the form tag of each view.
 ----------------------------------------------------------------------------------------------------*/


// ************************** DELETE MODAL ************************** ?>
            <div id="modalDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header-conf">
                            <a href="#" data-dismiss="modal" class="close" aria-hidden="true"><i class="fa fa-times-circle"></i></a>
                        </div>
                        <div class="row modal-body-conf">
                            <div class="col-sm-2">
                                <i id="warningIcon" class="fa fa-exclamation-triangle fa-3x"></i>
                            </div>
                            <div class="logoutText col-sm-9">
                                <p>Are you sure you want to delete the selected item/s?</p>
                            </div>
                        </div>
                        <div class="modal-footer-conf">
                            <button type="button" class="btn btn-default btnLogoutConf" data-dismiss="modal">No</button>
                            <?php

                            if ($_SERVER['REQUEST_URI'] == '/eCoordinator/v_users.php') {
                                $submitEdit = 'this.form.action = "/eCoordinator/a_delete.php?delete=user"';
                            }
                            echo "<button value='btndelYes' name='btndelYes' id='btndelYes' class='btn btn-danger btnLogoutConf' onclick='".$submitEdit."'>Yes</button>";
                            ?>

                        </div>
                    </div>
                </div>
            </div>
