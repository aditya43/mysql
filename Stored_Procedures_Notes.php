Variables :

    * (:=) operator is used to assign value to a variable and (=) operator is used to compare the values.

    * A variable that begins with the "@" sign is session variable. It is available and accessible until the session ends.

    * Syntax for declaring variable :

        <?php
            //Syntax for declaring a variable
            $sql = "DECLARE variable_name datatype(size) DEFAULT default_value;";

            //Example :
            $sql = "DECLARE total_sale INT DEFAULT 0;

                    DECLARE x, y INT DEFAULT 0;";
        ?>

    * Syntax for creating/setting variable :

        <?php
            //Syntax
            $sql1 = "SET @variable_name = value";

            //Example
            $sql2 = "SET @my_var = 777";

            //Example of declaring and setting a variable
            $sql3 = "DECLARE total_count INT DEFAULT 0;

                     SET total_count = 10;";
        ?>

    * Syntax for creating variables within SELECT :

        <?php
            //Syntax
            $sql1 = "SELECT @variable_name := 'value'";

            //Example
            $sql2 = "SELECT @my_var := 777"; //This is an expression

            //NOTE :
            //With "SET @var = 777", we are creating a variable.
            //With "SELECT @my_var := 'value'" we are retrieving the value of variable "@my_var".
        ?>

    * To SELECT a result of a query into variable :

        <?php
            $sql = "DECLARE total_employees INT 0;

                    SELECT COUNT(*) INTO total_employees
                    FROM `employees`;";
        ?>

    * Example of creating variables using SET and SELECT :

        <?php
            $sql = "SET @var1 = 111;
                    SET @var2 = 222;
                    SET @var3 = 333;

                    SELECT @var1, @var2, @var3, @var1 + @var2 + @var3;
                    SELECT @var4 := @var1 + @var2 + @var3;";
        ?>

    * Single equal to (=) operator is used to check if values are equal. i.e. As a comparison operator.

        <?php
            $sql = "SET @my_var = 777;

                    SELECT @my_var = 777"; //This will return 1(TRUE)


            //To select an employee with 'id = 4'
            $sql = "SET @my_var = 4;

                    SELECT * FROM `employees`
                    WHERE `id` = @my_var";


            //Example of reassigning variables and again using them
            $sql = "SET @my_var = 2;

                    SELECT * FROM `employees`
                    WHERE `id` = @my_var;


                    SELECT @my_var := 4;    #Reassigning '@my_var' to value '4' here. NOTE the use of assignment operator (:=).

                    SELECT * FROM `employees`
                    WHERE `id` = @my_var"; //This will select employee with "id=2" and "id=4". We are reasssigning '@my_var = 4' using statement "SELECT @my_var := 4;".
        ?>

/*------------------------------------------------------------------------------------------------------------------------------------*/

Stored Procedures :

    * It is a section of code we can call using 'CALL' command.
    * They can accept arguments and parameters.
    * The first command is DELIMITER // , which is not related to the stored procedure syntax. The DELIMITER statement changes the standard delimiter which is semicolon ( ; ) to another. In this case, the delimiter is changed from the semicolon( ; ) to double-slashes // Why do we have to change the delimiter? Because we want to pass the stored procedure to the server as a whole rather than letting mysql tool interpret each statement at a time.  Following the END keyword, we use the delimiter //  to indicate the end of the stored procedure. The last command ( DELIMITER; ) changes the delimiter back to the semicolon (;).
    * To CREATE a PROCEDURE.. Syntax :

        <?php
            //Syntax for creating a procedure
            $sql = "DELIMITER //
                    DROP PROCEDURE IF EXISTS adi_emp //
                    CREATE PROCEDURE adi_emp()
                    BEGIN

                        #Procedure code goes here..

                    END //
                    DELIMITER ;"
        ?>



    * To CALL a procedure :

        <?php
            //Syntax for calling a procedure
            $sql = "CALL adi_emp()";
        ?>




    * To DROP or Delete a procedure :

        <?php
            $sql = "DROP PROCEDURE IF EXISTS `adi_emp`";
        ?>




    * Example of STORED PROCEDURE on `employees` table :

        <?php
            //Stored procedure to get top earning employees from all cities along with their departments.
            $sql = "DELIMITER //
                    DROP PROCEDURE IF EXISTS emp_get_top_earning_per_city //
                    CREATE PROCEDURE emp_get_top_earning_per_city()
                    BEGIN

                        SELECT e.id, e.name, e.city, d.name, MAX(e.salary) AS `max_salary`
                        FROM `employees` AS `e`
                        LEFT JOIN `dept` AS `d`
                        ON e.dept = d.id
                        GROUP BY e.city
                        ORDER BY `max_salary` DESC;

                    END //
                    DELIMITER ;";

            //To call above procedure :
            $sql = "CALL emp_get_top_earning_per_city();";
        ?>

