Full Text Search :

    * MUST WATCH : L:\Movies\Tutorials\Lynda.com - PHP with MySQL Collection (5 courses)\MySQL Essentials\7 - MySQL Functions\7-9 Full-text search.mov

    * MySQL has a powerful Full Text Search feature.

    <?php
        //Syntax :
        $sql = "CREATE FULLTEXT INDEX index_name
                ON tbl_name (title, content)";

        //Creating sample table with FULLTEXT index
        $sql = "CREATE TABLE `articles` (
                `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                `title` VARCHAR(255),
                `body` TEXT,
                FULLTEXT(`title`, `body`))"; //FULLTEXT specifies the type of index which is used for fulltext searches.

        //Inserting sample data in above table for testing purposes :
        $sql = "INSERT INTO `articles` (`title`, `body`) VALUES
                ('What is DBMS', 'DBMS stands for database management system'),
                ('What is RDBMS', 'RDBMS stands for relational database management system'),
                ('Capitol of India', 'Capitol of India is Delhi'),
                ('My favourite color', 'My favourite color is black'),
                ('Lead vocal of Lamb of God Band', 'The lead vocal of Lamb of God band is Randy Blythe'),
                ('Full form of PVGCOET', ('PVGCOET Stands for Pune Vidyarthee Gruha\'s College Of Engineering Technology. And it sucks!!'))";
    ?>

/*------------------------------------------------------------------------------------------------------------------------------------*/

Full Text Search - Natural Search :

    <?php
        //Natural Search
        $sql = "SELECT * FROM `table`
                WHERE MATCH('column_1','column_2')
                AGAINST ('search_keyword')";

        //Example : (By default following query is using Natural Search)
        $sql = "SELECT * FROM `articles`
                WHERE MATCH(`title`, `body`)
                AGAINST('pvgcoet')"; //This will search `title` and `body` columns for the keyword 'pvgcoet'.
    ?>

/*------------------------------------------------------------------------------------------------------------------------------------*/

Full Test Search - Boolean Mode Search :

    <?php
        //If we want to get search results which strictly has all the search keywords then we have to use Boolean Mode Search :
        $sql = "SELECT * FROM `articles`
                WHERE MATCH(`title`, `body`)
                AGAINST('+database +management' IN BOOLEAN MODE)"; //Return rows which strictly has both 'database' and 'management' keywords.

        //If we want to get rows which strictly has word 'database' but not the 'management' in them :
        $sql = "SELECT * FROM `articles`
                WHERE MATCH(`title`, `body`)
                AGAINST('+database -management' IN BOOLEAN MODE)"; //Return rows which has 'database' but not the 'management' keywords in them.
    ?>

/*------------------------------------------------------------------------------------------------------------------------------------*/

Full Test Search - With Query Expansion Search :

/*------------------------------------------------------------------------------------------------------------------------------------*/
