### SQL Add Index
`ALTER TABLE table ADD INDEX index_name (column);`


````
CREATE TABLE pages (
    id INT(11) NOT NULL AUTO_INCREMENT,
    subject_id INT(11),
    menu_name VARCHAR(255),
    position INT(3),
    visible TINYINT(1),
    content TEXT,
    PRIMARY KEY (id)
);

ALTER TABLE pages ADD INDEX fk_subject_id (subject_id);
````


````
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (1, 'Globe Bank', 1, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (1, 'History', 2, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (1, 'Leadership', 3, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (1, 'Contact', 4, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (2, 'Banking', 1, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (2, 'Credit Cards', 2, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (2, 'Morgages', 3, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (3, 'Checking', 1, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (3, 'Loans', 2, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (3, 'Merchant Services', 3, 1);
````

`SELECT * FROM pages WHERE id=3;`
`SELECT * FROM pages WHERE subject_id=2;`
---

### Create tables for globe_bank:

````
CREATE TABLE subjects (
    id INT(11) NOT NULL AUTO_INCREMENT,
    menu_name VARCHAR(255),
    position INT(3),
    visible TINYINT(1),
    PRIMARY KEY (id)
);
````
Next:  
`SHOW TABLES;`

Next:
`SHOW COLUMNS FROM subjects;`  

Next:
`INSERT INTO subjects (id, menu_name, position, visible) VALUES (1, 'About Globe Ban', 1,1);` 

Note: ID was automatically added because it was set to not null and auto increment 
`INSERT INTO subjects (menu_name, position, visible) VALUES ('Consumer', 2,1);`  
`INSERT INTO subjects (menu_name, position, visible) VALUES ('Small Business',3,1);`  
`INSERT INTO subjects (menu_name, position, visible) VALUES ('Junk',4,1);`  

Next:
`SELECT * FROM subjects;`

Examples:
`SELECT * FROM subjects WHERE id=2;`
`UPDATE subjects SET position=4 WHERE id=3;`
`DELETE FROM subjects WHERE id=4 LIMIT 1;`

---

### Commands:
Example: `GRANT ALL PRIVILEGES ON db_name.* TO 'user_name'@'localhost' IDENTIFIED BY 'password';`  
USED: `GRANT ALL PRIVILEGES ON globe_bank.* TO 'webuser'@'localhost' IDENTIFIED BY 'secretpassword';`  

`CREATE DATABASE globe_bank;`


### MySQL Commands:  
Show databases: `SHOW DATABASES;`  
Create database: `CREATE DATABASE db_name;`  
Use database: `USE DATABASE db_name;`  
Drop database: `DROP DATABASE db_name;`  
---

2019-02-01 11:40AM:
- I left off at Chapter 3 - Video 1 (Modify headers)
- I reset the output buffering

2019-01-31 10:13PM:
- I left off at Chapter 2 - Video 3 (Default values for URL parameters)


2019-01-31 8:08PM:
- I left off at Chapter 1 - Video 5