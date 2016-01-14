-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3307
-- Généré le :  Mer 13 Janvier 2016 à 22:39
-- Version du serveur :  5.6.27-0ubuntu1
-- Version de PHP :  5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `atelier_garage`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `numero` int(11) NOT NULL,
  `nom` varchar(45) CHARACTER SET latin1 NOT NULL,
  `prenom` varchar(45) CHARACTER SET latin1 NOT NULL,
  `adresse` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `referent` varchar(45) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`numero`, `nom`, `prenom`, `adresse`, `referent`) VALUES
(1, 'a', 'a', 'Ecully', 'a'),
(2, 'b', 'b', 'b', 'b'),
(19, 'Chataign', 'Thib', 'Paris', 'Thib'),
(20, 'daho', 'Tb', 'Paris', 'daho'),
(12345, 'PERROT', 'thomas', 'paris', 'marc');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `voiture` varchar(10) CHARACTER SET latin1 NOT NULL,
  `technicien` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `texte` varchar(45) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`voiture`, `technicien`, `date`, `texte`) VALUES
('abc-789-38', 213456, '2016-01-13 17:21:32', 'bonjour'),
('abc-789-38', 213456, '2016-01-13 17:21:33', 'Cette voiture a l''air en salle Ã©tat'),
('abc-789-38', 213456, '2016-01-13 17:39:27', 'Cette voiture a l''air en salle Ã©tat'),
('abc-789-38', 213456, '2016-01-13 22:03:57', 'Cette voiture a l''air en salle Ã©tat'),
('xyz-789-38', 7, '2016-01-11 22:36:35', 'Cette voiture a l''air en salle Ã©tat'),
('xyz-789-38', 7, '2016-01-11 22:37:11', 'Cette voiture a l''air en salle Ã©tat'),
('xyz-789-38', 7, '2016-01-11 22:41:47', 'Cette voiture a l''air en salle Ã©tat'),
('xyz-789-38', 7, '2016-01-11 22:45:53', 'Cette voiture a l''air en salle Ã©tat'),
('xyz-789-38', 7, '2016-01-11 22:46:05', 'Cette voiture a l''air en salle Ã©tat'),
('xyz-789-38', 7, '2016-01-11 22:46:07', 'Cette voiture a l''air en salle Ã©tat'),
('xyz-789-38', 7, '2016-01-11 22:47:02', 'Cette voiture a l''air en salle Ã©tat'),
('xyz-789-38', 7, '2016-01-11 22:47:34', 'lol'),
('xyz-789-38', 7, '2016-01-11 22:48:17', 'lol'),
('xyz-789-38', 7, '2016-01-12 08:45:15', 'lol'),
('xyz-789-38', 7, '2016-01-12 11:09:07', 'lol'),
('xyz-789-38', 7, '2016-01-13 10:14:56', 'lol'),
('xyz-789-38', 7, '2016-01-13 15:40:11', 'lol'),
('xyz-789-38', 7, '2016-01-13 15:41:00', 'lol'),
('xyz-789-38', 7, '2016-01-13 15:41:03', 'lol');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
  `idFacture` int(11) NOT NULL,
  `prixTotal` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`idFacture`, `prixTotal`) VALUES
(3, 340),
(4, 190),
(5, 0);

-- --------------------------------------------------------

--
-- Structure de la table `facture_intervention`
--

CREATE TABLE IF NOT EXISTS `facture_intervention` (
  `idFacture` int(11) NOT NULL DEFAULT '0',
  `idIntervention` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `facture_intervention`
--

INSERT INTO `facture_intervention` (`idFacture`, `idIntervention`) VALUES
(3, 4),
(4, 11),
(3, 14);

--
-- Déclencheurs `facture_intervention`
--
DELIMITER $$
CREATE TRIGGER `facture_intervention_AFTER_DELETE` AFTER DELETE ON `facture_intervention`
 FOR EACH ROW BEGIN
	UPDATE `atelier_garage`.`facture`
    SET prixTotal =
		(SELECT SUM(`prix`)
		FROM `facture_intervention` INNER JOIN `intervention`
        ON `facture_intervention`.`idIntervention` = `intervention`.`id`
        WHERE `facture_intervention`.`idFacture` = OLD.`idFacture`
        )
	WHERE `facture`.`idFacture` = OLD.`idFacture`;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `facture_intervention_AFTER_INSERT` AFTER INSERT ON `facture_intervention`
 FOR EACH ROW BEGIN
	UPDATE `atelier_garage`.`facture`
    SET prixTotal =
		(SELECT SUM(`prix`)
		FROM `facture_intervention` INNER JOIN `intervention`
        ON `facture_intervention`.`idIntervention` = `intervention`.`id`
        WHERE `facture_intervention`.`idFacture` = NEW.`idFacture`
        )
	WHERE `facture`.`idFacture` = NEW.`idFacture`;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `facture_intervention_AFTER_UPDATE` AFTER UPDATE ON `facture_intervention`
 FOR EACH ROW BEGIN
	UPDATE `atelier_garage`.`facture`
    SET prixTotal =
		(SELECT SUM(`prix`)
		FROM `facture_intervention` INNER JOIN `intervention`
        ON `facture_intervention`.`idIntervention` = `intervention`.`id`
        WHERE `facture_intervention`.`idFacture` = NEW.`idFacture`
        )
	WHERE `facture`.`idFacture` = NEW.`idFacture`;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE IF NOT EXISTS `intervention` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) CHARACTER SET latin1 NOT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `intervention`
