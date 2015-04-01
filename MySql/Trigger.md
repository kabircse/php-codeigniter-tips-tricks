TRIGGERING  EXAMPLE:

Example-1:
DELIMITER$$
     CREATE TRIGGER BEFORE_DELETE_STDFEE1
     BEFORE DELETE ON stdfee1
     FOR EACH ROW
          BEGIN
              INSERT INTO AX VALUES(55,25,25,34,85,128037,'2014-23-19 13:31:18',55);
         END$$
DELIMITER ;

Example-2:
DELIMITER $$
     CREATE TRIGGER AFTER_DELETE_PAYROLL
     AFTER DELETE on payroll
     FOR EACH ROW
     BEGIN
          INSERT INTO stdfee1 VALUES(5,55,25,25,34,85,128037,'2014-23-1913:31:18',55);
    END$$
DELIMITER ;


Trigger Sources:
<a>http://www.sitepoint.com/how-to-create-mysql-triggers/</a>

MySql Trigger-3:
DELIMITER $$
     CREATE TRIGGER INSERT_HISTORY_AFTER_MSG
     AFTER INSERT ON message
     FOR EACH ROW
          BEGIN
                  INSERT INTO history(rowId,data,time,status)
                   VALUES(NEW.msgId,NEW.msg,NEW.date,NEW.status);
          END$$
DELIMITER ;
------------------------------------

Example-4:
DELIMITER $$
      DROP TRIGGER IF EXISTS test;
      DELIMITER $$
      CREATE TRIGGER test
            AFTER INSERT ON fee_master
            FOR EACH ROW
                BEGIN
                      INSERT INTO payroll(loan,netSalary) VALUES(NEW.amount, NEW.fine);
               END $$
 DELIMITER ;
/////Main Query:
///INSERT INTO fee_master(cTId,feeType,amount,startDate,lastDate,fine_last_date,fine,status)//
//values(11,'exam1',1100,'2014-07-10','2014-06-05','2014-07-25',10,1);
***************************************************************************************
