Timestamp :

    <?php
        //Create table
        $sql = "CREATE TABLE `time_zone_adi`(
                `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                `name` VARCHAR(255),
                `timestamp` TIMESTAMP)";

        //Insert data
        $sql = "INSERT INTO (`name`) VALUES ('Aditya Hajare')"; //Only insert `name` since `id` and `timestamp` will be auto generated and inserted.
    ?>

    * To see what timezone mysql is using :

    <?php
        //Generally MySQL is configured to use host SYSTEM timezone.
        $sql = "SELECT @@time_zone"; //Generally outputs : SYSTEM
    ?>

    * To change timezone :

    <?php
        //This works only if time_zones tables are installed in MySQL.
        $sql = "SET time_zone = 'US/Eastern'";
    ?>

/*------------------------------------------------------------------------------------------------------------------------------------*/

Realtime Production Environment Example :

    * Lets say we have stored timestamps in database and we want to display those times to users according to their timezones.
    * Best approach to this is :
        - Before firing SELECT query to fetch timestamp from table, Set time_zone to user's time_zone.
        - Fire a select query.
        - Set time_zone back to SYSTEM.

/*------------------------------------------------------------------------------------------------------------------------------------*/
