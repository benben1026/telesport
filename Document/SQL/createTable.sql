DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`(
	`userId` BIGINT NOT NULL AUTO_INCREMENT,
	`password` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`firstName` VARCHAR(255) ,
	`lastName` VARCHAR(255) ,
	`gender` TINYINT NOT NULL,
	`nationality` VARCHAR(100) ,
	`firstLanguage` VARCHAR(255) ,
	`secondLanguage` VARCHAR(255),
	`occupation` varchar (255),
	`phone` varchar (15),
	`birthday` DATE,
	`balance` DOUBLE NOT NULL DEFAULT 0,
	`rank` TINYINT NOT NULL,
	`regDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`userType` TINYINT NOT NULL,
	`address1` VARCHAR (255),
	`address2` VARCHAR (255),
	`address3` VARCHAR (255),
	`token` VARCHAR(255),
	`isVerified` BOOLEAN DEFAULT FALSE,
  	PRIMARY KEY (`userId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `trainer`;
CREATE TABLE `trainer`(
	`trainerId` BIGINT NOT NULL AUTO_INCREMENT,
	`userId` BIGINT NOT NULL,
	`selfIntro` TEXT,
	`expertise` TEXT,
	`height` VARCHAR (10),
	`weight` VARCHAR (10),
	`papers` TEXT ,
	`certificate` TEXT ,
	`passport_number` VARCHAR(255),
	`passport` varchar(255),
	PRIMARY KEY (`trainerId`),
	FOREIGN KEY(`userId`) REFERENCES `user`(`userId`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `trainee`;
CREATE TABLE `trainee`(
  	`traineeId` BIGINT NOT NULL AUTO_INCREMENT,
	`userId` BIGINT ,
	`bodyInfo` BIGINT,
	`couponId` BIGINT,
	`interest` TEXT,
	`height` VARCHAR (15) ,
	`weight` VARCHAR (15) ,
	`sleepStart` VARCHAR (5) ,
	`sleepEnd` VARCHAR (5)  ,
	`sportsTimePerDay` int ,
	`breakfast` VARCHAR (5)  ,
	`supper` VARCHAR (5) ,
	`ifSmoke` BOOLEAN  DEFAULT FALSE ,
	`ifDrink` BOOLEAN  DEFAULT FALSE ,
	`illness` VARCHAR (255),
	`illnessDescription` MEDIUMTEXT ,
	`ifMedicine` BOOLEAN DEFAULT FALSE ,
	`medicineDescription` MEDIUMTEXT ,
	`ifOperation` BOOLEAN  DEFAULT  FALSE,
	`operationDescription` MEDIUMTEXT ,
	`bodyStatus` VARCHAR (255),
	`gymTimeOneStart` VARCHAR (5) ,
	`gymTimeOneEnd` VARCHAR (5) ,
	`gymTimeTwoStart` VARCHAR(5),
	`gymTimeTwoEnd` VARCHAR (5),
	`ifGymRoom` BOOLEAN DEFAULT FALSE ,
	`toolDescription` MEDIUMTEXT,
	`aim` int ,
	`expectation` MEDIUMTEXT  DEFAULT "",
	PRIMARY KEY (`traineeId`),
	FOREIGN KEY(`userId`) REFERENCES `user`(`userId`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `complaint`;
CREATE TABLE `complaint`(
	`complaintId` BIGINT NOT NULL AUTO_INCREMENT,
	`trainerId` BIGINT NOT NULL,
	`traineeId` BIGINT NOT NULL,
	`reason` TEXT NOT NULL,
	`complaintDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`statusId` INT NOT NULL,
	PRIMARY KEY (`complaintId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `coupon`;
CREATE TABLE `coupon`(
	`couponId` BIGINT NOT NULL AUTO_INCREMENT,
	`value` DOUBLE NOT NULL,
	`userId` BIGINT NOT NULL,
	`fromDate` TIMESTAMP NOT NULL,
	`toDate` TIMESTAMP NOT NULL,
	`remark` TEXT,
	PRIMARY KEY (`couponId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `transation`;
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction`(
	`transactionId` BIGINT NOT NULL AUTO_INCREMENT,
	`typeId` TINYINT NOT NULL,
	`programId` BIGINT,
	`userId` BIGINT NOT NULL,
	`transactionDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`transactionId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP Table IF EXISTS `transactionType`;
DROP Table IF EXISTS `transationType`;
CREATE TABLE `transactionType`(
	typeId BIGINT NOT NULL,
	type VARCHAR(255)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `program`;
CREATE TABLE `program`(
	`programId` BIGINT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`introduction` TEXT NOT NULL,
	`prerequisite` TEXT,
	`userId` BIGINT NOT NULL,
	`goal` TEXT,
	`maxNumOfUser` INT NOT NULL,
	`duration` INT NOT NULL,
	`templates` TEXT DEFAULT "",
	`pricePlanId` BIGINT DEFAULT NULL,
	`isPublished` TINYINT NOT NULL DEFAULT 0,
	`publishDate` DATETIME,
	`lastModified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`programId`),
	FOREIGN KEY (`userId`) REFERENCES `user`(`userId`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `template`;
CREATE TABLE `template`(
	`templateId` BIGINT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`remark` TEXT,
	`lastModified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`numOfCom` TINYINT NOT NULL,
	`programId` BIGINT NOT NULL,
	`componentOrder` TEXT NOT NULL,
	`userId` BIGINT NOT NULL,
	PRIMARY KEY (`templateId`),
	FOREIGN KEY(`userId`) REFERENCES `user`(`userId`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `component`;
CREATE TABLE  `component`(
	`componentId` BIGINT NOT NULL AUTO_INCREMENT,
	`componentType` TINYINT NOT NULL,
	`templateId` BIGINT NOT NULL,
	PRIMARY KEY (`componentId`),
	FOREIGN KEY(`templateId`) REFERENCES `template`(`templateId`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `generalItem`;
CREATE TABLE `generalItem`(
	`itemId` BIGINT NOT NULL AUTO_INCREMENT,
	`componentId` BIGINT NOT NULL,
	`typeId` TINYINT NOT NULL,
	`content` TEXT NOT NULL,
	PRIMARY KEY (`itemId`),
	FOREIGN KEY(`componentId`) REFERENCES `component`(`componentId`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `generalItemType`;
CREATE TABLE `generalItemType`(
	`typeId` TINYINT NOT NULL,
	`typeName` VARCHAR(255),
	PRIMARY KEY(`typeId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `trainingItem`;
CREATE TABLE `trainingItem`(
	`itemId` BIGINT NOT NULL AUTO_INCREMENT,
	`componentId` BIGINT NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`numOfSet` INT NOT NULL,
	`numPerSet` INT NOT NULL,
	`finishTime` INT NOT NULL,
	`remark` TEXT,
	PRIMARY KEY (`itemId`),
	FOREIGN KEY(`componentId`) REFERENCES `component`(`componentId`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/** Table Message**/
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
       `messageId` BIGINT NOT NULL AUTO_INCREMENT,
       `content` TEXT NOT NULL,
       `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
       `fromUser` BIGINT NOT NULL,
       `toUser` BIGINT NOT NULL,
       `ifRead` TINYINT(1) NOT NULL DEFAULT 0 ,
       PRIMARY  KEY (`messageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `body`;

/** Table enroll **/
DROP TABLE IF EXISTS `enroll`;
CREATE TABLE `enroll`(
 `enrollId` BIGINT NOT NULL AUTO_INCREMENT,
 `statusId` TINYINT NOT NULL,
 `paymentCode` VARCHAR(255) NOT NULL,
 `program` BIGINT NOT NULL,
 `trainee` BIGINT NOT NULL,
 PRIMARY KEY (`enrollId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
/** Table body **/
DROP TABLE IF EXISTS `body`;
CREATE TABLE `body`(
 `bodyId` BIGINT NOT NULL AUTO_INCREMENT,
 `traineeId` BIGINT NOT NULL,
 `height` DOUBLE NOT NULL,
 `weight` DOUBLE NOT NULL,
 `others` TINYTEXT,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY(`bodyId`)

)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/** TABLE pricePlan**/
DROP TABLE IF EXISTS `pricePlan`;
CREATE TABLE `pricePlan`(
 `pricePlanId` BIGINT NOT NULL AUTO_INCREMENT,
 `price` DOUBLE NOT NULL DEFAULT 0,
 `fromDate` TIMESTAMP NOT NULL,
 `toDate` TIMESTAMP NOT NULL,
 PRIMARY KEY (`pricePlanId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
/**Table ci_sessions**/
CREATE TABLE IF NOT EXISTS  `ci_sessions` (
session_id varchar(40) DEFAULT '0' NOT NULL,
ip_address varchar(45) DEFAULT '0' NOT NULL,
user_agent varchar(120) NOT NULL,
last_activity int(10) unsigned DEFAULT 0 NOT NULL,
user_data text NOT NULL,
PRIMARY KEY (session_id),
KEY `last_activity_idx` (`last_activity`)
);

/**table constantResource**/
DROP TABLE IF EXISTS `constantResource`;
CREATE TABLE `constantResource`(
  `id` BIGINT NOT NULL AUTO_INCREMENT ,
  `type` VARCHAR (255) NOT NULL ,
  `index` VARCHAR (255) NOT NULL UNIQUE ,
  `sc` MEDIUMTEXT,
  `en` MEDIUMTEXT,
  `tc` MEDIUMTEXT,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
/**table customerResource**/
DROP TABLE IF EXISTS `customerResource`;
CREATE TABLE `customerResource`(
  `id` BIGINT NOT NULL AUTO_INCREMENT ,
  `type` VARCHAR (255) NOT NULL ,
  /*`index` VARCHAR (255) NOT NULL UNIQUE ,*/
  `sc` MEDIUMTEXT,
  `en` MEDIUMTEXT,
  `tc` MEDIUMTEXT,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE  `user` ADD  `username` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER  `userId` ,
ADD  `age` INT NOT NULL AFTER  `username` ;
