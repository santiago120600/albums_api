CREATE DATABASE IF NOT EXISTS apis;
USE apis;

CREATE TABLE tb_users(
    email_users VARCHAR(120) PRIMARY KEY,
    password_user VARCHAR(180) NOT NULL,
    fullname_user VARCHAR(160) NOT NULL,
    gender_user enum('F','M') NOT NULL,
    pic_user VARCHAR(200),
    phone_user VARCHAR(20) NOT NULL,
    status_user enum('Active','Inactive') NOT NULL DEFAULT 'Active',
    creation_user TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_user TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);