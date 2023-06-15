CREATE DATABASE IF NOT EXISTS nbp;

USE nbp;

CREATE TABLE IF NOT EXISTS currencies
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    code     VARCHAR(10)    NOT NULL,
    currency VARCHAR(255)   NOT NULL,
    rate     DECIMAL(10, 5) NOT NULL,
    UNIQUE (code)
);

CREATE TABLE IF NOT EXISTS conversions
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    from_currency VARCHAR(10)    NOT NULL,
    to_currency   VARCHAR(10)    NOT NULL,
    amount        DECIMAL(10, 2) NOT NULL,
    result        DECIMAL(10, 2) NOT NULL,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (from_currency) REFERENCES currencies (code),
    FOREIGN KEY (to_currency) REFERENCES currencies (code)
);
