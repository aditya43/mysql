Set AUTO_INCREMENT :
    <?php
        $sql = 'ALTER TABLE `my_table` AUTO_INCREMENT=0';     
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Atomic :

    * In SQL, we try to keep columns atomic. Atomic means a smallest piece that make sense.

/*-----------------------------------------------------------------------------------------------------------------*/

SQL Datatypes :

    * Storing data in a right data type utilizes a space on disk. For e.g. Storing pure numeric data as a string consumes more space.
    * There are 3 main data types :
        - String
            - Char
            - nChar
            - Varchar
            - nVarchar
            - Text
        - Numeric
            - Integer
            - Fixed Point (Fixed number of decimal places)
            - Float Point (Decimal place is not fixed to particular position.)
        - Datetime
            - Date
            - Time
            - Datetime
        - Timestamp
            (Automatically generated and inserted)

/*-----------------------------------------------------------------------------------------------------------------*/

DDL and DML :

    * DDL stands for Data Definition Language. It deals with creating and manipulating schema (Create database, tables and manipulate etc).
    * DML stands for Data Manipulation Language. It deals with CRUD operation with database.

/*-----------------------------------------------------------------------------------------------------------------*/

Create Database :

    <?php
        $sql1 = "CREATE SCHEMA `movies`"; //Create database called 'movies'.
        //OR
        $sql2 = "CREATE DATABASE IF NOT EXISTS `movies`";
        $sql3 = "CREATE DATABASE IF NOT EXISTS `movies` CHARACTER SET = utf8";
    ?>


Select Database :

    <?php
        $sql = "USE `movies`"; //Select database 'movies'.
    ?>


Create Table :

    <?php
        $sql1 = "CREATE TABLE `actors` (`name` VARCHAR(50) NOT NULL)";
        $sql2 = "CREATE TABLE `movies` (`title` VARCHAR(200) NOT NULL, `year` INTEGER NULL)";
        $sql3 = "CREATE TABLE `movies` (`title` VARCHAR(200) NOT NULL, `year` INTEGER NULL) ENGINE InnoDB";
        $sql4 = "CREATE TABLE `test` (`id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL DEFAULT 0) ENGINE InnoDB";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Temporary Table :

    * Temporary table is visible to only current connection and is dropped automatically when the connection closes.
    * Syntax :

        <?php
            $sql = "CREATE TEMPORARY TABLE IF NOT EXISTS `movies`";
        ?>

/*-----------------------------------------------------------------------------------------------------------------*/

CRUD Basics :

             C.R.U.D.
    --------------------------
       Create   |   INSERT
       Read     |   SELECT
       Update   |   UPDATE
       Delete   |   DELETE

/*-----------------------------------------------------------------------------------------------------------------*/

Select Query :

    <?php
        $sql1 = "SELECT * FROM `movies`";
        $sql2 = "SELECT `title`, `year` FROM `movies`";
        $sql3 = "SELECT `movies.title`, `movies.year` FROM `movies`"; //We can attach table name before fields we wanna select. For e.g. movies.title and movies.year. This is used when we are selecting fields from multiple tables in a single query.
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

NULL Keyword : *******IMPORTANT

    * While selecting rows we cannot use euqal to (=) operator to select rows with NULL value.

        <?php
            $sql = "SELECT * FROM `movies` WHERE `year` = NULL"; //This will return 0 results! *****DOESN't WORK!!!
        ?>



    * To select rows with NULL values, use 'IS' keyword :

        <?php
            $sql = "SELECT * FROM `movies` WHERE `year` IS NULL"; //This will return rows with year value set to NULL
        ?>



    * To select rows with no NULL value :

        <?php
            $sql = "SELECT * FROM `movies` WHERE `year` IS NOT NULL";
        ?>


/*-----------------------------------------------------------------------------------------------------------------*/

IFNULL() Function : *******IMPORTANT

    * Specifies which value to return if value is NULL.

    <?php
        $sql = "SELECT `student_name`, AVG(`marks`) FROM `students`"; //This will return NULL for the students not having any value set for marks.
        $sql = "SELECT `student_name`, IFNULL(AVG(`marks`), 0) FROM `students`"; //This will return 0 for the students with no value set for marks.
    ?>


/*-----------------------------------------------------------------------------------------------------------------*/

WHERE clause :

    <?php
        $sql1 = "SELECT * FROM `movies` WHERE `year` = 2004";
        $sql2 = "SELECT * FROM `movies` WHERE `year` != 2004";
        $sql3 = "SELECT * FROM `movies` WHERE `year` > 2004";
    ?>



