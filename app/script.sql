use u510499444_reservation;
-- Listage de la structure de la table user. agents
CREATE TABLE IF NOT EXISTS `agents` (
                                        `id` int NOT NULL AUTO_INCREMENT,
                                        `nom` varchar(255) NOT NULL,
    `email` varchar(100) NOT NULL,
    `tel` varchar(25) NOT NULL,
    `post` varchar(75) NOT NULL,
    `sex` varchar(10) NOT NULL,
    `remember_token` varchar(255) DEFAULT NULL,
    `updated_at` varchar(255) DEFAULT NULL,
    `password` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB   CHARSET=UTF8MB4 ;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table user. autorisation
CREATE TABLE IF NOT EXISTS `autorisation` (
                                              `id` int NOT NULL AUTO_INCREMENT,
                                              `date_debut` varchar(25) NOT NULL,
    `date_fin` varchar(25) NOT NULL,
    `raison_abs` varchar(1000) NOT NULL,
    `id_agent` int NOT NULL DEFAULT '0',
    `statut` int DEFAULT '0',
    `mot_retour` varchar(1000) DEFAULT 'Aucune réponse' COMMENT '0  = pas encore vue , 1 = accordé, 2 = rejeté',
    `compensation` varchar(1000) DEFAULT NULL,
    `date_demande` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_autorisation_agent` (`id_agent`),
    CONSTRAINT `FK_autorisation_agent` FOREIGN KEY (`id_agent`) REFERENCES `agents` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB   CHARSET=utf8mb4 ;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table user. demande
CREATE TABLE IF NOT EXISTS `demande` (
                                         `id` int NOT NULL AUTO_INCREMENT,
                                         `data` json NOT NULL,
                                         `statut` int DEFAULT '0',
                                         `mot_retour` varchar(1000) DEFAULT 'Aucune réponse',
    `id_agent` int NOT NULL,
    `date` varchar(50) NOT NULL,
    `cause` varchar(1000) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_demande_fond_agent` (`id_agent`),
    CONSTRAINT `FK_demande_fond_agent` FOREIGN KEY (`id_agent`) REFERENCES `agents` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB   CHARSET=utf8mb4 ;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table user. users
CREATE TABLE IF NOT EXISTS `users` (
                                       `id` int NOT NULL AUTO_INCREMENT,
                                       `name` varchar(50) NOT NULL,
    `nom` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `tel` varchar(25) NOT NULL,
    `post` varchar(75) NOT NULL,
    `sex` varchar(10) NOT NULL,
    `password` varchar(255) NOT NULL,
    `updated_at` varchar(50) NOT NULL,
    `remember_token` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB   CHARSET=utf8mb4 ;

