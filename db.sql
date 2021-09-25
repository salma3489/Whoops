CREATE DATABASE Whoops!;

CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    Username varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    confirm varchar(255) NOT NULL,
    age INT(11) NOT NULL,
    gender INT(11) NOT NULL,
    img varchar(255) NOT NULL,
    created_at datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (id)
);

CREATE TABLE questions (
    Quest_id INT(11) NOT NULL AUTO_INCREMENT,
    Title varchar(255) NOT NULL,
    created_at datetime NOT NULL DEFAULT current_timestamp(),
    QuestDetails varchar(255) NOT NULL,
    user_id INT(11) NOT NULL,
    PRIMARY KEY (Quest_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE ans (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    ansDetails varchar(255) NOT NULL,
    created_at datetime NOT NULL DEFAULT current_timestamp(),
    user_id INT(11) NOT NULL,
    Q_ID INT(11) NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (Q_ID) REFERENCES questions(Quest_id)
);

CREATE TABLE votes (
    vote_id INT(11) NOT NULL AUTO_INCREMENT,
    vote_up ENUM('1', '0') DEFAULT '0' NOT NULL,
    vote_down ENUM('1', '0') DEFAULT '0' NOT NULL,
    ans_id INT(11) NOT NULL,
    PRIMARY KEY (vote_id),
    FOREIGN KEY (ans_id) REFERENCES ans(ID)
);


INSERT INTO `users` (`Username`, `email`, `password`, `confirm`, `age`, `gender`, `img`) VALUES ('Khaled', 'Khaled@gmail.com', '$2y$10$FVqtfvBpTwzYvppZjYDEFeqUQce6piITd2mzycXzM5/DiSOi43nGa', '$2y$10$mvMk6YnXsOrIAXIu5nNgYeoHtgiYAfd9iRulw7rO37R8sLwwAOq36', 40, 'Male', 'action.png');
INSERT INTO `questions` (`Title`, `QuestDetails`, `user_id`) VALUES ('What do I need to do to import a word doc from a form in pdf to an api','I am trying to upload a file (word doc and pdf) via a straightforward form in pdf. I can now upload the file ok... but it cannot be opened when imported presumably because it is not encrypted. Do you have any ideas what I can do to fix this?', 1);
INSERT INTO `ans` (`ansDetails`, `user_id`, `Q_ID`) VALUES ('content answer al question', 1, 1);
INSERT INTO `votes` (`vote_up`, `vote_down`, `ans_id`) VALUES (1, 0, 1), (0, 1, 1);