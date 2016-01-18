TRIGGERING  EXAMPLE:
---------------------------

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
		
	/*ac_stock_in*/
	----------------
	
		**After Insert on ac_stock_in**
		DELIMITER //
		CREATE TRIGGER insert_after_stock_in AFTER insert ON ac_stock_in
			FOR EACH ROW
			BEGIN	
				IF NOT EXISTS(SELECT id FROM stock_in_out_by_date WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND transaction_date=NEW.transaction_date)
					then
						INSERT INTO stock_in_out_by_date(transaction_date,stock_item_id,godown_id,qtyi,ratei,totali,color_id)
						VALUES (NEW.transaction_date,NEW.stock_item_id,NEW.godown_id, NEW.qty, NEW.rate, NEW.total, NEW.color_id);		
				ELSE
					UPDATE stock_in_out_by_date SET qtyi = qtyi+NEW.qty, ratei = ratei+NEW.rate,totali = totali+NEW.total WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND transaction_date=NEW.transaction_date;
				END IF;
			END //
		DELIMITER ;
		****************/
		
		/*update trigger for ac_stock_in*/
		DELIMITER //
			CREATE TRIGGER upate_after_stock_in AFTER update ON ac_stock_in
			FOR EACH ROW
		BEGIN
				IF(OLD.stock_item_id!=NEW.stock_item_id || OLD.godown_id!=NEW.godown_id || OLD.color_id!=NEW.color_id || OLD.transaction_date!=NEW.transaction_date) then				
					UPDATE stock_in_out_by_date SET qtyi = qtyi-OLD.qty, ratei = ratei-OLD.rate,totali = totali-OLD.total WHERE stock_item_id=OLD.stock_item_id AND godown_id=OLD.godown_id AND color_id=OLD.color_id AND transaction_date=OLD.transaction_date;
						
					IF NOT EXISTS(SELECT id FROM stock_in_out_by_date WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND transaction_date=NEW.transaction_date)
						then
							INSERT INTO stock_in_out_by_date(transaction_date,stock_item_id,godown_id,qtyi,ratei,totali,color_id)
							VALUES (NEW.transaction_date,NEW.stock_item_id,NEW.godown_id, NEW.qty, NEW.rate, NEW.total, NEW.color_id);		
					ELSE
						UPDATE stock_in_out_by_date SET qtyi = qtyi+NEW.qty, ratei = ratei+NEW.rate,totali = totali+NEW.total WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND transaction_date=NEW.transaction_date;
					END IF;
				ELSE			
					UPDATE stock_in_out_by_date SET qtyi = qtyi-(OLD.qty-NEW.qty), ratei = ratei-(OLD.rate-NEW.rate),totali = totali-(OLD.total-NEW.total)
					WHERE stock_item_id=OLD.stock_item_id AND godown_id=OLD.godown_id AND color_id=OLD.color_id AND transaction_date=OLD.transaction_date;
				END IF;
			END //
		DELIMITER ;
		
		/*Delete trigger for ac_stock_in*/
		DELIMITER //
			CREATE TRIGGER delete_after_stock_in AFTER delete ON ac_stock_in
			FOR EACH ROW
			BEGIN
				UPDATE stock_in_out_by_date SET qtyi = qtyi-OLD.qty, ratei = ratei-OLD.rate,totali = totali-OLD.total WHERE stock_item_id=OLD.stock_item_id AND godown_id=OLD.godown_id AND color_id=OLD.color_id AND transaction_date=OLD.transaction_date;
		END //
		DELIMITER ;
		
		
		
		/*ac_stock_out*/
		**After Insert on ac_stock_out**
		DELIMITER //
		CREATE TRIGGER insert_after_stock_out AFTER insert ON ac_stock_out
		FOR EACH ROW
		BEGIN
					IF NOT EXISTS(SELECT id FROM stock_in_out_by_date WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND transaction_date=NEW.transaction_date)
						then
							INSERT INTO stock_in_out_by_date(transaction_date,stock_item_id,godown_id,qtyo,rateo,totalo,color_id)
							VALUES (NEW.transaction_date,NEW.stock_item_id,NEW.godown_id, NEW.qty, NEW.rate, NEW.total, NEW.color_id);		
					ELSE
						UPDATE stock_in_out_by_date SET qtyo = qtyo+NEW.qty, rateo = rateo+NEW.rate,totalo = totalo+NEW.total WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND transaction_date=NEW.transaction_date;
					END IF;
			END //
		DELIMITER ;
		
		
		/*update trigger for ac_stock_out*/
		DELIMITER //
			CREATE TRIGGER upate_after_stock_out AFTER update ON ac_stock_out
			FOR EACH ROW
		BEGIN
				IF(OLD.stock_item_id!=NEW.stock_item_id || OLD.godown_id!=NEW.godown_id || OLD.color_id!=NEW.color_id || OLD.transaction_date!=NEW.transaction_date) then				
					UPDATE stock_in_out_by_date SET qtyo = qtyo-OLD.qty, rateo = rateo-OLD.rate,totalo = totalo-OLD.total WHERE stock_item_id=OLD.stock_item_id AND godown_id=OLD.godown_id AND color_id=OLD.color_id AND OLD.transaction_date=NEW.transaction_date;
						
					IF NOT EXISTS(SELECT id FROM stock_in_out_by_date WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND transaction_date=NEW.transaction_date)
						then
							INSERT INTO stock_in_out_by_date(transaction_date,stock_item_id,godown_id,qtyo,rateo,totalo,color_id)
							VALUES (NEW.transaction_date,NEW.stock_item_id,NEW.godown_id, NEW.qty, NEW.rate, NEW.total, NEW.color_id);		
					ELSE
						UPDATE stock_in_out_by_date SET qtyo = qtyo+NEW.qty, rateo = rateo+NEW.rate,totalo = totalo+NEW.total WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND transaction_date=NEW.transaction_date;
					END IF;
				ELSE			
					UPDATE stock_in_out_by_date SET qtyo = qtyo-(OLD.qty-NEW.qty), rateo = rateo-(OLD.rate-NEW.rate),totalo = totalo-(OLD.total-NEW.total)
					WHERE stock_item_id=OLD.stock_item_id AND godown_id=OLD.godown_id AND color_id=OLD.color_id AND transaction_date=OLD.transaction_date;
				END IF;
			END //
		DELIMITER ;
		
		****************/
		
		
		/*Delete trigger for ac_stock_out*/
		DELIMITER //
			CREATE TRIGGER delete_after_stock_out AFTER delete ON ac_stock_out
			FOR EACH ROW
			BEGIN
				UPDATE stock_in_out_by_date SET qtyo = qtyo-OLD.qty, rateo = rateo-OLD.rate,totalo = totalo-OLD.total WHERE stock_item_id=OLD.stock_item_id AND godown_id=OLD.godown_id AND color_id=OLD.color_id AND transaction_date=OLD.transaction_date;
		END //
		DELIMITER ;
