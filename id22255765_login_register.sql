-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2024 at 10:18 AM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id22255765_login_register`
--

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetID` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id_submission` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `nickname` text NOT NULL,
  `type` text NOT NULL,
  `answer1` text NOT NULL,
  `answer2` text NOT NULL,
  `answer3` text NOT NULL,
  `date` date NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id_submission`, `id`, `nickname`, `type`, `answer1`, `answer2`, `answer3`, `date`, `status`) VALUES
(3, 20, 'kiszak', 'whitelist', 'James Windu', 'James Windu urodził się i wychował w Los Santos, w dzielnicy Strawberry, znanej z wysokiej przestępczości i trudnych warunków życia. Jego ojciec był drobnym przedsiębiorcą prowadzącym sklep z elektroniką, a matka pracowała w lokalnym barze. Od najmłodszych lat James był świadkiem trudnego życia i walki o przetrwanie. Ulica była dla niego nauczycielem, a trudne warunki nauczyły go sprytu i przetrwania.\r\n\r\nW szkole James radził sobie przeciętnie, bardziej interesując się tym, co działo się na ulicach niż nauką. Już jako nastolatek zaczął angażować się w drobne przestępstwa, takie jak kradzieże kieszonkowe i drobne włamania, aby pomóc finansowo swojej rodzinie. Szybko zyskał reputację zdolnego i niezawodnego \"solidera\" w lokalnych kręgach przestępczych.\r\n\r\nJames unikał jednak wiązania się z jakimkolwiek gangiem czy mafią. Zawsze cenił swoją niezależność i wolność wyboru. Działał jako wolny agent, pracując dla różnych grup i osób, które potrzebowały jego umiejętności, ale nigdy nie zobowiązując się do stałej współpracy. To pozwalało mu unikać konfliktów lojalnościowych i zachować elastyczność w podejmowaniu decyzji.', 'James potrafi być bezwzględny w swoich działaniach, zwłaszcza gdy chodzi o przetrwanie i ochronę swojego interesu. Nie boi się podejmować drastycznych kroków, aby zabezpieczyć swoją wolność i niezależność.', '2024-06-02', 'Przyjęte'),
(10, 34, 'rekrut', 'whitelist', 'Johan Taylor', 'Johan Taylor urodził się w Los Santos, gdzie żyje do tej pory.', 'Johan Taylor skacze na skakance i się wywraca.', '2024-06-20', 'Przyjęte'),
(11, 36, 'Damian2010', 'mechanic', 'Ponieważ jest to moje marzenie. Byłem mechanikiem przez 2 miesiące na TilosRP.', 'Postanowiła zostać mechanikiem.', 'Naprawiał i naprawił.', '2024-06-20', 'oczekujące'),
(12, 38, 'cfs', 'whitelist', 'Testowe imie', 'Testowa historia', 'Testowa akcja', '2024-06-20', 'Przyjęte'),
(13, 38, 'cfs', 'police', 'Test1', 'Test1', 'Test3', '2024-06-20', 'Nieprzyjęte');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nickname` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `rank` text NOT NULL,
  `failed_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nickname`, `email`, `password`, `rank`, `failed_time`) VALUES
(2, 'Filip', 'f.kubala@interia.pl', '$2y$10$viIUZGZbocEtSt6zB9kIve/aQnSDA2NF95MA16s0s6HE./84GCbEG', 'Administrator', NULL),
(35, 'fresh', 'fresh120503@gmail.com', '$2y$10$C4SLXgBJ9Zom4OHnhWfl7eAXpI50WTQsLVz.fjUA0Esu3CRSAhlo6', 'Administrator', NULL),
(36, 'Damian2010', 'damian@gmail.com', '$2y$10$Am.DdUilMJjtS1A89UAhneQ6ePV7oGH7JcgUzyr0EEeLlUw75r0a2', 'Gracz', NULL),
(37, 'kepihe', 'kepihe7315@dovinou.com', '$2y$10$8YTvi3TCcRZCGsALFTYG6OHTq54wImPbdoZOPTIHerIX8KZKu8RcO', 'Administrator', NULL),
(38, 'cfs', 'cfs41437@doolk.com', '$2y$10$CxWelLAfZRaD5vbHvNU3G.QnQyjLgoWqoM8658xBeCrHD1Mm68wcK', 'Gracz', '2024-06-20 10:05:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetID`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id_submission`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id_submission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
