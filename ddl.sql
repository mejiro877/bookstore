-- ecsite_laravel.online_category definition

CREATE TABLE `online_category` (
  `CTGR_ID` int NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `LAST_UPD_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CTGR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- ecsite_laravel.online_member definition

CREATE TABLE `online_member` (
  `MEMBER_NO` int NOT NULL,
  `PASSWORD` varchar(8) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `AGE` int NOT NULL,
  `SEX` char(1) NOT NULL,
  `ZIP` varchar(8) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL,
  `TEL` varchar(20) NOT NULL,
  `REGISTER_DATE` date NOT NULL,
  `DELETE_FLG` char(1) NOT NULL DEFAULT '0',
  `LAST_UPD_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`MEMBER_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- ecsite_laravel.online_staff definition

CREATE TABLE `online_staff` (
  `STAFF_NO` int NOT NULL,
  `PASSWORD` varchar(8) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `AGE` int NOT NULL,
  `SEX` char(1) NOT NULL,
  `REGISTER_DATE` date NOT NULL,
  `LAST_UPD_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`STAFF_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- ecsite_laravel.online_order definition

CREATE TABLE `online_order` (
  `ORDER_NO` int NOT NULL AUTO_INCREMENT,
  `MEMBER_NO` int NOT NULL,
  `TOTAL_MONEY` bigint NOT NULL,
  `TOTAL_TAX` bigint NOT NULL,
  `ORDER_DATE` date NOT NULL,
  `COLLECT_NO` varchar(16) NOT NULL,
  `LAST_UPD_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ORDER_NO`),
  UNIQUE KEY `COLLECT_NO` (`COLLECT_NO`),
  KEY `MEMBER_NO` (`MEMBER_NO`),
  CONSTRAINT `online_order_ibfk_1` FOREIGN KEY (`MEMBER_NO`) REFERENCES `online_member` (`MEMBER_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- ecsite_laravel.online_product definition

CREATE TABLE `online_product` (
  `PRODUCT_CODE` varchar(14) NOT NULL,
  `CATEGORY_ID` int NOT NULL,
  `PRODUCT_NAME` varchar(50) NOT NULL,
  `MAKER` varchar(20) NOT NULL,
  `STOCK_COUNT` int NOT NULL,
  `REGISTER_DATE` date NOT NULL,
  `UNIT_PRICE` bigint NOT NULL,
  `PICTURE_NAME` varchar(100) DEFAULT NULL,
  `MEMO` varchar(255) DEFAULT NULL,
  `DELETE_FLG` char(1) NOT NULL DEFAULT '0',
  `LAST_UPD_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PRODUCT_CODE`),
  KEY `CATEGORY_ID` (`CATEGORY_ID`),
  CONSTRAINT `online_product_ibfk_1` FOREIGN KEY (`CATEGORY_ID`) REFERENCES `online_category` (`CTGR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- ecsite_laravel.online_order_list definition

CREATE TABLE `online_order_list` (
  `LIST_NO` int NOT NULL AUTO_INCREMENT,
  `COLLECT_NO` varchar(16) NOT NULL,
  `PRODUCT_CODE` varchar(14) NOT NULL,
  `ORDER_COUNT` int NOT NULL,
  `ORDER_PRICE` bigint NOT NULL,
  PRIMARY KEY (`LIST_NO`),
  KEY `PRODUCT_CODE` (`PRODUCT_CODE`),
  CONSTRAINT `online_order_list_ibfk_1` FOREIGN KEY (`PRODUCT_CODE`) REFERENCES `online_product` (`PRODUCT_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