AND OR Clause :

    <?php
        $sql1 = "SELECT * FROM `movies` WHERE `year` > 2004 AND `title` = 'Matrix'";
        $sql2 = "SELECT * FROM `movies` WHERE `year` = 2004 OR `year` =2017";
    ?>



BETWEEN Clause :

    <?php
        $sql1 = "SELECT * FROM `movies` WHERE `year` BETWEEN 2008 AND 2017";
    ?>



LIKE Clause :

    <?php
        $sql1 = "SELECT * FROM `movies` WHERE `title` LIKE 'godfather'";
        //This will return row with a movie title strictly being 'godfather'.
         /*
            From stackoverflow : difference between Like and =

            LIKE can do wildcard matching:
                SELECT `foo` FROM `bar` WHERE `foobar` LIKE "Foo%"
            If you don't need pattern matching, then use = instead of LIKE. It's faster and more secure.
         */
    ?>



LIKE Clause With Wildcard :

    <?php
        $sql1 = "SELECT * FROM `movies` WHERE `title` LIKE '%godfather'";
        /*
            This will return movies with titles ending with 'godfather' word.

            For e.g.
                The godfather
                The Godfather
        */

       $sql2 = "SELECT * FROM `movies` WHERE `title` LIKE '%godfather%'";
       /*
            This will return movies with titles containing 'godfather' word in them.

            For e.g.
                The godfather
                Godfather
                The Godfather Part I
                Godfather II
       */
    ?>



ORDER BY Clause :

    <?php
        $sql1 = 'SELECT * FROM `movies` ORDER BY `year`'; //Default is Ascending order.
        $sql2 = "SELECT * FROM `movies` WHERE `year` IS NOT NULL ORDER BY `year`";
        $sql3 = 'SELECT * FROM `movies` ORDER BY `year` ASC'; //Ascending order.
        $sql4 = 'SELECT * FROM `movies` ORDER BY `year` DESC'; //Descending order.

        //We can order multiple columns in different orders.
        $sql5 = 'SELECT * FROM `movies` ORDER BY `year` DESC, `title` ASC';
        /*
            This will order year cloumn in descending order and title column in ascending order.
        */
    ?>
T


LIMIT and OFFSET Clause :

    <?php
        $sql1 = "SELECT * FROM `movies` LIMIT 10"; //Will return 10 rows
        $sql2 = "SELECT * FROM `movies` LIMIT 10 OFFSET 2"; //Return 10 rows starting from 3rd row.

        //To fetch rows from 11 to 20 :
        $sql3 = "SELECT * FROM `movies` LIMIT 10 OFFSET 10";

        /*
            Advanced Syntax :
                We can write LIMIT query by specifying offset first and then separate limit by comma following it.
            For e.g.
                In below example, LIMIT 20, 10 means return 10 rows starting from 21st row. Here, 20 is the offset and 10 is the limit
       */
       $sql4 = "SELECT * FROM `movies` LIMIT 20, 10";
    ?>



GROUP BY Clause :

    * The GROUP BY statement is often used with aggregate functions (COUNT, MAX, MIN, SUM, AVG) to group the result-set by one or more columns.
    * Syntax and example :

    <?php
        //Syntax :
        $sql1 = "SELECT column_name(s)
                FROM table_name
                WHERE condition
                GROUP BY column_name(s)
                ORDER BY column_name(s)";

        //The following SQL statement lists the number of customers in each country:
        $sql2 = "SELECT COUNT(CustomerID), Country
                FROM Customers
                GROUP BY Country";

        //The following SQL statement lists the number of customers in each country, sorted high to low:
        $sql3 = "SELECT COUNT(CustomerID), Country
                FROM Customers
                GROUP BY Country
                ORDER BY COUNT(CustomerID) DESC";

        //GROUP BY With JOIN Example
        //The following SQL statement lists the number of orders sent by each shipper:
        $sql4 = "SELECT Shippers.ShipperName, COUNT(Orders.OrderID) AS NumberOfOrders FROM Orders
                LEFT JOIN Shippers
                ON Orders.ShipperID = Shippers.ShipperID
                GROUP BY ShipperName";
    ?>



