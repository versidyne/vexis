[Vexis](http://getvexis.com/) - Universal Content Management System
=====
#####Overview
This is the complete core of Vexis.  This can be utilized to set up nodes, websites, and anything else one's heart can desire.

#####Requirements
Service:
* Apache (Experimental)
* LigHTTPD

Interpreter:
* PHP5

Database:
* MySQL
* Postgres (Experimental)
* SQLite (Experimental)

#####Main Goals
* Maintain a solid system of which website development and graphic design can take place.  The issue in this scenario is that the system is meant to be universal, so the intial installation must be very basic but still have all necessary components for expansion within the main administration panel.  This will be an interesting hurdle to jump over, but it will be important in maintain a solid, universal product for many generations to come.

* Maintain several different "gateways" that will provide different types of functionality for various domains, subdomains, and virtual subdirectories.

#####Demonstration
Website: http://demo.getvexis.com/  
Admin Panel: http://admin.demo.getvexis.com/

Installation
=====
#####Overview
This is a simple process and will remain as such if instructions are followed carefully.

#####Configuration
Copy the config.sample.php file to config.php, open the file (which is fairly straight forward), and replace the sample data with the data from your server.

#####Database
Import the SQL file from the install folder directly into phpMyAdmin or using a shell prompt.  The shell prompt should look like this:

```sh
mysql -u root -p[root_password]

mysql> create database [database_name];
Query OK, 1 row affected (0.02 sec)

mysql -u root -p[root_password] [database_name] < database.sql
```

If this was done correctly you should be able to have a nice output from your website.  You should then visit the "Settings" table and change the various settings specifically for your domain and server information to avoid future issues when logging in for the first time.

**Note**: This installation process will soon be completely done from an installation file.

#####Finalizing
Since everything should be smoothly configured, delete the install folder.  This will keep your system from having your settings overwritten which is a large security vulnerability.

System Roles
=====
#####Overview
The roles that follow are separated within a directory specific to its name.  Within these directories, each role will have its format and place in the order of the system as it runs.  The role will dictate where a particular feature will need to go and from there we can maintain quite a vast sense of universal ability.

#####Extensions
Extensions will involve a top level action enabled across the board for all pages.

```php
//Sample Format

//object oriented class style information here
echo "Hello World!";
```

#####Gateways
Only one gateway can run and is set by the children block in the database.

* ACP - Admin Control Panel*
* API - Application Programming Interface
* CMS - Content Management System
* CDN - Content Delivery Network

*This needs to be able to be accessed regardless of the ability of the website to run, after changes have been made.  This should also include some sort of hardcoded recovery admin to help through that process in the case that major issues arise.

#####Includes
These are files that contain the initial hooks, like configuration and globals.

#####Libraries
These are files that are available throughout the system at any time.  They work in an object oriented method and contribute in common and general ways (i.e. database interfacing, markup languages, etc).  These files are extremely flexible and should be edited on a common basis.

Note: The loading of these files is going to be more nested in the coming versions.  We will be loading data in namespaces, and this will go into various types of a hierarchy, similar to that of the widely known SplClassLoader.php file.

#####Modules
These are files that are only executed by a particular gateway and are held in a folder specific to that gateway.  These files are specific to a particular page that calls them, can only run once, can only have one injection and do not run across the entire system.  These are meant for extremely specific tweaks.

#####Plugins
Plugins will involve a bottom level action enabled particularly within pages that call for them, which can involve multiple injections.

```php
//Sample Format

//object oriented class style information here
echo "Hello World!";
```

#####Index.php
This file is meant to be the "traffic cop" of the system.  It is the only file that is ever truly executed and it builds all data in a particular order.  It is very flexible and should be edited on a rare basis.

Credits
=====
This project has always been built by only one programmer, Alex Gurrola.  One day he hopes this system will no longer require his influence to progress without feature creep.
