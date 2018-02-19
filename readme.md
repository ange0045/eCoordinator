# Project Title

E-Coordinator is the final project build by group 4 during the Winter2018 term at Algonquin College as part of the IAWD course.
The E-Coordinator application will allow a user to monitor and update students progress through their program.


### Prerequisites

E-Coordinator requires PHP, Python, Apache, Bootstrap, jQuery and more stuff soon to come

### Installing

#### Windows

1. Install [WAMP Server](http://www.wampserver.com/en/#download-wrapper)
2. Run WAMP Manager
3. Git checkout the eCoordinator repository into the C:\wamp64\www directory
4. Visit http://localhost/phpmyadmin/server_databases.php
6. Select Import from the top navigation bar.
7. Select the dbSQLdump.sql file from C:\wamp64\www\ecoordinator\
8. Click "Go" button
9. Visit localhost/ecoordinator

##### Turn off PHP Notice Errors

1. Edit the file C:\wamp64\bin\php\php5.6.31\phpForApache.ini
2. Change line 449 from `error_reporting = E_ALL` to `error_reporting = E_ALL & ~E_NOTICE`

#### Adding a New User

1. Follow the sign up procedure at http://localhost/eCoordinator/f_newuser.php
2. Visit the users table in [phpMyAdmin](http://localhost/phpmyadmin/sql.php?db=ecoordinator&goto=db_structure.php&table=users&pos=0)
3. Edit the new user added above to change the user_approval column from `N` to `Y`
 
## Running the tests

Coming soon...


## Deployment

Coming soon...

## Built With

* [Bootstrap](https://getbootstrap.com/) - HTML, CSS, and JS toolkit
* [jQuery](https://jquery.com/) - JavaScript library



## Versioning

0.0.1 - First beta release

## Authors

* Kim, Amelia, Cody, Andre
