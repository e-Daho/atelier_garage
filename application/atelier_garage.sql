-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3307
-- Généré le :  Jeu 14 Janvier 2016 à 22:10
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
  `referent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`numero`, `nom`, `prenom`, `adresse`, `referent`) VALUES
(1, 'PERROT', 'Thomas', 'Paris', 3),
(2, 'CHATAIGNER', 'Thibault', 'Ecully', 3);

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
(3, 320),
(4, 170),
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
(3, 27),
(3, 28),
(4, 28);

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `intervention`
--

INSERT INTO `intervention` (`id`, `nom`, `prix`) VALUES
(27, 'pneu', 150),
(28, 'freins', 170);

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
(4, 'abc-123-38', '2016-01-08', NULL, 3);

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
(4, 'JACQUELIN', 'Augustin');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL,
  `Pseudo` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `Pass` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `Privileges` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `Pseudo`, `Pass`, `Privileges`) VALUES
(2, 'thib', '428c7871dd6adbdc20a11fdac0dfe6a015f06403', 3),
(3, 'daho', '403926033d001b5279df37cbbe5287b7c7c267fa', 2),
(4, 'gus', '22b4468ae6dcf46c36c9622e292c7a3506bb0db4', 1),
(5, 'nala', 'ada41ed3cb167a74ff219441faec9e94c2142e95', 0);

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
('abc-123-38', 'peugeot', 'sport', 1993, '150000', '2016-01-01', 1),
('def-456-38', 'renault', 'sport', 2002, '100000', '2016-01-04', 2);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `client-commune_idx` (`adresse`),
  ADD KEY `referent` (`referent`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_utilisateurs` FOREIGN KEY (`referent`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commente-technicien` FOREIGN KEY (`technicien`) REFERENCES `technicien` (`numero`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `repare_facture` FOREIGN KEY (`idFacture`) REFERENCES `facture` (`idFacture`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `repare_technicien` FOREIGN KEY (`technicien`) REFERENCES `technicien` (`numero`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `repare_voiture` FOREIGN KEY (`voiture`) REFERENCES `voiture` (`immatriculation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `technicien`
--
ALTER TABLE `technicien`
  ADD CONSTRAINT `technicien_utilisateurs` FOREIGN KEY (`numero`) REFERENCES `utilisateurs` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture-client` FOREIGN KEY (`proprietaire`) REFERENCES `client` (`numero`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
