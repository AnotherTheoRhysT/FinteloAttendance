CREATE TABLE assignment(
    `id` INT AUTO_INCREMENT NOT NULL,
    `assignment_name` VARCHAR(50) NOT NULL,
    `desc` MEDIUMTEXT,
    `file_dir` VARCHAR(50) NOT NULL,
    `date_created` TIMESTAMP,
    `date_submitted` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `student_id` INT NOT NULL,
    `activity_id` INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (student_id) REFERENCES student(id),
    FOREIGN KEY (activity_id) REFERENCES activity(id)
);

INSERT INTO assignment (`assignment_name`, `file_dir`, `student_id`, `activity_id`)
VALUES ('HTML', '/assignments/carmelhtml/', 1, 1),
	('HTML', '/assignments/johnpaulhtml/', 2, 1),
	('HTML', '/assignments/jonmelhtml/', 3, 1),
	('HTML', '/assignments/katehtml/', 4, 1),
	('HTML', '/assignments/katrinalhtml/', 5, 1),
	('CSS', '/assignments/carmelcss/', 1, 2),
	('CSS', '/assignments/johnpaulcss/', 2, 2),
	('CSS', '/assignments/jonmelcss/', 3, 2),
	('CSS', '/assignments/katecss/', 4, 2),
	('CSS', '/assignments/katrinalcss/', 5, 2);




CREATE TABLE student(
    id INT AUTO_INCREMENT NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    middle_name VARCHAR(50),
    sex CHAR(1),
    group_number INT NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO student(first_name, last_name, sex, group_number) 
VALUES ('Carmel', 'Mende', 'F', 2),
	('John Paul', 'Reambonanza', 'M', 2),
	('Jon Mel', 'Marquez', 'M', 1),
	('Kate', 'Abatayo', 'F', 1),
	('Katrina', 'Hisoler', 'F', 1);



CREATE TABLE activity( 
    `id` INT AUTO_INCREMENT NOT NULL, 
    `date` TIMESTAMP NOT NULL, 
    `desc` MEDIUMTEXT, 
    `activity_title` VARCHAR(50) NOT NULL, 
    PRIMARY KEY(id) 
);



