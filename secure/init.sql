-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

CREATE TABLE members (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    position TEXT NOT NULL,
    bio TEXT,
    funfact TEXT
);

INSERT INTO members (id, first_name, last_name, position, bio, funfact) VALUES (1, "Jazlyn", "Zhang", "artist", "A current highschool student interested in visual arts", "I'm tired");
INSERT INTO members (id, first_name, last_name, position, bio, funfact) VALUES (2, "Emily", "Barr", "artist","college freshman", "never seen snow");
INSERT INTO members (id, first_name, last_name, position, bio, funfact) VALUES (3, "Nancy", "Niu", "artist", "college freshman", "two dogs");


CREATE TABLE artworks (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    file_name TEXT NOT NULL,
    file_ext TEXT NOT NULL,
    title TEXT NOT NULL,
    liked INTEGER,
    member_id INTEGER
);

INSERT INTO artworks (id, file_name, file_ext, title, liked, member_id) VALUES (1,"1.jpg","jpg" ,"infinity",1 , 1);
INSERT INTO artworks (id, file_name, file_ext, title, liked, member_id) VALUES (2,"2.jpg","jpg", "sharp", 2, 2);
INSERT INTO artworks (id, file_name, file_ext, title, liked, member_id) VALUES (3,"3.jpg","jpg", "structure", 1, 1);
INSERT INTO artworks (id, file_name, file_ext, title, liked,member_id) VALUES (4,"4.jpg","jpg", "bowls", 1,  3);
INSERT INTO artworks (id, file_name, file_ext, title, liked, member_id) VALUES (5,"5.jpg","jpg", "Castle", 2, 3);

CREATE TABLE tags (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    artwork_id TEXT NOT NULL,
    tag TEXT NOT NULL
);
Insert INTO tags(id, artwork_id, tag) VALUES (1,1,'wood');
Insert INTO tags(id, artwork_id, tag) VALUES (2,2,'architecture');
Insert INTO tags(id, artwork_id, tag) VALUES (3,3,'photography');
Insert INTO tags(id, artwork_id, tag) VALUES (4,4,'plastic');
Insert INTO tags(id, artwork_id, tag) VALUES (5,5,'paper');

CREATE TABLE auctions (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    artwork_id INTEGER NOT NULL,
    availability BOOLEAN NOT NULL,
    estimatedValue INTEGER NOT NULL
);
INSERT INTO auctions (id, artwork_id, availability, estimatedValue) VALUES (1,1, TRUE,102);
INSERT INTO auctions (id, artwork_id, availability, estimatedValue) VALUES (2,2, TRUE,100);
INSERT INTO auctions (id, artwork_id, availability, estimatedValue) VALUES (3,3, FALSE, 110);
INSERT INTO auctions (id, artwork_id, availability, estimatedValue) VALUES (4,4, TRUE,15);
INSERT INTO auctions (id, artwork_id, availability, estimatedValue) VALUES (5,5, TRUE,150);

COMMIT;
