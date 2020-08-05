# Restful Task List
Simple Task List utilizing REST HTTP requests.


## Features
- *Php*
- *Mysql*
- *Bootstrap*
- *jQuery*

## Installation

Create a database and user:
```
DB: task_list
User: task_admin
Pass: letmein
```
```mysql
CREATE DATABASE task_list;
CREATE USER 'task_admin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'letmein';
GRANT ALL PRIVILEGES ON task_list.* TO 'task_admin'@'localhost';
```
Or update the DB file (`./app/Config/DB.php`) with your preferred credentials.

Run the following sql. Includes a few starter tasks.
```mysql
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(255) NOT NULL,
  `duedate` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`task`,`duedate`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

INSERT INTO `tasks` (`id`, `task`, `duedate`, `created`) VALUES
(3, 'Clean The Cars', '2020-08-12 00:00:00', '2020-08-05 06:39:22'),
(28, 'Wash The Dogs', '2020-08-19 00:00:00', '2020-08-05 06:44:49'),
(29, 'Wash Cloths', '2020-08-06 00:00:00', '2020-08-05 08:21:10'),
(32, 'Clean Up Office', '2020-08-20 00:00:00', '2020-08-05 06:17:16'),
(36, 'Exercise..', '2020-08-06 00:00:00', '2020-08-05 08:36:01'),
(38, 'Bake A Cake.... wait wut?', '2020-08-13 00:00:00', '2020-08-05 10:49:23');
COMMIT;
```

## Todo
- Update test classes
- Use VueJs
- Add stats and alerts
- Switch task to be time based and not date
- Color code task by time remaining


## Contributing
Pull requests are welcome if you would like to use it. Not planning on making any major changes besides the ones mentioned above.