DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`(
	`userId` BIGINT NOT NULL AUTO_INCREMENT,
	`password` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`firstName` VARCHAR(255) NOT NULL,
	`lastName` VARCHAR(255) NOT NULL,
	`gender` TINYINT NOT NULL,
	`nationality` VARCHAR(100) NOT NULL,
	`firstLanguage` VARCHAR(255) NOT NULL,
	`secondLanguage` VARCHAR(255),
	`birthday` DATE NOT NULL,
	`balance` DOUBLE NOT NULL,
	`rank` TINYINT NOT NULL,
	`regDate` DATE NOT NULL,
	`userType` TINYINT NOT NULL,
	`token` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`userId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `trainer`;
CREATE TABLE `trainer`(
	`userId` BIGINT NOT NULL,
	`selfIntro` TEXT,
	`expertise` TEXT,
	PRIMARY KEY (`userId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `trainee`;
CREATE TABLE `trainee`(
	`userId` BIGINT NOT NULL,
	`bodyInfo` BIGINT,
	`couponId` BIGINT,
	`interest` TEXT,
	PRIMARY KEY (`userId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `complaint`;
CREATE TABLE `complaint`(
	`complaintId` BIGINT NOT NULL AUTO_INCREMENT,
	`trainerId` BIGINT NOT NULL,
	`traineeId` BIGINT NOT NULL,
	`reason` TEXT NOT NULL,
	`complaintDate` DATE,
	`statusId` INT NOT NULL,
	PRIMARY KEY (`complaintId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `coupon`;
CREATE TABLE `coupon`(
	`couponId` BIGINT NOT NULL AUTO_INCREMENT,
	`value` DOUBLE NOT NULL,
	`userId` BIGINT NOT NULL,
	`fromDate` DATE NOT NULL,
	`toDate` DATE NOT NULL,
	`remark` TEXT,
	PRIMARY KEY (`couponId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `transation`;
CREATE TABLE `transation`(
	`transationId` BIGINT NOT NULL AUTO_INCREMENT,
	`typeId` TINYINT NOT NULL,
	`programId` BIGINT,
	`userId` BIGINT NOT NULL,
	`transationDate` DATE NOT NULL,
	PRIMARY KEY (`transationId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP Table IF EXISTS `transationType`;
CREATE TABLE `transationType`(
	typeId BIGINT NOT NULL,
	type VARCHAR(255)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `program`;
CREATE TABLE `program`(
	`programId` BIGINT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`introduction` TEXT NOT NULL,
	`prerequest` TEXT,
	`goal` TEXT,
	`numOfUser` INT NOT NULL,
	`maxNum` INT NOT NULL,
	`duration` INT NOT NULL,
	`templates` TEXT NOT NULL,
	`pricePlanId` BIGINT NOT NULL,
	PRIMARY KEY (`programId`)
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
	PRIMARY KEY (`templateId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `component`;
CREATE TABLE  `component`(
	`componentId` BIGINT NOT NULL AUTO_INCREMENT,
	`componentType` TINYINT NOT NULL,
	`subclassId` BIGINT NOT NULL,
	PRIMARY KEY (`componentId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `generalItem`;
CREATE TABLE `generalItem`(
	`itemId` BIGINT NOT NULL AUTO_INCREMENT,
	`typeId` TINYINT NOT NULL,
	`content` TEXT NOT NULL,
	PRIMARY KEY (`itemId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `trainingItem`;
CREATE TABLE `trainingItem`(
	`itemId` BIGINT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`numOfSet` INT NOT NULL,
	`numPerSet` INT NOT NULL,
	`finishTime` INT NOT NULL,
	`remark` TEXT,
	PRIMARY KEY (`itemId`)
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