--

INSERT INTO `intervention` (`id`, `nom`, `prix`) VALUES
(3, 'changeFrein', 100),
(4, 'changeDisques', 150),
(10, 'RÃ©paration du moteur', 170),
(11, 'lol', 190),
(12, 'Changement des pneus', 190),
(13, 'Changement des pneus', 190),
(14, 'Changement des pneus', 190),
(15, 'Changement des pneus', 190),
(16, 'Changement des pneus', 190),
(17, 'Changement des pneus', 190),
(18, 'Changement des pneus', 190),
(19, 'Changement des pneus', 190),
(20, 'Changement des pneus', 190),
(21, 'Changement des pneus', 190),
(22, 'Changement des pneus', 190),
(23, 'Changement des pneus', 190),
(24, 'Changement des pneus', 190),
(26, 'Changement des pneus', 190);

-- --------------------------------------------------------

--
-- Structure de la table `repare`
--

CREATE TABLE IF NOT EXISTS `repare` (
  `technicien` int(11) NOT NULL,
  `voiture` varchar(10) CHARACTER SET latin1 NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date DEFAULT NULL,
  `idFacture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `repare`
--

INSERT INTO `repare` (`technicien`, `voiture`, `dateDebut`, `dateFin`, `idFacture`) VALUES
(7, '123-456', '0000-00-00', NULL, 3),
(213456, 'abc', '2016-01-14', NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `technicien`
--

CREATE TABLE IF NOT EXISTS `technicien` (
  `numero` int(11) NOT NULL,
  `nom` varchar(25) CHARACTER SET latin1 NOT NULL,
  `prenom` varchar(25) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `technicien`
--

INSERT INTO `technicien` (`numero`, `nom`, `prenom`) VALUES
(7, 'daho', 'thomas'),
(213456, 'lol', 'cecile');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL,
  `Pseudo` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `Pass` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `Privileges` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `Pseudo`, `Pass`, `Privileges`) VALUES
(1, 'thib', '428c7871dd6adbdc20a11fdac0dfe6a015f06403', 2);

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE IF NOT EXISTS `voiture` (
  `immatriculation` varchar(10) CHARACTER SET latin1 NOT NULL,
  `marque` varchar(25) CHARACTER SET latin1 NOT NULL,
  `type` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `kilometrage` varchar(45) CHARACTER SET latin1 NOT NULL,
  `date_arrivee` date DEFAULT NULL,
  `proprietaire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `voiture`
--

INSERT INTO `voiture` (`immatriculation`, `marque`, `type`, `annee`, `kilometrage`, `date_arrivee`, `proprietaire`) VALUES
('123-456', 'renau', 'ancien', 1500, '1990', '2016-01-01', 20),
('abc', 'ford', 'sport', 1972, '18000', '0000-00-00', 19),
('abc-789-38', 'peugeot', 'sport', 1993, '120000', '0000-00-00', 1),
('def-789-38', 'peugeot', 'sport', 1993, '120000', '0000-00-00', 1),
('gki-789-38', 'peugeot', 'sport', 1993, '120000', '2016-01-11', 1),
('xyz-789-38', 'peugeot', 'sport', 1993, '120000', '0000-00-00', 19);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `client-commune_idx` (`adresse`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`voiture`,`technicien`,`date`),
  ADD KEY `commente-technicien_idx` (`technicien`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`idFacture`);

--
-- Index pour la table `facture_intervention`
--
ALTER TABLE `facture_intervention`
  ADD PRIMARY KEY (`idIntervention`,`idFacture`),
  ADD KEY `ri_intervention_idx` (`idIntervention`),
  ADD KEY `ri_repare_idx` (`idFacture`);

--
-- Index pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `repare`
--
ALTER TABLE `repare`
  ADD PRIMARY KEY (`technicien`,`voiture`,`dateDebut`),
  ADD KEY `repare_voiture_idx` (`voiture`),
  ADD KEY `repare_technicien_idx` (`technicien`),
  ADD KEY `repare_facture_idx` (`idFacture`);

--
-- Index pour la table `technicien`
--
ALTER TABLE `technicien`
  ADD PRIMARY KEY (`numero`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`immatriculation`),
  ADD KEY `voiture-client_idx` (`proprietaire`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `idFacture` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `intervention`
--
ALTER TABLE `intervention`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commente-technicien` FOREIGN KEY (`technicien`) REFERENCES `technicien` (`numero`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `commente-voiture` FOREIGN KEY (`voiture`) REFERENCES `voiture` (`immatriculation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `facture_intervention`
--
ALTER TABLE `facture_intervention`
  ADD CONSTRAINT `fi_facture` FOREIGN KEY (`idFacture`) REFERENCES `facture` (`idFacture`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fi_intervention` FOREIGN KEY (`idIntervention`) REFERENCES `intervention` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `repare`
--
ALTER TABLE `repare`
  ADD CONSTRAINT `repare_facture` FOREIGN KEY (`idFacture`) REFERENCES `facture` (`idFacture`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `repare_technicien` FOREIGN KEY (`technicien`) REFERENCES `technicien` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `repare_voiture` FOREIGN KEY (`voiture`) REFERENCES `voiture` (`immatriculation`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture-client` FOREIGN KEY (`proprietaire`) REFERENCES `client` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
