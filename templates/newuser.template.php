SELECT `id`,`date_start`,`date_end` FROM `event`WHERE `room_id` = 1 AND((`date_start` BETWEEN '1388538120' AND "1388538180")OR (`date_end` BETWEEN '1388538120' AND "1388538180")OR (`date_start`< '1388538120' AND `date_end`>'1388538120')OR (`date_start`< "1388538180" AND `date_end`>"1388538180"))



INSERT INTO `event`(`id`, `user_id`, `description`, `room_id`, `date_end`, `date_start`) VALUES (1,'[value-3]',1,1388538120,1388538120)