HAVING Clause :

    * It works as a filter on top of grouped rows returned by GROUP BY clause.
    * It cannot be replaced by a WHERE clause and vice-versa.
    * The HAVING clause was added to SQL because the WHERE keyword could not be used with aggregate functions.
    * Syntax and example :

    <?php
        //Syntax 1 :
        $sql1 = "SELECT column_name(s)
                 FROM table_name
                 WHERE condition
                 GROUP BY column_name(s)
                 HAVING condition_on_aggregate_column
                 ORDER BY column_name(s)";

        //The following SQL statement lists the number of customers in each country. Only include countries with more than 5 customers:
        $sql2 = "SELECT COUNT(CustomerID), Country
                 FROM Customers
                 GROUP BY Country
                 HAVING COUNT(CustomerID) > 5";

        //The following SQL statement lists the number of customers in each country, sorted high to low (Only include countries with more than 5 customers):
        $sql3 = "SELECT COUNT(CustomerID), Country
                 FROM Customers
                 GROUP BY Country
                 HAVING COUNT(CustomerID) > 5
                 ORDER BY COUNT(CustomerID) DESC";

        //The following SQL statement lists the employees that have registered more than 10 orders:
        $sql4 = "SELECT Employees.LastName, COUNT(Orders.OrderID) AS NumberOfOrders
                 FROM (Orders INNER JOIN Employees ON Orders.EmployeeID = Employees.EmployeeID)
                 GROUP BY LastName
                 HAVING COUNT(Orders.OrderID) > 10";

        //The following SQL statement lists if the employees "Davolio" or "Fuller" have registered more than 25 orders:
        $sql5 = "SELECT Employees.LastName, COUNT(Orders.OrderID) AS NumberOfOrders
                 FROM Orders
                 INNER JOIN Employees ON Orders.EmployeeID = Employees.EmployeeID
                 WHERE LastName = 'Davolio' OR LastName = 'Fuller'
                 GROUP BY LastName
                 HAVING COUNT(Orders.OrderID) > 25";
    ?>



EXISTS Clause :

    * The EXISTS operator is used to test for the existence of any record in a subquery.
    * The EXISTS operator returns true if the subquery returns one or more records.
    * Syntax and example :

    <?php
        //Syntax
        $sql1 = "SELECT column_name(s)
                FROM table_name
                WHERE EXISTS
                (SELECT column_name FROM table_name WHERE condition)";

        //The following SQL statement returns TRUE and lists the suppliers with a product price less than 20:
        $sql1 = "SELECT SupplierName
                FROM Suppliers
                WHERE EXISTS (SELECT ProductName FROM Products WHERE SupplierId = Suppliers.supplierId AND Price < 20)";

        //The following SQL statement returns TRUE and lists the suppliers with a product price equal to 22:
        $sql2 = "SELECT SupplierName
                FROM Suppliers
                WHERE EXISTS (SELECT ProductName FROM Products WHERE SupplierId = Suppliers.supplierId AND Price = 22)";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Index :

    * An index improves performance when reading or searching information from a particular column.
    * When inserting or updating a data in database, the index is updated as well.
    * Thats why, every index you add increases the writes to disk and therefire decreases the performance.
    * Use "EXPLAIN" keyword to diagnose the performance.
    * Must Read 2nd Reply : https://stackoverflow.com/questions/3567981/how-do-mysql-indexes-work

    <?php
        //Create index syntax :
        $sql = "CREATE INDEX my_index_name
                ON `table_name` (`column_name`)";

        //For e.g.
        $sql = "CREATE INDEX adi_emp
                ON `employees`(`name`)";

        //Create index in a CREATE TABLE query :
        $sql = "CREATE TABLE person (
                `last_name` VARCHAR(50) NOT NULL,
                `first_name` VARCHAR(50) NOT NULL,
                INDEX (`last_name`, `first_name`))";

        //To create a FULLTEXT index :
        $sql = "CREATE FULLTEXT INDEX index_name
        ON tbl_name (title, content)";

    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Database Engines :

    * Must Read : https://stackoverflow.com/questions/12614541/whats-the-difference-between-myisam-and-innodb

    <?php
        $sql = "SHOW ENGINES";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Inserting Data :

    <?php
        $sql1 = "INSERT INTO `movies` VALUES('Aviator', 2004)";
        $sql2 = "INSERT INTO `movies` (`title`, `year`) VALUES ('The Godfather', 1972)";

        //To insert multiple records :
        $sql3 = "INSERT INTO `movies` (`title`, `year`) VALUES
                     ('Aviator', 2004),
                     ('The Godfather', 1972),
                     ('The Matrix', 2004)
                 ";

        //To insert data using SET keyword :
        $sql4 = "INSERT INTO `movies` SET `title` = 'The Godfather II', `year` = 1986";
    ?>

    * We can also insert data into tables using 'SET' keyword.
    <?php
        $sql1 = "INSERT INTO `movies`
                 SET `title` = 'Matrix Reloaded',
                 `year` = '2018'";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Update Query :

    <?php
        $sql1 = "UPDATE `movies` SET `year` = 2017"; //This will set year for all rows to 2017.
        $sql2 = "UPDATE `movies` SET `year` = 2017 WHERE `title` = 'The Matrix'";

        //To update multiple values : For e.g. lets update year and title both for movie 'The Matrix'.
        $sql3 = "UPDATE `movies` SET `year` = 2018, `title` = 'The Matrix Reloaded' WHERE `title` = 'The Matrix'";

        //To change movie name using two conditions separated by 'OR' keyword
        $sql4 = "UPDATE `movies` SET `year` = 2018 WHERE `title` = 'Godfather' OR `title` = 'The Godfather'";
    ?>

    * SAFE UPDATE MODE error. To turn of Safe Mode Updates :

    <?php
        $sql = "SET SQL_SAFE_UPDATES = 0";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Delete Query :

    <?php
        $sql1 = "DELETE FROM `movies`"; //Will delete all rows in 'movies' table.
        $sql2 = "DELETE FROM `movies` WHERE `title` = 'The Matrix' AND `year` = 2018 LIMIT 1";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Altering Tables :

