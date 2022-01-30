CREATE TABLE IF NOT EXISTS `y_addresses` (
    `AddressId` int(11) NOT NULL AUTO_INCREMENT,
    `TITLE` varchar(255) NOT NULL,
    `DESCRIPTION` varchar(255) NOT NULL,
    `COUNTRY` varchar(255) NOT NULL,
    PRIMARY KEY(`AddressId`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `y_emails` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `NAME` varchar(255) NOT NULL,
    `EMAIL` varchar(255) NOT NULL,
    `ADDRESS` int(11) NOT NULL ,
    FOREIGN KEY (`ADDRESS`) REFERENCES `y_addresses` (`AddressId`),
    PRIMARY KEY(`ID`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;