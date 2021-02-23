CREATE DATABASE IF NOT EXISTS symfony_master;
USE symfony_master;

CREATE TABLE IF NOT EXISTS users(
    id              int(255) auto_increment not null,
    role            varchar(50),
    name            varchar(100),
    surname         varchar(200),
    email           varchar(255), 
    password        varchar(255),
    created_at      datetime,

    CONSTRAINT pk_users PRIMARY KEY(id)


)ENGINE=InnoDb;



insert into users values(null,'ROLE_USER','David','Barco','carlos@carlos.com','password',curtime());
insert into users values(null,'ROLE_USER','Juan','Barco','carlos1@carlos.com','password',curtime());
insert into users values(null,'ROLE_USER','Carlos','Barco','carlos2@carlos.com','password',curtime());


CREATE TABLE IF NOT EXISTS tasks(
    id              int(255) auto_increment not null,
    user_id         int(255) not null,
    title           varchar(255),
    content         text,
    priority        varchar(20),
    hours           int(100),
    created_at      datetime,

    CONSTRAINT pk_tasks PRIMARY KEY(id),
    CONSTRAINT fk_task_user FOREIGN KEY(user_id) REFERENCES users(id)


)ENGINE=InnoDb;


insert into tasks values(null,1,'tarea 1','esta es mi primer tarea','high',40,curtime());
insert into tasks values(null,1,'tarea 2','esta es mi segunda tarea','low',20,curtime());
insert into tasks values(null,1,'tarea 3','esta es mi tercera tarea','medium',10,curtime());
insert into tasks values(null,1,'tarea 4','esta es mi cuarta tarea','high',50,curtime());
insert into tasks values(null,2,'tarea 5','esta es mi quinta tarea','high',50,curtime());