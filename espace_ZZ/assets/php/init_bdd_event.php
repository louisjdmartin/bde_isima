<?php
	ini_set("display_errors", "1");
	require "../../../api/api.php";
	$bdd->query("
	-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 02 Novembre 2017 à 19:19
-- Version du serveur: 5.5.40
-- Version de PHP: 5.4.36-0+deb7u1

SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";

--
-- Base de données: `bdd_bde`
--

-- --------------------------------------------------------

--
-- Structure de la table `evt_articles`
--

CREATE TABLE IF NOT EXISTS `evt_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) NOT NULL,
  `prix` double(5,2) NOT NULL,
  `id_club` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Structure de la table `evt_commandes`
--

CREATE TABLE IF NOT EXISTS `evt_commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `nom_membre` varchar(50) NOT NULL,
  `id_article` int(11) NOT NULL,
  `paiement` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `qte_paye` int(11) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Structure de la table `evt_evenements`
--

CREATE TABLE IF NOT EXISTS `evt_evenements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) NOT NULL,
  `id_club` int(11) NOT NULL,
  `nb_places_max` int(11) NOT NULL,
  `carte_bde_possible` tinyint(1) NOT NULL,
  `date_limite_commande` datetime NOT NULL,
  `date_event` datetime NOT NULL,
  `total_gain_carte` float(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Structure de la table `evt_listearticles`
--

CREATE TABLE IF NOT EXISTS `evt_listearticles` (
  `id_event` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `qte_dispo` int(11) NOT NULL,
  PRIMARY KEY (`id_event`,`id_article`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

	");
	echo "BDD initialis&eacute; !";