/*------------------------------------------------------------------------------------------------------------------------------------*/

Parameters To Stored Procedures :

    * In MySQL, the parameters of a stored procedures has one of three modes: IN, OUT, or INOUT.

    * IN
      - IN is the default mode.
      - When you define an IN parameter in a stored procedure, the calling program has to pass an argument to the stored procedure.
      - In addition, the value of an IN parameter is protected.
      - It means that even if the value of IN parameter is changed inside the stored procedure, its original value is retained after the stored procedure ends.
      - In other words, the stored procedure only works on the copy of the IN parameter.


    * OUT
      - Value of an OUT parameter can be changed inside the stored procedure and its new value is passed back to the calling program.
      - Notice that the stored procedure cannot access the initial value of the OUT parameter when it starts.


    * INOUT
    - An INOUT  parameter is the combination of IN  and OUT  parameters.
    - It means that the calling program may pass the argument, and the stored procedure can modify the INOUT parameter and pass the new value back to the calling program.


    * Syntax for defining a parameter to a stored procedure :

        <?php
            //Syntax for defining a parameter
            $sql = "MODE param_name param_type(param_size)";

            //The 'MODE' could be 'IN', 'OUT' or 'INOUT' , depending on the purpose of the parameter in the stored procedure.
            //The 'param_name' is the name of the parameter. It must follow the naming rules of the column name in MySQL.
            //The 'param_type' is its data type and size. The data type of the parameter can be any valid MySQL data type.
        ?>

    * IN parameter example :

        <?php
            $sql1 = "DELIMITER //
                    DROP PROCEDURE IF EXISTS get_employees_from_city //
                    CREATE PROCEDURE get_employees_from_city(IN city VARCHAR(20))
                    BEGIN

                        SELECT employees.*, dept.name
                        FROM `employees`
                        LEFT JOIN `dept`
                        ON employees.dept = dept.id
                        WHERE employees.city = city
                        ORDER BY employees.salary DESC;

                    END //
                    DELIMITER ;";

            //To call above procedure
            $sql2 = "CALL get_employees_from_city('Pune');";
        ?>

    * OUT parameter example :

        <?php
            $sql1 = "DELIMITER //
                    DROP PROCEDURE IF EXISTS get_highest_salary_for_city //
                    CREATE PROCEDURE get_highest_salary_for_city(IN city VARCHAR(20), OUT max_salary INT)
                    BEGIN

                        SELECT MAX(`salary`) INTO `max_salary`
                        FROM `employees`
                        WHERE `city` = city;

                    END //
                    DELIMITER ;";

            //To call above procedure
            $sql2 = "CALL get_highest_salary_for_city('Pune', @max_salary);
                     SELECT @max_salary";
        ?>

    * INOUT parameter example :

        <?php
            //Increament counter by passed value
            $sql1 = "DELIMITER //
                    DROP PROCEDURE IF EXISTS increment_counter //
                    CREATE PROCEDURE increment_counter(INOUT counter INT(4), IN increment INT(4))
                    BEGIN

                        SET counter = counter + increment;

                    END //
                    DELIMITER ;";

            //To call above procedure
            $sql2 = "SET @counter = 1;
                     CALL increment_counter(@counter, 5);
                     SELECT @counter;"; //This will output 6
        ?>

