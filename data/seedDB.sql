DROP DATABASE IF EXISTS `seedDB`;

CREATE DATABASE `seedDB`;

USE seedDB;

CREATE TABLE families(
    family_id int NOT NULL AUTO_INCREMENT,
    family_name varchar(255) NOT NULL,
    CONSTRAINT pk_families PRIMARY KEY (family_id)
);

CREATE TABLE seeds (
    seed_id int NOT NULL AUTO_INCREMENT,
    seed_name varchar(255) NOT NULL,
    family_id int NOT NULL,
    planting_period_min tinyint DEFAULT 0,
    planting_period_max tinyint DEFAULT 12,
    harvest_period_min tinyint DEFAULT 0,
    harvest_period_max tinyint DEFAULT 12,
    advices varchar(255),
    image varchar(255),
    quantity int DEFAULT 0,
    CONSTRAINT pk_seeds PRIMARY KEY (seed_id),
    CONSTRAINT fk_seeds_family_id FOREIGN KEY (family_id) REFERENCES families(family_id),
    CONSTRAINT check_periods CHECK (
        planting_period_min > 0
        AND planting_period_min <= 12
        AND planting_period_max > 0
        AND planting_period_max <= 12
        AND harvest_period_min > 0
        AND harvest_period_min <= 12
        AND harvest_period_max > 0
        AND harvest_period_max <= 12
    ),
    CONSTRAINT check_quantity CHECK (quantity >= 0)
);

CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    PASSWORD varchar(255) NOT NULL,
    salt varchar(255) NOT NULL,
    CONSTRAINT pk_users PRIMARY KEY (id)
);

INSERT INTO
    families (family_name)
VALUES
    ('Asteracées'),
    ('Brassicacées'),
    ('Chénopodiacées'),
    ('Cucurbitacées'),
    ('Lamiacées'),
    ('Légumineuses'),
    ('Ombellifères'),
    ('Solanacées');

INSERT INTO
    `users` (`id`, `username`, `password`, `salt`)
VALUES
    (
        1,
        'admin',
        '$2y$10$0qI9C5.7b64gSPyzh2rbqurjBiOBDJHG.MjQGrjIbeFHSCYiPySHK',
        '89cdb4f0b432249d5085493ffeed6ed8bc4a0d2c116ccb655b454759933fc474'
    );

INSERT INTO
    seeds (
        seed_name,
        family_id,
        planting_period_min,
        planting_period_max,
        harvest_period_min,
        harvest_period_max,
        advices,
        image,
        quantity
    )
VALUES
    (
        'Ail',
        3,
        9,
        10,
        6,
        7,
        'Plantez les gousses à 2 cm de profondeur, pointe vers le haut, en espaçant les gousses de 10 cm. Récoltez les gousses lorsque les feuilles sont jaunes.',
        'ail.jpg',
        0
    );

INSERT INTO
    seeds (
        seed_name,
        family_id,
        planting_period_min,
        planting_period_max,
        harvest_period_min,
        harvest_period_max,
        advices,
        image,
        quantity
    )
VALUES
    (
        'Aubergine',
        4,
        3,
        5,
        8,
        10,
        'Semez les graines à 1 cm de profondeur, en espaçant les graines de 10 cm. Récoltez les aubergines lorsqu\'elles sont bien colorées.',
        'aubergine.jpg',
        0
    );

INSERT INTO
    seeds (
        seed_name,
        family_id,
        planting_period_min,
        planting_period_max,
        harvest_period_min,
        harvest_period_max,
        advices,
        image,
        quantity
    )
VALUES
    (
        'Basilic',
        5,
        4,
        6,
        7,
        9,
        'Semez les graines à 1 cm de profondeur, en espaçant les graines de 10 cm. Récoltez les feuilles au fur et à mesure de vos besoins.',
        'basilic.jpg',
        0
    );