Rename Table :

    <?php
        //Renaming multiple tables separated by commas
        $sql = "RENAME TABLE `movies` TO `adi_movies`, `actors` TO `adi_actors`";
    ?>


Drop Table :

    <?php
        $sql = "DROP TABLE IF EXISTS `movies`";
    ?>


Truncate Table :

    <?php
        $sql1 = "TRUNCATE TABLE `movies`"; //Delete all rows in 'movies' table
        //OR
        $sql2 = "TRUNCATE `movies`";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Altering Columns :

Add Column :

    <?php
        $sql1 = "ALTER TABLE `movies` ADD COLUMN `genre` VARCHAR(100)";

        //Adding multiple columns
        $sql2 = "ALTER TABLE `actors` ADD (`actress` VARCHAR(100), `dob` DATE)";

        //To add column as a first column ('FIRST' Keyword)
        $sql3 = "ALTER TABLE `movies` ADD COLUMN (`id` INTEGER AUTO_INCREMENT PRIMARY KEY FIRST)";

        //To add column after existing column (AFTER `column_name`)
        $sql4 = "ALTER TABLE `movies` ADD COLUMN (`id` INTEGER AUTO_INCREMENT PRIMARY KEY AFTER `name`)";
    ?>


Change Column Name :

    <?php
        //Change column query can change only single column name at a time
        $sql1 = "ALTER TABLE `movies` CHANGE COLUMN `title` `movie_title` VARCHAR(100)";

        //To change only the data type of column
        $sql2 = "ALTER TABLE `movies` CHANGE COLUMN `year` `year` DATE";
        //OR to change data type of 'year' column to YEAR
        $sql3 = "ALTER TABLE `movies` CHANGE COLUMN `year` `year` YEAR";
    ?>


Remove Column :

    <?php
        $sql1 = "ALTER TABLE `movies` DROP COLUMN `title`";
        //Or
        $sql2 = "ALTER TABLE `movies` DROP `title`";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Altering Database :

Drop Database :

    <?php
        $sql1 = "DROP DATABASE IF EXISTS `movies`";
        //Or
        $sql1 = "DROP SCHEMA IF EXISTS `movies`";
    ?>


/*-----------------------------------------------------------------------------------------------------------------*/

Normalization :

    * Normalization is the process of setting up a table that contains repeated and redundant data from one column of a table and putting that information into another table.
    * For e.g. consider a following table 'movies' :

        Table `movies`
        ----------------------------------------
        title               |   genre
        ----------------------------------------
        The Godfather       |   Action
        The Matrix          |   Action
        Avatar              |   Sci Fi
        Predator            |   Sci Fi
        Le Miserables       |   Musical
        ----------------------------------------

    By Normalizing above table, we can create separate table 'genres' and in the 'movies' table, we will denote which movie belongs to which genre from 'genre' table.

        Table `movies`
        ----------------------------------------
        title               |   genre_id
        ----------------------------------------
        The Godfather       |   1
        The Matrix          |   1
        Avatar              |   2
        Predator            |   2
        Le Miserables       |   3
        ----------------------------------------


        Table `genres`
        ----------------------------------------
        id                  |   name
        ----------------------------------------
        1                   |   Action
        2                   |   Sci Fi
        3                   |   Musical
        ----------------------------------------

