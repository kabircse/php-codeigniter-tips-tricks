SELECT UNIX_TIMESTAMP(field_name) AS fiel_name_utstmp FROM your_table

SELECT NOW(),CURDATE(),CURTIME()

SELECT * FROM Persons
WHERE LastName IN ('Hansen','Pettersen')
/* create a table with field  default data is date */
CREATE TABLE Orders
(
OrderId int NOT NULL,
ProductName varchar(50) NOT NULL,
OrderDate datetime NOT NULL DEFAULT NOW(),
PRIMARY KEY (OrderId)
)
/* after that, you can add new record without worry about date */
INSERT INTO Orders (ProductName) VALUES ('Jarlsberg Cheese')
-- compare 2 datetime
DATE_FORMAT(`date`, '%Y%m%d') >= DATE_FORMAT(NOW(), '%Y%m%d')

SELECT * FROM fiberbox WHERE field LIKE '%1740 %'
                           OR field LIKE '%1938 %'
                           OR field LIKE '%1940 %';
SELECT * from fiberbox where field REGEXP '1740|1938|1940';

// COMPARE DATE IN MYSQL
mysql> select datediff('2011-06-18','2011-06-25');
+-------------------------------------+
| datediff('2011-06-18','2011-06-25') |
+-------------------------------------+
|                                  -7 | 
+-------------------------------------+


ALTER TABLE contacts ADD email VARCHAR(60) AFTER name;
ALTER TABLE `pa_policy` CHANGE `prev_policy_number` `prev_policy_id` INT(11) DEFAULT NULL