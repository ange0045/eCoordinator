<?php
// !!!!!!!!! CURRENTLY NOT USED, LEFT IT IN CASE WE TAKE THE NAVBAR OFF FROM THE HEADER.PHP FILE AS AN EXAMPLE !!!!!!!!!!!!




/*---------------------------------------------------------------------------------------------------/
           NAME: navbar.php
    DESCRIPTION: Containts the navbar, logo, login info, search and user info
 ----------------------------------------------------------------------------------------------------*/
?>
                <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
                    <div class="container-fluid">
                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                     data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </button>
                            <a class="navbar-brand" style="padding: 1px" href="index.php">
                                <img src="Common/Contents/img/img_argyleLogo.jpg"
                                     alt="Argyle" style="max-width:100%; max-height:100%;"/>
                            </a>
                      </div>
                      <div class="collapse nav navbar-collapse multi-level" id="bs-example-navbar-collapse-1">
                          <ul class="nav navbar-nav">

                        <?php
                        if ($_SESSION['ses_Access'] != 'Reader'){
                            echo '<li class="dropdown">';
                                    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> + New <span class="caret"></span></a>';
                                    echo '<ul class="dropdown-menu">';
                                        echo '<li class="'.($_SERVER['PHP_SELF'] == '/form_appointments.php' ? ' active' : '').'"><a href="form_appointments.php">Appointments</a></li>';
                                        echo '<li class="'.($_SERVER['PHP_SELF'] == '/form_patient.php' ? ' active' : '').'"><a href="form_patient.php">Patients</a></li>';
                                echo '</ul></li>';
                        }
                          ?>


                          <!-- MY VIEWS -->
                          <?php
                          $dao = new DataAccessObject(INI_FILE_PATH);
                          $var_HomeOffice = $_SESSION['ses_HomeOffice'];
                          if (isset($var_HomeOffice) && $var_HomeOffice != '') {
                            echo '<li class="dropdown">';
                                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Views <span class="caret"></span></a>';
                                echo '<ul class="dropdown-menu multi-level">';
                                    echo '<li><a href="v_app_all_my.php">All My IMP Consults</a></li>';
                                    echo '<li><a href="v_app_my_todays.php">Todays IMP Consults</a></li>';
                                    echo '<li><a href="v_app_my_upcoming.php">All Upcoming Appointments</a></li>';
                                    echo '<li><a href="v_pat_my_patients.php">All My Patients</a></li>';

                                    echo '<li class="dropdown-submenu">';
                                      echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">By Month</a>';
                                        echo '<ul class="dropdown-menu">';
                                          $years = $dao->getTxPlansYears();
                                          if (isset($years))
                                          {
                                              foreach ($years as $year)
                                              {
                                                  echo '<li class="dropdown-submenu">';
                                                    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$year.'</a>';
                                                    echo '<ul class="dropdown-menu">';
                                                    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                    if (isset($months))
                                                    {
                                                        foreach ($months as $month)
                                                        {
                                                            echo '<li><a href="v_app_all_my_by_month.php?year='.$year.'&month='.$month.'">'.$month.'</a></li>';
                                                        }
                                                    }
                                                    echo '</ul></li>';
                                              }
                                          }
                                        echo '</ul>';
                                    echo '</li>';

                                    echo '<li class="dropdown-submenu">';
                                      echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tx Plans By Month</a>';
                                        echo '<ul class="dropdown-menu">';
                                          $years = $dao->getTxPlansYears();
                                          if (isset($years))
                                          {
                                              foreach ($years as $year)
                                              {
                                                  echo '<li class="dropdown-submenu">';
                                                    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$year.'</a>';
                                                    echo '<ul class="dropdown-menu">';
                                                    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                    if (isset($months))
                                                    {
                                                        foreach ($months as $month)
                                                        {
                                                            echo '<li><a href="v_app_my_treat_plan_by_month.php?year='.$year.'&month='.$month.'">'.$month.'</a></li>';
                                                        }
                                                    }
                                                    echo '</ul></li>';
                                              }
                                          }
                                        echo '</ul>';
                                    echo '</li>';

                                    echo '<li class="dropdown-submenu">';
                                      echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">By Booking Status</a>';
                                        echo '<ul class="dropdown-menu">';
                                        $status = $dao->getKeyword('Booking Status');
                                        if (isset($status))
                                        {
                                            foreach ($status as $item)
                                            {
                                                echo '<li class="dropdown-submenu">';
                                                  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$item.'</a>';
                                                  echo '<ul class="dropdown-menu">';
                                                  $years = $dao->getTxPlansYears();
                                                  if (isset($years))
                                                  {
                                                      foreach ($years as $year)
                                                      {
                                                          echo '<li class="dropdown-submenu">';
                                                            echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$year.'</a>';
                                                            echo '<ul class="dropdown-menu">';
                                                            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                            if (isset($months))
                                                            {
                                                                foreach ($months as $month)
                                                                {
                                                                    echo '<li><a href="v_app_my_by_status.php?status='.$item.'&year='.$year.'&month='.$month.'">'.$month.'</a></li>';
                                                                }
                                                            }
                                                            echo '</ul>';
                                                          echo '</li>';
                                                      }
                                                  }
                                                  echo '</ul>';
                                                echo '</li>';
                                              }
                                          }
                                        echo '</ul>';
                                    echo '</li>';



                                echo '</ul>';
                            echo '</li>';
                          }
                          ?><!-- .MY VIEWS -->


                            <!-- APPOINTMENTS -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Appointments <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/index.php' ? ' active' : '');?>"><a href="index.php">All Appointments</a></li>
                                    <li class="<?php echo ($_SERVER['PHP_SELF'] == '/v_app_upcoming.php' ? ' active' : '');?>"><a href="v_app_upcoming.php">Upcoming</a></li>

                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">By Surgeon</a>
                                        <ul class="dropdown-menu">
                                        <?php
                                        $dao = new DataAccessObject(INI_FILE_PATH);
                                        $surgeon = $dao->getKeyword('Surgeon');
                                        if (isset($surgeon))
                                        {
                                            foreach ($surgeon as $item)
                                            {
                                                echo '<li><a href="v_app_BySurgeon.php?surgeon='.$item.'">'.$item.'</a></li>'."\n";
                                            }
                                        }
                                            ?>
                                        </ul>
                                    </li>

                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">By Coordinator</a>
                                        <ul class="dropdown-menu">
                                        <?php
                                        $dao = new DataAccessObject(INI_FILE_PATH);
                                        $coordinator = $dao->getKeyword('Coordinator');
                                        if (isset($coordinator))
                                        {
                                            foreach ($coordinator as $item)
                                            {
                                                echo '<li><a href="v_app_ByCoordinator.php?coordinator='.$item.'">'.$item.'</a></li>'."\n";
                                            }
                                        }
                                            ?>
                                        </ul>
                                    </li>

                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">By Booking Status</a>
                                        <ul class="dropdown-menu">
                                        <?php
                                        $dao = new DataAccessObject(INI_FILE_PATH);
                                        $status = $dao->getKeyword('Booking Status');
                                        if (isset($status))
                                        {
                                            foreach ($status as $item)
                                            {
                                                echo '<li><a href="v_app_ByStatus.php?status='.$item.'">'.$item.'</a></li>'."\n";
                                            }
                                        }
                                            ?>
                                        </ul>
                                    </li>


                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">By Referring Dentist</a>
                                        <ul class="dropdown-menu">
                                        <?php
                                        $dao = new DataAccessObject(INI_FILE_PATH);
                                        $dentists = $dao->getAllRefDentists();
                                        if (isset($dentists))
                                        {
                                            foreach ($dentists as $item)
                                            {
                                                $firstLetter = substr($item, 0, 1); // to be used for alphabetical sort
                                                echo '<li><a href="v_app_ByDDS.php?dentist='.$item.'">'.$item.'</a></li>'."\n";
                                            }
                                        }
                                            ?>
                                        </ul>
                                    </li>
                                </ul>
                            </li><!-- .APPOINTMENTS -->


                            <!-- TX PLANS -->
                            <!-- <li>
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu 1 <b class="caret"></b></a>
                              <ul class="dropdown-menu multi-level">
                                  <li class="dropdown-submenu">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                      <ul class="dropdown-menu">
                                          <li><a href="#">Action</a></li>
                                          <li class="dropdown-submenu">
                                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                              <ul class="dropdown-menu">
                                                  <li class="dropdown-submenu">
                                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                                      <ul class="dropdown-menu">
                                                          <li><a href="#">Action</a></li>
                                                          <li><a href="#">Another action</a></li>
                                                          <li><a href="#">Something else here</a></li>
                                                          <li class="divider"></li>
                                                          <li><a href="#">Separated link</a></li>
                                                          <li class="divider"></li>
                                                          <li><a href="#">One more separated link</a></li>
                                                      </ul>
                                                  </li>
                                              </ul>
                                          </li>
                                      </ul>
                                  </li>
                              </ul>
                          </li>
                          <li> -->



                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Treament Plans <span class="caret"></span></a>
                                <ul class="dropdown-menu multi-level">
                                    <!-- <li class="dropdown-submenu">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">By Coordinator</a>
                                        <ul class="dropdown-menu">
                                        <?php
                                        // $dao = new DataAccessObject(INI_FILE_PATH);
                                        // $coordinators = $dao->getKeyword('Coordinator');
                                        // if (isset($coordinators))
                                        // {
                                        //     foreach ($coordinators as $coordinator)
                                        //     {
                                        //         echo '<li class="dropdown-submenu">';
                                        //           echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$coordinator.'</a>';
                                        //           echo '<ul class="dropdown-menu">';
                                        //           $years = $dao->getTxPlansYears();
                                        //           if (isset($years))
                                        //           {
                                        //               foreach ($years as $year)
                                        //               {
                                        //                   echo '<li class="dropdown-submenu">';
                                        //                     echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$year.'</a>';
                                        //                     echo '<ul class="dropdown-menu">';
                                        //                     $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                        //                     if (isset($months))
                                        //                     {
                                        //                         foreach ($months as $month)
                                        //                         {
                                        //                             echo '<li><a href="v_app_TreatPlanLive.php?coordinator='.$coordinator.'&year='.$year.'&month='.$month.'">'.$month.'</a></li>';
                                        //                         }
                                        //                     }
                                        //                     echo '</ul>';
                                        //                   echo '</li>';
                                        //               }
                                        //           }
                                        //           echo '</ul>';
                                        //         echo '</li>';
                                        //       }
                                        //   }
                                            ?>
                                        </ul>
                                    </li> -->

                                    <li class="dropdown-submenu">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">By Surgical Office</a>
                                        <ul class="dropdown-menu">
                                        <?php
                                        $dao = new DataAccessObject(INI_FILE_PATH);
                                        $homeoffices = $dao->getKeyword('Home Office');
                                        if (isset($homeoffices))
                                        {
                                            foreach ($homeoffices as $homeoffice)
                                            {
                                                echo '<li class="dropdown-submenu">';
                                                  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$homeoffice.'</a>';
                                                  echo '<ul class="dropdown-menu">';
                                                  $years = $dao->getTxPlansYears();
                                                  if (isset($years))
                                                  {
                                                      foreach ($years as $year)
                                                      {
                                                          echo '<li class="dropdown-submenu">';
                                                            echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$year.'</a>';
                                                            echo '<ul class="dropdown-menu">';
                                                            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                            if (isset($months))
                                                            {
                                                                foreach ($months as $month)
                                                                {
                                                                    echo '<li><a href="v_app_TreatPlanSurg.php?office='.$homeoffice.'&year='.$year.'&month='.$month.'">'.$month.'</a></li>';
                                                                }
                                                            }
                                                            echo '</ul>';
                                                          echo '</li>';
                                                      }
                                                  }
                                                  echo '</ul>';
                                                echo '</li>';
                                              }
                                          }
                                            ?>
                                        </ul>
                                    </li>
                                </ul>
                            </li><!-- .TX PLANS -->


                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Patients <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li <?php echo ($_SERVER['PHP_SELF'] == '/v_allPatients.php' ? ' active' : '');?>"><a href="v_allPatients.php">All Patients</a></li>

                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">By Home Office</a>
                                        <ul class="dropdown-menu">
                                        <?php
                                        $dao = new DataAccessObject(INI_FILE_PATH);
                                        $offices = $dao->getKeyword('Home Office');
                                        if (isset($offices))
                                        {
                                            foreach ($offices as $item)
                                            {
                                                echo '<li><a href="v_PatientsByOffice.php?office='.$item.'">'.$item.'</a></li>'."\n";
                                            }
                                        }
                                            ?>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <?php
                        if ($_SESSION['ses_Access'] == 'Admin'){
                                echo '<li class="dropdown">';
                                    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>';
                                    echo '<ul class="dropdown-menu">';
                                        echo '<li class=' . ($_SERVER['PHP_SELF'] == '/v_keywords.php' ? ' active' : '') . '><a href="v_keywords.php">Keywords</a></li>';
                                        echo '<li class=' . ($_SERVER['PHP_SELF'] == '/v_users.php' ? ' active' : '') . '><a href="v_users.php">Users</a></li>';
                                        echo '<li class=' . ($_SERVER['PHP_SELF'] == '/v_refDentists.php' ? ' active' : '') . '><a href="v_refDentists.php">Ref. Dentists</a></li>';
                                    echo '</ul></li>';
                            }
                            ?>
                          </ul>
                          <div>
                            <?php
                            if (substr($_SERVER['REQUEST_URI'], 0, 12) != "/Argyle/form") {
                                include_once 'Modules/search.php';
                            } ?>
                          </div>

                            <div class="pull-right text-right col-sm-2 infoHeader" id="titleScan">
                            <?php
                                echo '<strong>Hello!</strong> ' . $_SESSION['ses_FirstName'] .'<br>';
                                echo '<strong>Access:</strong> ' . $_SESSION['ses_Access'] .'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
                                echo '<button id="btnConfirmation" type="button" data-toggle="modal" data-target="#modalLogout">Log Out</button>';
                            ?>
                            </div>
                      </div>
                    </div>
                </nav>