/*-----------------------------------------------------------------------------------------------------------------*/

Keys :

    * There are following types of keys :
        - Primary Key (for e.g. 'id')
            - Used to uniquely define each row in a table.
            - Can't be null
            - Can't be duplicated
        - Unique Key (For e.g. 'Email Address' or 'Social Security Number')
            - Similar to Primary Keys
            - Enforce uniqueness
            - Can't be null, unless you specify otherwise
            - Can't be duplicated
        - Foreign Key
            - Special keys that describes the relationship between data in two tables.
            - Foreign keys are also knows as reference keys.
            - They can be null.
            - They can be duplicated.


Adding Keys :

Primary Key :

    <?php
        //Lets create our 'genres' table from normalization example
        //We will create a new 'genres' table for this example instead of adding primary key to any existing table
        //We will specify multiple keys in this example
        $sql = "CREATE TABLE `genres` (`id` INTEGER AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(100) NOT NULL UNIQUE KEY)";
    ?>



Unique Key :

    <?php
        //We will modify 'genres' table and make 'genre_name' column a Unique Key
        //Remember, UNIQUE KEY can be NULL that is why we will explicitly specify it to be NOT NULL
        $sql = "ALTER TABLE `genres` CHANGE COLUMN `genre_name` `genre_name` VARCHAR(100) NOT NULL UNIQUE KEY";
    ?>



