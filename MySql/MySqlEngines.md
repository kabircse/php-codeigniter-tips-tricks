MySQL storage engine:
1. Memory Table: Tables that are present in the memory are called as Memory Tables(previously known as HEAP table). When creating a HEAP table in MySql, user needs to specify the TYPE as HEAP. These memory tables never have values with data type like “BLOB” or “TEXT”. They use indexes which make them faster. It sores all data in RAM for faster access than storing data on disks. Useful for quick looks up of reference and other identical data.


2.MyISAM: MyISAM Default storage engine, manages non transactional tables, provides high-speed storage and retrieval, supports full text searching.


3.InnoDB: Provides transaction-safe (ACID compliant) tables, supports FOREIGN KEY referential-integrity constraints. It supports commit, rollback, and crash-recovery capabilities to protect data. It also support row-level locking. It's "consistent nonlocking reads" increases performance when used in a multiuser environment. It stores data in clustered indexes which reduces I/O for queries based on primary keys.

MySQL Indexs are synonym as key. Basically, Key is logical model and Index is implementation.
