CREATE TABLE IF NOT EXISTS `mc_plugins_atos` (
  `idatos` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `merchandId` varchar(30) NOT NULL,
  `secureKey` varchar(50) NOT NULL,
  `accountType` enum('TEST','SIMU','PRODUCTION') NOT NULL,
  PRIMARY KEY (`idatos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_plugins_atos_paymentmeanbrand` (
  `idbrand` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `brand` varchar(30) NOT NULL,
  `status` smallint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idbrand`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_plugins_atos_paymentmeanbrand` (`idbrand`, `brand`, `status`) VALUES
(NULL, 'ACCEPTGIRO', 0),
(NULL, 'AMEX', 0),
(NULL, 'BCMC', 0),
(NULL, 'BUYSTER', 0),
(NULL, 'BANK CARD', 0),
(NULL, 'IDEAL', 0),
(NULL, 'INCASSO', 0),
(NULL, 'MAESTRO', 0),
(NULL, 'MASTERCARD', 0),
(NULL, 'MINITIX', 0),
(NULL, 'NETBANKING', 0),
(NULL, 'PAYPAL', 0),
(NULL, 'REFUND', 0),
(NULL, 'SDD', 0),
(NULL, 'SOFORT', 0),
(NULL, 'VISA', 0),
(NULL, 'VPAY', 0),
(NULL, 'VISA ELECTRON', 0),
(NULL, 'CBCONLINE', 0),
(NULL, 'KBCONLINE', 0);
