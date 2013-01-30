How to Set up a Foreign Key Constraint in MySQL

The default storage engine in MySQL (MyISAM) does not support Foreign Key constraints. If you want to use Foreign Keys in Mysql, you need to use InnoDB.

The following is a simple example that illustrates Foreign Key constraints, we'll create tables to store information about Authors and their Books. The Foreign key will link a book to an Author. Note, that in MySQL we need to use the InnoDB storage engine to support Foreign Key Constraints.

First, we need to create a simple table for Authors. There are only two columns: a primary key and the author's name

CREATE TABLE author (id integer primary key auto_increment, name text) ENGINE=InnoDB;


Next, we create a simple table for Books. Again, we need a primary key (id), the title of the book, and the column that will be used as the Foreign Kye (author_id). The author_id column will be a Foreign Key that references the author table's id column (i.e. it's primary key).

CREATE TABLE books (id integer primary key auto_increment, title text, author_id integer NOT NULL) ENGINE=InnoDB;


Finally, we alter the books table to add the Foreign Key constraint. Below, the author_id_refs is just a name for the constraint, and this could be anything that we want (as long as it's sensible!)

ALTER TABLE `books` ADD CONSTRAINT author_id_refs FOREIGN KEY (`author_id`) REFERENCES `author` (`id`);


Another example is available in the MySQL documentation that covers Foreign Key Constraints.

An Example

Insert a couple of Authors:

insert into author (name) values ('Brad Montgomery');
insert into author (name) values ('John Doe');


Let's see what's in the author table:


mysql> select * from author;
+----+-----------------+
| id | name            |
+----+-----------------+
|  1 | Brad Montgomery | 
|  2 | John Doe        | 
+----+-----------------+
2 rows in set (0.00 sec)


Lets put some stuff in the Books table. Note that author_id column corresponds to the id column in the author table above.

insert into books (title, author_id) values ('Brads book', 1);
insert into books (title, author_id) values ('John Does book', 2);



Lets see what the books table looks like and what's in it:


mysql> describe books;
+-----------+---------+------+-----+---------+----------------+
| Field     | Type    | Null | Key | Default | Extra          |
+-----------+---------+------+-----+---------+----------------+
| id        | int(11) | NO   | PRI | NULL    | auto_increment | 
| title     | text    | YES  |     | NULL    |                | 
| author_id | int(11) | NO   | MUL | NULL    |                | 
+-----------+---------+------+-----+---------+----------------+
3 rows in set (0.00 sec)

mysql> select * from books;
+----+----------------+-----------+
| id | title          | author_id |
+----+----------------+-----------+
|  1 | Brads book     |         1 | 
|  2 | John Does book |         2 | 
+----+----------------+-----------+
2 rows in set (0.00 sec)



Try to Delete Something

When you try to delete an author, an Error will occur

delete from author where id=2;
ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails 
(`brad/books`, CONSTRAINT `author_id_refs` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`))


This happens because the data in the books table depends on the data in the author table. The Default constraint prevents you from deleting these books, without first deleting the author


mysql> delete from books where author_id=2;
Query OK, 1 row affected (0.00 sec)

mysql> delete from author where id=2;
Query OK, 1 row affected (0.01 sec)


ALTER TABLE `categories`
ADD CONSTRAINT `fk_categories_categories` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

CONSTRAINT `fk_SeNotesRel` FOREIGN KEY (`notesid`) REFERENCES `notes` (`notesid`) ON DELETE CASCADE,  
              CONSTRAINT `fk_SeNotesRel2` FOREIGN KEY (`crmid`) REFERENCES `crmentity` (`crmid`) ON DELETE CASCADE  


DELETE foreign key
    ALTER TABLE `categories` DROP FOREIGN KEY `fk_categories_categories`;



http://www.mobilefish.com/developer/mysql/mysql_quickguide_foreign_keys.html ON ACTION DO_SOMETHING

When you delete the author's books first, the author no longer has any dependencies. You can therefore delete the author.

MySQL is a free database server used to create dynamic web pages. Foreign keys link to a primary key in your tables....


http://www.w3schools.com/sql/sql_foreignkey.asp
http://bradmontgomery.blogspot.com/2009/04/how-to-set-up-foreign-key-constraint-in.html
http://www.sitepoint.com/mysql-foreign-keys-quicker-database-development/

http://www.ehow.com/way_5247249_mysql-foreign-key-tutorial.html

A issue about foreign key in MySQL
http://stackoverflow.com/questions/1905470/cannot-delete-or-update-a-parent-row-a-foreign-key-constraint-fails

http://dev.mysql.com/doc/refman/5.5/en/innodb-foreign-key-constraints.html
