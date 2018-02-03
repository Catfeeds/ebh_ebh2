ALTER TABLE ebh_integralrules RENAME TO ebh_creditrules;
ALTER TABLE ebh_creditrules CHANGE integral credit int (11);

INSERT INTO `ebh_creditrules` (`ruleid`, `rulename`, `action`, `credit`, `actiontype`, `maxaction`) VALUES (16, '积分兑换', '-', 0, 0, 0);