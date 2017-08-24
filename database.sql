-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 24, 2017 at 02:14 PM
-- Server version: 10.1.20-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id1499129_movie_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `characte`
--

CREATE TABLE `characte` (
  `characte_prefix` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `characte_id` varchar(255) NOT NULL,
  `characte_name` varchar(255) NOT NULL,
  `biography` text,
  `poster_path` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `character_gallery`
--

CREATE TABLE `character_gallery` (
  `id` int(11) NOT NULL,
  `character_gallery_id` varchar(255) NOT NULL,
  `characte_id` varchar(255) NOT NULL,
  `small_image_path` varchar(255) NOT NULL,
  `large_image_path` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_prefix` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `city_id` varchar(255) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `country_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `composer`
--

CREATE TABLE `composer` (
  `composerlist_id` varchar(255) NOT NULL,
  `person_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_prefix` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `country_id` varchar(255) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crazy_credits`
--

CREATE TABLE `crazy_credits` (
  `crazy_credits_prefix` varchar(20) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `series_id` varchar(255) DEFAULT NULL,
  `crazy_credits_details` text,
  `isspoiler` tinyint(1) DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `creator`
--

CREATE TABLE `creator` (
  `creator_prefix` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `creator_id` varchar(255) NOT NULL,
  `creator_name` varchar(255) NOT NULL,
  `fb_link` text NOT NULL,
  `insta_link` text NOT NULL,
  `twitter_link` text NOT NULL,
  `website_link` text NOT NULL,
  `short_description` text NOT NULL,
  `full_bio` text NOT NULL,
  `established_date` date NOT NULL,
  `poster_image_path` varchar(255) NOT NULL,
  `landscape_image_path` varchar(255) NOT NULL,
  `thumbnail_image_path` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `episode`
--

CREATE TABLE `episode` (
  `episode_id` varchar(255) NOT NULL,
  `episode_name` varchar(255) NOT NULL,
  `episode_number` int(11) NOT NULL,
  `published_date` date DEFAULT NULL,
  `time_length` int(11) NOT NULL,
  `short_bio` text NOT NULL,
  `storyline` text NOT NULL,
  `poster_image_path` text NOT NULL,
  `landscape_image_path` text NOT NULL,
  `thumbnail_image_path` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `episode`
--
DELIMITER $$
CREATE TRIGGER `updateRuntimeSeason` AFTER INSERT ON `episode` FOR EACH ROW UPDATE season set runtime =  (SELECT tx.runtime  FROM ( SELECT tmp.season_id, sum(tmp.time_length) as runtime FROM (SELECT season_to_episode_mapping.season_id , episode.time_length FROM episode join season_to_episode_mapping on season_to_episode_mapping.episode_id= episode.episode_id ) as tmp GROUP BY tmp.season_id ) as tx WHERE tx.season_id = (SELECT season_id FROM season_to_episode_mapping WHERE episode_id = NEW.episode_id ) )  WHERE season_id = (SELECT season_id FROM season_to_episode_mapping WHERE episode_id = NEW.episode_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `episode_awards`
--

CREATE TABLE `episode_awards` (
  `episode_id` varchar(255) NOT NULL,
  `award_name` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `episode_cast`
--

CREATE TABLE `episode_cast` (
  `episode_id` varchar(255) NOT NULL,
  `characte_id` varchar(255) NOT NULL,
  `person_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `episode_dialogues`
--

CREATE TABLE `episode_dialogues` (
  `episode_id` varchar(255) NOT NULL,
  `dialogues` text NOT NULL,
  `characte_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `episode_filmography`
--

CREATE TABLE `episode_filmography` (
  `person_id` varchar(255) NOT NULL,
  `work_id` varchar(255) NOT NULL,
  `episode_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `episode_gallery`
--

CREATE TABLE `episode_gallery` (
  `id` int(11) NOT NULL,
  `episode_gallery_id` varchar(255) NOT NULL,
  `episode_id` varchar(255) NOT NULL,
  `small_image_path` varchar(255) NOT NULL,
  `large_image_path` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `episode_review`
--

CREATE TABLE `episode_review` (
  `episode_id` varchar(255) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `review_title` varchar(255) NOT NULL,
  `review_text` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `episode_soundtracks`
--

CREATE TABLE `episode_soundtracks` (
  `id` int(11) NOT NULL,
  `soundtracks_id` varchar(255) DEFAULT NULL,
  `episode_id` varchar(255) NOT NULL,
  `song_name` text NOT NULL,
  `composerlist_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `genre_prefix` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `genre_id` varchar(255) NOT NULL,
  `genre_name` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `goofs`
--

CREATE TABLE `goofs` (
  `goofs_prefix` varchar(20) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `series_id` varchar(255) DEFAULT NULL,
  `goofs_details` text NOT NULL,
  `isspoiler` tinyint(1) DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `language_prefix` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `language_id` varchar(255) NOT NULL,
  `language_name` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_03_24_171023_create_admin_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_prefix` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `person_id` varchar(255) NOT NULL,
  `person_name` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `death_date` date DEFAULT NULL,
  `death_place` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `full_biography` text NOT NULL,
  `square_image` varchar(255) DEFAULT NULL,
  `poster_image` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `person_awards`
--

CREATE TABLE `person_awards` (
  `person_id` varchar(255) NOT NULL,
  `award_name` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `person_gallery`
--

CREATE TABLE `person_gallery` (
  `person_id` varchar(255) NOT NULL,
  `small_image_path` text NOT NULL,
  `large_image_path` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `quotes_prefix` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `series_id` varchar(255) DEFAULT NULL,
  `quotes_details` text NOT NULL,
  `isspoiler` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `season`
--

CREATE TABLE `season` (
  `season_id` varchar(255) NOT NULL,
  `published_date` date NOT NULL,
  `season_number` int(11) NOT NULL,
  `runtime` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `season_to_episode_mapping`
--

CREATE TABLE `season_to_episode_mapping` (
  `id` int(11) NOT NULL,
  `season_id` varchar(255) NOT NULL,
  `episode_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `series_prefix` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `series_id` varchar(255) NOT NULL,
  `series_name` varchar(255) NOT NULL,
  `summary_text` text NOT NULL,
  `storyline` text NOT NULL,
  `published_date` date NOT NULL,
  `trailer_link` text NOT NULL,
  `series_fb` text NOT NULL,
  `series_insta` text NOT NULL,
  `series_twitter` text NOT NULL,
  `creator_id` varchar(255) NOT NULL,
  `poster_path` text NOT NULL,
  `thumbnail_path` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_awards`
--

CREATE TABLE `series_awards` (
  `series_id` varchar(255) NOT NULL,
  `award_name` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_cast`
--

CREATE TABLE `series_cast` (
  `series_id` varchar(255) NOT NULL,
  `characte_id` varchar(255) NOT NULL,
  `person_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_country`
--

CREATE TABLE `series_country` (
  `series_id` varchar(255) NOT NULL,
  `country_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_distributors`
--

CREATE TABLE `series_distributors` (
  `series_id` varchar(255) NOT NULL,
  `distributors` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_filminglocation`
--

CREATE TABLE `series_filminglocation` (
  `series_id` varchar(255) NOT NULL,
  `city_id` varchar(255) NOT NULL,
  `country_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_filmography`
--

CREATE TABLE `series_filmography` (
  `person_id` varchar(255) NOT NULL,
  `work_id` varchar(255) NOT NULL,
  `series_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_gallery`
--

CREATE TABLE `series_gallery` (
  `series_id` varchar(255) NOT NULL,
  `small_image_path` varchar(255) NOT NULL,
  `large_image_path` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_language`
--

CREATE TABLE `series_language` (
  `series_id` varchar(255) NOT NULL,
  `language_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_productionco`
--

CREATE TABLE `series_productionco` (
  `series_id` varchar(255) NOT NULL,
  `production_co` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_soundtracks`
--

CREATE TABLE `series_soundtracks` (
  `series_id` varchar(255) NOT NULL,
  `song_name` text NOT NULL,
  `composerlist_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_to_genre_mapping`
--

CREATE TABLE `series_to_genre_mapping` (
  `series_id` varchar(255) NOT NULL,
  `genre_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `series_to_season_mapping`
--

CREATE TABLE `series_to_season_mapping` (
  `id` int(11) NOT NULL,
  `series_id` varchar(255) NOT NULL,
  `season_id` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `technicalspecs`
--

CREATE TABLE `technicalspecs` (
  `series_id` varchar(255) NOT NULL,
  `sound_mix_type` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `aspect_ratio` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travia`
--

CREATE TABLE `travia` (
  `travia_prefix` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `series_id` varchar(255) DEFAULT NULL,
  `travia_details` text NOT NULL,
  `isspoiler` tinyint(1) DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dhvani', 'kakadiyadhvani@gmail.com', '$2y$10$es2KPRo6iLx9X/oYyx6QPezz5BCeYbhdfWjvRxvITfMGcAxh2zoRW', 'Admin', 'LiiyamV3qI5OcHUB2LPEgJl12pn7DwEUhiWX8bTOAXBuyoTdIar6FOi8Vf2o', '2017-06-20 07:00:00', '2017-08-22 16:05:11');

-- --------------------------------------------------------

--
-- Table structure for table `work_role`
--

CREATE TABLE `work_role` (
  `id` int(11) NOT NULL,
  `work_id` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_role`
--

INSERT INTO `work_role` (`id`, `work_id`, `role`) VALUES
(1, 'WR1', 'Writer'),
(2, 'WR2', 'Associate Director'),
(3, 'WR3', 'Producer'),
(4, 'WR4', 'Editor'),
(5, 'WR5', 'Cinematographer'),
(6, 'WR6', 'Composer'),
(7, 'WR7', 'Director');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `characte`
--
ALTER TABLE `characte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `characte_id` (`characte_id`);

--
-- Indexes for table `character_gallery`
--
ALTER TABLE `character_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `characte_id` (`characte_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `composer`
--
ALTER TABLE `composer`
  ADD KEY `composerlist_id` (`composerlist_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `crazy_credits`
--
ALTER TABLE `crazy_credits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episode_id` (`series_id`);

--
-- Indexes for table `creator`
--
ALTER TABLE `creator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indexes for table `episode`
--
ALTER TABLE `episode`
  ADD PRIMARY KEY (`episode_id`),
  ADD KEY `episode_id` (`episode_id`);

--
-- Indexes for table `episode_awards`
--
ALTER TABLE `episode_awards`
  ADD KEY `episode_id` (`episode_id`);

--
-- Indexes for table `episode_cast`
--
ALTER TABLE `episode_cast`
  ADD KEY `episode_id` (`episode_id`),
  ADD KEY `characte_id` (`characte_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `episode_dialogues`
--
ALTER TABLE `episode_dialogues`
  ADD KEY `episode_id` (`episode_id`),
  ADD KEY `characte_id` (`characte_id`);

--
-- Indexes for table `episode_filmography`
--
ALTER TABLE `episode_filmography`
  ADD KEY `person_id` (`person_id`),
  ADD KEY `work_id` (`work_id`),
  ADD KEY `episode_id` (`episode_id`);

--
-- Indexes for table `episode_gallery`
--
ALTER TABLE `episode_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episode_id` (`episode_id`);

--
-- Indexes for table `episode_review`
--
ALTER TABLE `episode_review`
  ADD KEY `episode_id` (`episode_id`);

--
-- Indexes for table `episode_soundtracks`
--
ALTER TABLE `episode_soundtracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episode_id` (`episode_id`),
  ADD KEY `composerlist_id` (`composerlist_id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `goofs`
--
ALTER TABLE `goofs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episode_id` (`series_id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `person_id_2` (`person_id`),
  ADD KEY `person_id_3` (`person_id`);

--
-- Indexes for table `person_awards`
--
ALTER TABLE `person_awards`
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `person_gallery`
--
ALTER TABLE `person_gallery`
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episode_id` (`series_id`);

--
-- Indexes for table `season`
--
ALTER TABLE `season`
  ADD KEY `season_id` (`season_id`);

--
-- Indexes for table `season_to_episode_mapping`
--
ALTER TABLE `season_to_episode_mapping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `season_id` (`season_id`),
  ADD KEY `episode_id` (`episode_id`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_id` (`series_id`);

--
-- Indexes for table `series_awards`
--
ALTER TABLE `series_awards`
  ADD KEY `series_id` (`series_id`);

--
-- Indexes for table `series_cast`
--
ALTER TABLE `series_cast`
  ADD KEY `series_id` (`series_id`),
  ADD KEY `characte_id` (`characte_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `series_country`
--
ALTER TABLE `series_country`
  ADD KEY `series_id` (`series_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `series_distributors`
--
ALTER TABLE `series_distributors`
  ADD KEY `series_id` (`series_id`);

--
-- Indexes for table `series_filminglocation`
--
ALTER TABLE `series_filminglocation`
  ADD KEY `series_id` (`series_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `series_filmography`
--
ALTER TABLE `series_filmography`
  ADD KEY `person_id` (`person_id`),
  ADD KEY `work_id` (`work_id`),
  ADD KEY `series_id` (`series_id`);

--
-- Indexes for table `series_gallery`
--
ALTER TABLE `series_gallery`
  ADD KEY `series_id` (`series_id`);

--
-- Indexes for table `series_language`
--
ALTER TABLE `series_language`
  ADD KEY `series_id` (`series_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `series_productionco`
--
ALTER TABLE `series_productionco`
  ADD KEY `series_id` (`series_id`);

--
-- Indexes for table `series_soundtracks`
--
ALTER TABLE `series_soundtracks`
  ADD KEY `series_id` (`series_id`),
  ADD KEY `composerlist_id` (`composerlist_id`);

--
-- Indexes for table `series_to_genre_mapping`
--
ALTER TABLE `series_to_genre_mapping`
  ADD KEY `series_id` (`series_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `series_to_season_mapping`
--
ALTER TABLE `series_to_season_mapping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_id` (`series_id`),
  ADD KEY `season_id` (`season_id`);

--
-- Indexes for table `technicalspecs`
--
ALTER TABLE `technicalspecs`
  ADD KEY `series_id` (`series_id`);

--
-- Indexes for table `travia`
--
ALTER TABLE `travia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episode_id` (`series_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `work_role`
--
ALTER TABLE `work_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_id` (`work_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `characte`
--
ALTER TABLE `characte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;
--
-- AUTO_INCREMENT for table `character_gallery`
--
ALTER TABLE `character_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `crazy_credits`
--
ALTER TABLE `crazy_credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `creator`
--
ALTER TABLE `creator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `episode_gallery`
--
ALTER TABLE `episode_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `episode_soundtracks`
--
ALTER TABLE `episode_soundtracks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `goofs`
--
ALTER TABLE `goofs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;
--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `season_to_episode_mapping`
--
ALTER TABLE `season_to_episode_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;
--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `series_to_season_mapping`
--
ALTER TABLE `series_to_season_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `travia`
--
ALTER TABLE `travia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `work_role`
--
ALTER TABLE `work_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `character_gallery`
--
ALTER TABLE `character_gallery`
  ADD CONSTRAINT `character_gallery_ibfk_1` FOREIGN KEY (`characte_id`) REFERENCES `characte` (`characte_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `composer`
--
ALTER TABLE `composer`
  ADD CONSTRAINT `composer_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `composer_ibfk_2` FOREIGN KEY (`composerlist_id`) REFERENCES `episode_soundtracks` (`composerlist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crazy_credits`
--
ALTER TABLE `crazy_credits`
  ADD CONSTRAINT `crazy_credits_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series_to_season_mapping` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `episode`
--
ALTER TABLE `episode`
  ADD CONSTRAINT `episode_ibfk_1` FOREIGN KEY (`episode_id`) REFERENCES `season_to_episode_mapping` (`episode_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `episode_awards`
--
ALTER TABLE `episode_awards`
  ADD CONSTRAINT `episode_awards_ibfk_1` FOREIGN KEY (`episode_id`) REFERENCES `season_to_episode_mapping` (`episode_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `episode_cast`
--
ALTER TABLE `episode_cast`
  ADD CONSTRAINT `episode_cast_ibfk_1` FOREIGN KEY (`episode_id`) REFERENCES `season_to_episode_mapping` (`episode_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `episode_cast_ibfk_2` FOREIGN KEY (`characte_id`) REFERENCES `characte` (`characte_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `episode_cast_ibfk_3` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `episode_dialogues`
--
ALTER TABLE `episode_dialogues`
  ADD CONSTRAINT `episode_dialogues_ibfk_1` FOREIGN KEY (`episode_id`) REFERENCES `season_to_episode_mapping` (`episode_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `episode_dialogues_ibfk_2` FOREIGN KEY (`characte_id`) REFERENCES `characte` (`characte_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `episode_filmography`
--
ALTER TABLE `episode_filmography`
  ADD CONSTRAINT `episode_filmography_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `episode_filmography_ibfk_2` FOREIGN KEY (`work_id`) REFERENCES `work_role` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `episode_filmography_ibfk_3` FOREIGN KEY (`episode_id`) REFERENCES `season_to_episode_mapping` (`episode_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `episode_gallery`
--
ALTER TABLE `episode_gallery`
  ADD CONSTRAINT `episode_gallery_ibfk_1` FOREIGN KEY (`episode_id`) REFERENCES `season_to_episode_mapping` (`episode_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `episode_review`
--
ALTER TABLE `episode_review`
  ADD CONSTRAINT `episode_review_ibfk_1` FOREIGN KEY (`episode_id`) REFERENCES `season_to_episode_mapping` (`episode_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `episode_soundtracks`
--
ALTER TABLE `episode_soundtracks`
  ADD CONSTRAINT `episode_soundtracks_ibfk_1` FOREIGN KEY (`episode_id`) REFERENCES `season_to_episode_mapping` (`episode_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `goofs`
--
ALTER TABLE `goofs`
  ADD CONSTRAINT `goofs_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series_to_season_mapping` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `person_awards`
--
ALTER TABLE `person_awards`
  ADD CONSTRAINT `person_awards_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `person_gallery`
--
ALTER TABLE `person_gallery`
  ADD CONSTRAINT `person_gallery_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quotes`
--
ALTER TABLE `quotes`
  ADD CONSTRAINT `quotes_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series_to_season_mapping` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `season`
--
ALTER TABLE `season`
  ADD CONSTRAINT `season_ibfk_1` FOREIGN KEY (`season_id`) REFERENCES `series_to_season_mapping` (`season_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `season_to_episode_mapping`
--
ALTER TABLE `season_to_episode_mapping`
  ADD CONSTRAINT `season_to_episode_mapping_ibfk_1` FOREIGN KEY (`season_id`) REFERENCES `series_to_season_mapping` (`season_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_awards`
--
ALTER TABLE `series_awards`
  ADD CONSTRAINT `series_awards_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_cast`
--
ALTER TABLE `series_cast`
  ADD CONSTRAINT `series_cast_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_cast_ibfk_2` FOREIGN KEY (`characte_id`) REFERENCES `episode_cast` (`characte_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_cast_ibfk_3` FOREIGN KEY (`person_id`) REFERENCES `episode_cast` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_country`
--
ALTER TABLE `series_country`
  ADD CONSTRAINT `series_country_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_country_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_distributors`
--
ALTER TABLE `series_distributors`
  ADD CONSTRAINT `series_distributors_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_filminglocation`
--
ALTER TABLE `series_filminglocation`
  ADD CONSTRAINT `series_filminglocation_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_filminglocation_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_filminglocation_ibfk_3` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_filmography`
--
ALTER TABLE `series_filmography`
  ADD CONSTRAINT `series_filmography_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `episode_filmography` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_filmography_ibfk_2` FOREIGN KEY (`work_id`) REFERENCES `episode_filmography` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_filmography_ibfk_3` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_gallery`
--
ALTER TABLE `series_gallery`
  ADD CONSTRAINT `series_gallery_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_language`
--
ALTER TABLE `series_language`
  ADD CONSTRAINT `series_language_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_language_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_productionco`
--
ALTER TABLE `series_productionco`
  ADD CONSTRAINT `series_productionco_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_soundtracks`
--
ALTER TABLE `series_soundtracks`
  ADD CONSTRAINT `series_soundtracks_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_soundtracks_ibfk_2` FOREIGN KEY (`composerlist_id`) REFERENCES `episode_soundtracks` (`composerlist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_to_genre_mapping`
--
ALTER TABLE `series_to_genre_mapping`
  ADD CONSTRAINT `series_to_genre_mapping_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `series_to_genre_mapping_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `series_to_season_mapping`
--
ALTER TABLE `series_to_season_mapping`
  ADD CONSTRAINT `series_to_season_mapping_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `technicalspecs`
--
ALTER TABLE `technicalspecs`
  ADD CONSTRAINT `technicalspecs_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `travia`
--
ALTER TABLE `travia`
  ADD CONSTRAINT `travia_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series_to_season_mapping` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
