DELIMITER $$
	CREATE TRIGGER insert_after_stock_in AFTER INSERT ON ac_stock_in
	FOR EACH ROW
		BEGIN
			IF NOT EXISTS(SELECT id FROM stock_in_out_by_date WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=(SELECT transaction_date FROM ac_transaction_master WHERE tran_id=NEW.tran_id))
				then
					INSERT INTO stock_in_out_by_date(date,stock_item_id,godown_id,qtyi,ratei,totali,color_id)
					VALUES ((SELECT transaction_date FROM ac_transaction_master WHERE tran_id=NEW.tran_id),NEW.stock_item_id,NEW.godown_id, NEW.qty, NEW.rate, NEW.total, NEW.color_id);		
			ELSE
				UPDATE stock_in_out_by_date SET qtyi = qtyi-(qty-NEW.qty), ratei = ratei-(rate-NEW.rate),totali = totali-(total-NEW.total);
			END IF;
END$$

DELIMITER ;

/*Working*/
**After update on ac_stock_in**
BEGIN
	DECLARE	tran_date DATE;
		SET tran_date = (SELECT transaction_date FROM ac_transaction_master WHERE tran_id=NEW.tran_id);
		IF(OLD.stock_item_id!=NEW.stock_item_id && OLD.godown_id!=NEW.godown_id && OLD.color_id!=NEW.color_id) then
			IF NOT EXISTS(SELECT id FROM stock_in_out_by_date WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=tran_date) then
					INSERT INTO stock_in_out_by_date(date,stock_item_id,godown_id,qtyi,ratei,totali,color_id)
					VALUES (tran_date,NEW.stock_item_id,NEW.godown_id, NEW.qty, NEW.rate, NEW.total, NEW.color_id);		
			ELSE
				UPDATE stock_in_out_by_date SET qtyi = qtyi-(OLD.qty-NEW.qty), ratei = ratei-(OLD.rate-NEW.rate),totali = totali-(OLD.totali-NEW.total) WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=tran_date;
			END IF;
		IF(OLD.stock_item_id==NEW.stock_item_id && OLD.godown_id!=NEW.godown_id && OLD.color_id!=NEW.color_id) then
			IF NOT EXISTS(SELECT id FROM stock_in_out_by_date WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=tran_date) then
					INSERT INTO stock_in_out_by_date(date,stock_item_id,godown_id,qtyi,ratei,totali,color_id)
					VALUES (tran_date,NEW.stock_item_id,NEW.godown_id, NEW.qty, NEW.rate, NEW.total, NEW.color_id);		
			ELSE
				UPDATE stock_in_out_by_date SET qtyi = qtyi-(OLD.qty-NEW.qty), ratei = ratei-(OLD.rate-NEW.rate),totali = totali-(OLD.totali-NEW.total) WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=tran_date;
			END IF;			
		IF(OLD.stock_item_id!=NEW.stock_item_id && OLD.godown_id!=NEW.godown_id && OLD.color_id=NEW.color_id) then
			IF NOT EXISTS(SELECT id FROM stock_in_out_by_date WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=tran_date) then
					INSERT INTO stock_in_out_by_date(date,stock_item_id,godown_id,qtyi,ratei,totali,color_id)
					VALUES (tran_date,NEW.stock_item_id,NEW.godown_id, NEW.qty, NEW.rate, NEW.total, NEW.color_id);		
			ELSE
				UPDATE stock_in_out_by_date SET qtyi = qtyi-(OLD.qty-NEW.qty), ratei = ratei-(OLD.rate-NEW.rate),totali = totali-(OLD.totali-NEW.total) WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=tran_date;
			END IF;
		END IF;
END
***************/

**After Insert on ac_stock_in**
BEGIN
	DECLARE	tran_date DATE;
		SET tran_date = (SELECT transaction_date FROM ac_transaction_master WHERE tran_id=NEW.tran_id);	
			IF NOT EXISTS(SELECT id FROM stock_in_out_by_date WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=tran_date)
				then
					INSERT INTO stock_in_out_by_date(date,stock_item_id,godown_id,qtyi,ratei,totali,color_id)
					VALUES (tran_date,NEW.stock_item_id,NEW.godown_id, NEW.qty, NEW.rate, NEW.total, NEW.color_id);		
			ELSE
				UPDATE stock_in_out_by_date SET qtyi = qtyi+NEW.qty, ratei = ratei+NEW.rate,totali = totali+NEW.total WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=tran_date;
			END IF;
END
****************/

DELIMITER #
	CREATE TRIGGER insert_after_stock_in AFTER INSERT ON ac_stock_in
	FOR EACH ROW
		BEGIN
			IF NOT EXISTS(SELECT id FROM stock_in_out_by_date WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=(SELECT transaction_date FROM ac_transaction_master WHERE tran_id=NEW.tran_id))
				then
					INSERT INTO stock_in_out_by_date(date,stock_item_id,godown_id,qtyi,ratei,totali,color_id)
					VALUES ((SELECT transaction_date FROM ac_transaction_master WHERE tran_id=NEW.tran_id),NEW.stock_item_id,NEW.godown_id, NEW.qty, NEW.rate, NEW.total, NEW.color_id);		
			ELSE
				UPDATE stock_in_out_by_date SET qtyi = qtyi+NEW.qty, ratei = ratei+NEW.rate,totali = totali+NEW.total WHERE stock_item_id=NEW.stock_item_id AND godown_id=NEW.godown_id AND color_id=NEW.color_id AND
				date=tran_date;;
			END IF;
END#

DELIMITER ;
