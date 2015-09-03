CREATE SCHEMA uran_test;

CREATE TABLE category
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    subcategory INT DEFAULT 0
);
CREATE TABLE entry
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    body LONGTEXT NOT NULL,
    category INT NOT NULL
);
CREATE TABLE entry_tag
(
    tag_id INT NOT NULL,
    entry_id INT NOT NULL
);
CREATE TABLE tag
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    text VARCHAR(45)
);
ALTER TABLE entry ADD FOREIGN KEY (category) REFERENCES category (id) ON DELETE CASCADE;
ALTER TABLE entry_tag ADD FOREIGN KEY (entry_id) REFERENCES entry (id) ON DELETE CASCADE;
CREATE UNIQUE INDEX tag_id_entry_id_index ON entry_tag (tag_id, entry_id);
CREATE UNIQUE INDEX unique_name ON tag (text);
