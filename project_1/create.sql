create table Movie(id int primary key, title varchar(100), year int, rating varchar(10), company varchar(50));
create table Actor(id int primary key, last varchar(20), first varchar(20), sex varchar(6), dob date, dod date);
create table Director(id int primary key, last varchar(20), first varchar(20), dob date, dod date);
create table MovieGenre(mid int, genre varchar(20));
create table MovieDirector(mid int, did int);
create table MovieActor(mid int, aid int, role varchar(50));
create table Review(name varchar(20), time datetime, mid int, rating int, comment text);
