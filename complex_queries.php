<?php

//To select highest earning employee from each city
$sql = "SELECT * FROM `employees` AS `e` INNER JOIN
(SELECT MAX(`salary`) AS `ms` FROM `employees` GROUP BY `city`) AS `m`
ON e.salary = m.ms";


//To get 'n' records from each group :
$sql7 = "SELECT name, city, salary
        FROM
        (
            SELECT name, city, salary,
                @rn := IF(@prev = city, @rn + 1, 1) AS rn,
                @prev := city
            FROM employees
            INNER JOIN (SELECT @prev := NULL, @rn := 0) AS vars
            ORDER BY city, salary DESC, name
        ) AS T1
        WHERE rn <= 2";


//To select highest earning employee and 2nd highest earning employee from each city :
$sql2 = "(SELECT a.id, a.name, a.city,
             (SELECT b.salary FROM `employees` AS `b`
                WHERE b.city = a.city
                ORDER BY `salary` DESC
                LIMIT 1,1 ) AS `salary`
         FROM employees AS `a`
         GROUP BY a.city)
         UNION
         (SELECT b.id, b.name, b.city, MAX(b.salary) AS `salary`
            FROM employees AS `b`
            GROUP BY b.city)";


//To find number of employess working in each dept. in each city :
$sql3 = "SELECT employees.city, dept.name, COUNT(employees.id) AS `Employees`
        FROM `employees`
        LEFT JOIN `dept`
        ON employees.dept = dept.id
        GROUP BY employees.city, employees.dept
        ORDER BY employees.city, employees.dept";


//To find number of employees hired each year in every dept :
$sql4 = "SELECT YEAR(`joinDate`) AS `Year`, dept.name, COUNT(*) AS `Employees`
        FROM `employees`
        LEFT JOIN `dept`
        ON employees.dept = dept.id
        GROUP BY YEAR(`joinDate`), employees.dept
        ORDER BY `Employees` DESC";


//To find MIN(), MAX(), AVG() salaries in each city :
$sql5 = "SELECT `city`, MIN(`salary`) AS `Minimum_Salary`, MAX(`salary`) as `Maximum_Salary`, CEIL(AVG(`salary`)) AS `Average_Salary`
        FROM `employees`
        GROUP BY `city`";


//To find the total amount paid in salaries for each department :
$sql6 = "SELECT dept.name, SUM(employees.salary) AS `Total_Amount`
        FROM `employees`
        LEFT JOIN `dept`
        ON employees.dept = dept.id
        GROUP BY employees.dept
        ORDER BY `Total_Amount` DESC";

/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/
//                             HAVING CLAUSE
/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

//To find the total amount paid in salaries for specific departments (Developer(1) OR Executive(4) OR Accounts(3)) :
//Following approach is quite slower as compared to using WHERE.
$sql7 = "SELECT dept.name, SUM(employees.salary) AS `total_sal`
        FROM `employees`
        LEFT JOIN `dept`
        ON employees.dept = dept.id
        GROUP by employees.dept
        HAVING employees.dept = 1 OR employees.dept = 4 OR employees.dept = 3
        ORDER by `total_sal` DESC";

//Fast approach using WHERE clause.
$sql8 = "SELECT dept.name, SUM(employees.salary) AS `total_sal`
        FROM `employees`
        LEFT JOIN `dept`
        ON employees.dept = dept.id
        WHERE employees.dept = 1 OR employees.dept = 4 OR employees.dept = 3
        GROUP by employees.dept
        ORDER by `total_sal` DESC";


/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/
//                             STORED PROCEDURES
/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/


 //Stored procedure to get top earning employees from all cities along with their departments.
$sql9 = "DELIMITER //
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
$sql10 = "CALL emp_get_top_earning_per_city();";


/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/
//                             IF FUNCTION
/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/


//To count the total number of emplyees from the given city : 'Pune'
$sql11 = "SELECT 'Pune' AS `city`, SUM(IF(`city` = 'Pune', 1, 0)) AS `total_employees`
          FROM `employees`";

//To count the total number of employees from more 2 cities : 'Pune', 'Mumbai'
//Ofcourse we can achieve this by using 'GROUP BY' and without using 'COUNT'
$sql12 = "SELECT COUNT(IF(`city` = 'Pune', 1, NULL)) AS `total_employees_pune`,
          COUNT(IF(`city` = 'Mumbai', 1, NULL)) AS `total_employees_mumbai`
          FROM employees";
?>