/*------------------------------------------------------------------------------------------------------------------------------------*/

Procedure returning multiple values :

    <?php
        //To select 'name', 'joinDate', 'city', 'dept', 'salary' of a given employee id
        $sql1 = "DELIMITER $$
        DROP PROCEDURE IF EXISTS get_employee_info $$
        CREATE PROCEDURE get_employee_info(
            IN `empId` INT(4),
            OUT `outName` VARCHAR(20),
            OUT `outjoinDate` DATE,
            OUT `outCity` VARCHAR(20),
            OUT `outDept` VARCHAR(20),
            OUT `outSalary` INT(10)
            )
        BEGIN

            SELECT employees.name,
                   employees.joinDate,
                   employees.city,
                   dept.name,
                   employees.salary
            INTO `outName`,
                 `outjoinDate`,
                 `outCity`,
                 `outDept`,
                 `outSalary`
            FROM `employees`
            LEFT JOIN `dept`
            ON employees.dept = dept.id
            WHERE employees.id = empId;

        END $$
        DELIMITER ;";

        //To call above procedure
        $sql2 = "CALL get_employee_info(11, @outName, @outjoinDate, @outCity, @outDept, @outSalary);
                 SELECT @outName, @outjoinDate, @outCity, @outDept, @outSalary;";
    ?>

/*------------------------------------------------------------------------------------------------------------------------------------*/

IF Statement :

    <?php
        $sql = "IF expression THEN

                    statements..;
                    statements..;

                END IF;";
    ?>


IF ELSE Statements :

    <?php
        $sql = "IF expression THEN

                    statements..;
                    statements..;

                ELSE

                    statements..;
                    statements..;

                END IF;";
    ?>


IF ELSEIF ELSE Statements :

    <?php
        $sql = "IF expression THEN

                    statements..;

                ELSEIF expression THEN

                    statements..;

                ELSE

                    statements..;

                END IF;";
    ?>


Example :

    <?php
        //Pass the employee id and calculate if an employee is an average, above average or below average earner based on his salary
        $sql1 = "DELIMITER $$
                DROP PROCEDURE IF EXISTS get_employee_status_based_on_salary $$
                CREATE PROCEDURE get_employee_status_based_on_salary(
                    IN empId INT(4),
                    OUT empName VARCHAR(20),
                    OUT empSalary INT(10),
                    OUT empCity VARCHAR(20),
                    OUT empDept VARCHAR(20),
                    OUT empStatus VARCHAR(20)
                )
                BEGIN

                    SELECT employees.name,
                           employees.salary,
                           employees.city,
                           dept.name
                    INTO `empName`,
                         `empSalary`,
                         `empCity`,
                         `empDept`
                    FROM `employees`
                    LEFT JOIN `dept`
                    ON employees.dept = dept.id
                    WHERE employees.id = empId;

                    IF empSalary < 4000 THEN
                        SET empStatus = 'Below Average Earner';
                    ELSEIF empSalary > 7000 THEN
                        SET empStatus = 'Above Average Earner';
                    ELSE
                        SET empStatus = 'Average Earner';
                    END IF;

                END $$
                DELIMITER ;";

        //To call above procedure
        $sql2 = "CALL get_employee_status_based_on_salary(2, @empName, @empSalary, @empCity, @empDept, @empStatus);
                SELECT @empName, @empSalary, @empCity, @empDept, @empStatus;";
    ?>

/*------------------------------------------------------------------------------------------------------------------------------------*/

CASE Statement :

    * There are two forms of the CASE statements:
        - Simple CASE statements.
        - Searched CASE statements.



 Simple CASE statements :

    * Simple CASE statement is used to check the value of an expression against a set of unique values.
    * The ELSE  clause is optional. If you omit the ELSE clause and no match found, MySQL will raise an error.

    <?php
        //Syntax :
        $sql = "CASE expression
                    WHEN expression1 THEN

                        statements..;

                    WHEN expression2 THEN

                        statements..;

                    ELSE

                        statements..;

                    END CASE;";
    ?>