Foreign Key :

    * References a Unique key or primary key in another table.

    <?php
        //We will use ADD CONSTRAINT clause to add foreign key to 'movies' table.
        //Syntax : REFERENCES `table_name` (`column_name`)
        $sql1 = "ALTER TABLE `movies`
                ADD COLUMN `genre_id` INTEGER NULL,
                ADD CONSTRAINT FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`)";


        //To add multiple foreign keys in single query :
        $sql2 = "ALTER TABLE `comments`
                 ADD CONSTRAINT FOREIGN KEY (`uid`) REFERENCES `users` (`id`),
                 ADD CONSTRAINT FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

SQL Joins :

    * A JOIN clause is used to combine rows from two or more tables, based on a related column between them.
    * Types of Joins :
        - (INNER) JOIN: Returns records that have matching values in both tables
        - LEFT (OUTER) JOIN: Return all records from the left table, and the matched records from the right table
        - RIGHT (OUTER) JOIN: Return all records from the right table, and the matched records from the left table
        - FULL (OUTER) JOIN: Return all records when there is a match in either left or right table

/*-----------------------------------------------------------------------------------------------------------------*/

Inner Join :

    * The INNER JOIN keyword selects records that have matching values in both tables.
    * Syntax and example :

        <?php
            //Syntax
            $sql1 = "SELECT column_name(s)
                    FROM table1
                    INNER JOIN table2 ON table1.column_name = table2.column_name";


            //Joining 3 tables :
            $sql2 = "SELECT Orders.OrderID, Customers.CustomerName, Shippers.ShipperName
                     FROM ((Orders
                     INNER JOIN Customers ON Orders.CustomerID = Customers.CustomerID)
                     INNER JOIN Shippers ON Orders.ShipperID = Shippers.ShipperID)";
        ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Left Join :

    * The LEFT JOIN keyword returns all records from the left table (table1), and the matched records from the right table (table2). The result is NULL from the right side, if there is no match.
    * In some databases LEFT JOIN is called LEFT OUTER JOIN.
    * Syntax and example :

        <?php
            //Syntax
            $sql1 = "SELECT column_name(s)
                     FROM table1
                     LEFT JOIN table2 ON table1.column_name = table2.column_name";


            //The following SQL statement will select all customers, and any orders they might have
            // Note: The LEFT JOIN keyword returns all records from the left table (Customers), even if there are no matches in the right table (Orders).
            $sql2 = "SELECT Customers.CustomerName, Orders.OrderID
                     FROM Customers
                     LEFT JOIN Orders ON Customers.CustomerID = Orders.CustomerID
                     ORDER BY Customers.CustomerName";
        ?>
/*-----------------------------------------------------------------------------------------------------------------*/

Right Join :

    * The RIGHT JOIN keyword returns all records from the right table (table2), and the matched records from the left table (table1). The result is NULL from the left side, when there is no match.
    * In some databases RIGHT JOIN is called RIGHT OUTER JOIN.
    * Syntax and example :

        <?php
            //Syntax
            $sql1 : "SELECT column_name(s)
                     FROM table1
                     RIGHT JOIN table2 ON table1.column_name = table2.column_name";


            //The following SQL statement will return all employees, and any orders they might have placed
            //Note: The RIGHT JOIN keyword returns all records from the right table (Employees), even if there are no matches in the left table (Orders).
            $sql2 = "SELECT Orders.OrderID, Employees.LastName, Employees.FirstName
                     FROM Orders
                     RIGHT JOIN Employees ON Orders.EmployeeID = Employees.EmployeeID
                     ORDER BY Orders.OrderID";
        ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Full Join (Full Outer Join) :

    * The FULL OUTER JOIN keyword return all records when there is a match in either left (table1) or right (table2) table records.
    * Note: FULL OUTER JOIN can potentially return very large result-sets!
    * Syntax and example :

        <?php
            //Syntax
            $sql1 = "SELECT column_name(s)
                     FROM table1
                     FULL OUTER JOIN table2 ON table1.column_name = table2.column_name";


            //The following SQL statement selects all customers, and all orders
            //Note: The FULL OUTER JOIN keyword returns all the rows from the left table (Customers), and all the rows from the right table (Orders). If there are rows in "Customers" that do not have matches in "Orders", or if there are rows in "Orders" that do not have matches in "Customers", those rows will be listed as well.
            $sql2 = "SELECT Customers.CustomerName, Orders.OrderID
                     FROM Customers
                     FULL OUTER JOIN Orders ON Customers.CustomerID = Orders.CustomerID
                     ORDER BY Customers.CustomerName";
        ?>
/*-----------------------------------------------------------------------------------------------------------------*/

Self Join :

    * A self JOIN is a regular join, but the table is joined with itself.
    * Syntax and example :

        <?php
            //Syntax
            $sql1 = "SELECT column_name(s)
                     FROM table1 T1, table1 T2
                     WHERE condition;";


            //The following SQL statement matches customers that are from the same city:
            $sql2 = "SELECT A.CustomerName AS CustomerName1, B.CustomerName AS CustomerName2, A.City
                     FROM Customers A, Customers B
                     WHERE A.CustomerID <> B.CustomerID
                     AND A.City = B.City
                     ORDER BY A.City";
        ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Joining Tables (Another example) :

Inner Join :

    <?php
        //Lets fetch data from 'movies' table and 'genres' table
        $sql = "SELECT * FROM `movies` INNER JOIN `genres` ON movies.genre_id = genres.id";
    ?>

    <?php
        /*
            users
                - id
                - username
            topics
                - id
                - title
                - uid (User Id)
            posts
                - id
                - topic (Topic Id)
                - uid
                - body

            Some constraints :
                - Topic will always have user
                - Topic can have 0 posts
        */

       //To fetch topics from Topics table and usernames from Users table :
       $sql1 = "SELECT `topics.id`, `topics.title`, `users.username`, `users.id` AS `user_id`
                FROM `topics`
                INNER JOIN `users`
                ON `topics.uid` = `users.id`";

        //To fetch posts count :
        $sql2 = "SELECT `topics.id`, `topics.title`, `users.username`, `users.id` AS `user_id`
                COUNT(`posts.id`) AS `post_count`
                FROM `topics`
                INNER JOIN `users`
                ON `topics.uid` = `users.id`
                LEFT JOIN `posts`
                ON `topics.id` = `posts.topic`
                GROUP BY `topics.id`";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Table Aliases :

    * Make sure the alias is only 2 to 3 characters long.
    * Once the alias is defined, we must use it in place of table names everywhere.
    * Syntax and example :

        <?php
            //t1 and t2 are table aliases
            $sql = "SELECT * FROM table t1 JOIN table2 t2
                    on t1.id = t2.id";
        ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Many To Many Design Example :

    * Consider, we have a Users Table and Products Table. We want a single product can be owned by multiple users so they can split the revenue after sale.
    * In this scenario we can have 3 tables in total as follows :
    * In simple words, we will have 2 separate one-to-many relationship tables.

    <?php
        /*
            Users :
                id
                username
                email

            Products :
                id
                product_name

            Products_Listing :
                product_id (Foreign Key Referencing 'id' in 'Products' table)
                user_id    (Foreign Key Referencing 'id' in 'Users' table)

            ---------------------------

            Example Tables :

                    Users
            -------------------------
                    1 | Aditya
                    2 | Amey
                    3 | Kiran
                    4 | James
                    5 | Kurt
            -------------------------

                    Products
            -------------------------
                    1 | Camera
                    2 | Mobile
                    3 | Laptop
                    4 | Car
            -------------------------

                 Products_Listing
            -------------------------
                    1 | 1
                    1 | 2
                    2 | 1
                    4 | 3
            -------------------------
        */
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Good Database Design Practices :

Entity Integrity :
    * Every table should have a primary key (Unique, Not Null) and it should never change.
    * There are 2 kinds of Primary Keys :
        - Surrogate Keys : Automatically generated (for e.g. user ids).
        - Natural Keys : These are custom made (for e.g. email addresses, usernames).
    * Natural keys allows us to use less joins but they are not bullet proof solutions.



Referential Integrity :
    * This is related to foreign keys referencing data in other tables.


Domain Integrity :
    * It describes whats allowed and whats not allowed.
    * For e.g. In a column where we are storing phone number, we have to implement such an integrity which will ensure we are storing valid phone numbers and not just some random numbers.
    * Following are some ways to achieve domain integrity :
        - Use proper data types.
        - Use proper constraints (Not Null, Unique etc).
        - Format data in our application logic before it is inserted into database.

/*-----------------------------------------------------------------------------------------------------------------*/

Composite/Compound Key :

    * It consists of multiple columns. A combination of data from 2 or more columns representing a single unqie combination.
    * It is generally uses when 1 column is not enough to make row unique.
    * This is generally found in intermediary table in many-to-many design. For e.g. Products_Listing table in example above.
    * It is also commonly used with natural keys (for e.g. usernames, email addresses etc). For e.g. A combination of user_id and email_address representing a single user entity.

/*-----------------------------------------------------------------------------------------------------------------*/

Normalization Summery :

    1NF : Make every single column is singular (atomic). And try to relate every column to the key.
    2NF : Get rid of Partial Dependencies. Try to make sure that every single column has to describe the entire key.
    3NF : Deals with transitive dependencies. All data in table depends only on the keys.

/*-----------------------------------------------------------------------------------------------------------------*/

ON DELETE :

    * This clause deals with how the foreign key should behave.
    * It defines what happens to the child when we delete the parent.
    * There are following 3 options we can set :
        - RESTRICT (NO ACTION) : Default if ON DELETE is not specified on foreign key. Doesn't allow parent to be deleted.
        - CASCADE : Delete child row (that references the parent) if parent row is deleted.
        - SET NULL : Set attribute value in child row to null when parent row is deleted.

/*-----------------------------------------------------------------------------------------------------------------*/

CHAR datatype :

    * It stores fixed length data.
    * For e.g. If we have a `name` column with CHAR (10) datatype, and if we are storing the word "Hello" in it which is 5 characters long. When it is stored in database, mysql will append blank spaces at the end of the word "Hello" to make it 10 characters long.
    * CHAR datatype is good to use when the data we will be storing is of exact or nearby length.
    * For e.g. Good for storing password hashes which are of fixed length.

/*-----------------------------------------------------------------------------------------------------------------*/

TEXT Datatype :

    * Used for storing large chunk of textual data.
    * Does not allow any other value as DEFAULT other than NULL.
    * Also called as CLOB (Character Long Objects).
    * Sub types of TEXT Datatype :
        - TINYTEXT (255)
        - TEXT (65535)
        - MEDIUMTEXT (16 Million)
        - LONGTEXT (4 Billion)

/*-----------------------------------------------------------------------------------------------------------------*/

ENUM Datatype (Enumeration) :

    * An ENUM is a string object with a value chosen from a list of permitted values that are enumerated explicitly in the column specification at table creation time.
    * Compact data storage in situations where a column has a limited set of possible values.
    * Readable queries and output. The numbers are translated back to the corresponding strings in query results.
    * For e.g.

        <?php
            $sql1 = "CREATE TABLE shirts (
                        name VARCHAR(40),
                        size ENUM('x-small', 'small', 'medium', 'large', 'x-large')
                    )";

            //To insert :
            $sql2 = "INSERT INTO shirts (name, size) VALUES
                    ('dress shirt','large'),
                    ('t-shirt','medium'),
                    ('polo shirt','small')";
        ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Aggregate Functions :

COUNT() :

    <?php
        $sql1 = "SELECT COUNT(`salary`) as `sal_count` FROM `employee`;";

        //Above query can be used to count number of rows in `employee` table or following with (*) will also work
        $sql2 = "SELECT COUNT(*) as `total_employees` FROM `employee`";
    ?>



MIN(), MAX() :

    <?php
        $sql = "SELECT MIN(`salary`) as `min_sal`, MAX(`salary`) as `max_sal` FROM `employee`;";
    ?>



SUM() :

    <?php
        $sql = "SELECT SUM(`salary`) as `sum_sal` FROM `employee`;";
    ?>



AVG() :

    <?php
        //To find average without using AVG() function
        $sql1 = "SELECT SUM(`salary`) / COUNT(`salary`) as `avg_sal` FROM `employee`;";

        //To find average using AVG() function
        $sql1 = "SELECT AVG(`salary`) as `avg_sal` FROM `employee`;";
    ?>



CEIL(), FLOOR() :

    <?php
        //FLOOR()
        $sql1 = "SELECT FLOOR(AVG(`salary`)) as `floor_avg_sal` FROM `employee`;";

        //CEIL()
        $sql1 = "SELECT CEIL(AVG(`salary`)) as `floor_avg_sal` FROM `employee`;";
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

String Functions :

LOWER() : Converts value to lowercase.

    <?php
        $sql = "SELECT LOWER(`email`) FROM `users`"; //Converts email addresses to lowercase.
    ?>



UPPER() : Converts value to uppercase.

    <?php
        $sql = "SELECT UPPER(`first_name`) FROM `users`"; //Converts first names to uppercase.
    ?>



LENGTH() : Returns string length.

    <?php
        $sql = "SELECT LENGTH(`usernames`) FROM `users`"; //Returns string length of usernames.
    ?>



CONCAT() : Concatenates data. It takes any number of arguments.

    <?php
        $sql = "SELECT CONCAT(`first_name`, `last_name`) FROM `users`"; //Concatenates first names and last names.
        $sql = "SELECT CONCAT(`first_name`, ' ', `last_name`) FROM `users`"; //Concatenates first names and last names with space in between them.
    ?>



SUBSTRING() : Returns specific part of the string.

    <?php
        /*
            It takes 3 arguments :
            SUBSTRING(string, start_position, end_position)
            start_position starts from 1
        */

        $sql = "SELECT SUBSTRING(`email`, 1, 10) FROM `users`"; //Returns first 10 characters of email addresses.
        $sql = "SELECT CONCAT(SUBSTRING(LOWER(`email`), 1, 10), '...') FROM `users`"; //Returns first 10 characters of email addresses with "..." at the end in lowercase.
    ?>

/*-----------------------------------------------------------------------------------------------------------------*/

IF Function :

    * Syntax :
        <?php
            //Syntax
            $sql1 ="IF(expr, if_true_expr, if_false_expr)";

            //Example : If employee city is NULL, replace NULL by 'N/A'
            $sql2 = "SELECT
                    `id`,
                    `name`,
                    IF(`city` IS NULL, 'N/A', `city`) AS `city`,
                    `salary`
                    FROM `emp2`";
        ?>

/*-----------------------------------------------------------------------------------------------------------------*/

Creating users and assigning permissions :

    <?php
        //To create user and assign only Read or SELECT permission :
        $sql = "GRANT SELECT
                ON my_database.*
                TO user1@'%'
                IDENTIFIED BY 'password'";

        //After creating user, we need to refresh permissions on the database :
        $sql = "FLUSH PRIVILEGES";





      //To create user and assign SELECT, INSERT, UPDATE, DELETE permissions :
        //NOTE : Users won't have DDL commands access for e.g. ALTER, CREATE, ADD, DROP keywords.. drop table, add column etc.
        $sql = "GRANT SELECT, INSERT, UPDATE, DELETE
                ON my_database.*
                TO user@'%'
                INDENTIFIED BY 'password'";

        $sql = "FLUSH PRIVILEGES";





       //To create user and assign DDL permissions :
        $sql = "GRANT CREATE, ALTER, DROP
                ON my_database.*
                TO user@'%'
                IDENTIFIED BY 'password'";

        $sql = "FLUSH PRIVILEGES";

    ?>

/*-----------------------------------------------------------------------------------------------------------------*/
