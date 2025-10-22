-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 03:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wst_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `answer_text` varchar(1000) DEFAULT NULL,
  `response_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choice_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`answer_id`, `answer_text`, `response_id`, `question_id`, `choice_id`) VALUES
(1, NULL, 1, 1, 2),
(2, NULL, 1, 2, 5),
(3, NULL, 1, 3, 10),
(4, NULL, 1, 4, 15),
(5, NULL, 1, 5, 18),
(6, NULL, 1, 6, 21),
(7, NULL, 1, 7, 28),
(8, NULL, 1, 8, 31),
(9, NULL, 1, 9, 39),
(10, NULL, 1, 10, 43),
(11, 'I liked the course pace.', 1, 11, NULL),
(12, 'Improve explanation on some topics.', 1, 12, NULL),
(13, 'More real-life examples.', 1, 13, NULL),
(14, 'Lecture slides were helpful.', 1, 14, NULL),
(15, 'Make discussions more interactive.', 1, 15, NULL),
(16, NULL, 7, 1, 4),
(17, NULL, 7, 2, 6),
(18, NULL, 7, 3, 9),
(19, NULL, 7, 4, 14),
(20, NULL, 7, 5, 19),
(21, NULL, 7, 6, 23),
(22, NULL, 7, 7, 27),
(23, NULL, 7, 8, 32),
(24, NULL, 7, 9, 36),
(25, NULL, 7, 10, 41),
(26, 'The discussions were clear.', 7, 11, NULL),
(27, 'Labs need clearer instructions.', 7, 12, NULL),
(28, 'Instructor was great.', 7, 13, NULL),
(29, 'Pacing was fast but manageable.', 7, 14, NULL),
(30, 'Use more visuals.', 7, 15, NULL),
(31, NULL, 13, 1, 1),
(32, NULL, 13, 2, 7),
(33, NULL, 13, 3, 12),
(34, NULL, 13, 4, 13),
(35, NULL, 13, 5, 17),
(36, NULL, 13, 6, 25),
(37, NULL, 13, 7, 26),
(38, NULL, 13, 8, 35),
(39, NULL, 13, 9, 38),
(40, NULL, 13, 10, 45),
(41, 'Good learning experience.', 13, 11, NULL),
(42, 'Need more practical tasks.', 13, 12, NULL),
(43, 'Friendly instructor.', 13, 13, NULL),
(44, 'More group work.', 13, 14, NULL),
(45, 'Explain objectives better.', 13, 15, NULL),
(46, NULL, 19, 1, 3),
(47, NULL, 19, 2, 8),
(48, NULL, 19, 3, 11),
(49, NULL, 19, 4, 16),
(50, NULL, 19, 5, 20),
(51, NULL, 19, 6, 22),
(52, NULL, 19, 7, 30),
(53, NULL, 19, 8, 33),
(54, NULL, 19, 9, 40),
(55, NULL, 19, 10, 42),
(56, 'Lectures were engaging.', 19, 11, NULL),
(57, 'Less theory, more practice.', 19, 12, NULL),
(58, 'Encourage more participation.', 19, 13, NULL),
(59, 'Add a review day before exams.', 19, 14, NULL),
(60, 'Clearer grading criteria.', 19, 15, NULL),
(61, NULL, 25, 1, 1),
(62, NULL, 25, 2, 6),
(63, NULL, 25, 3, 9),
(64, NULL, 25, 4, 13),
(65, NULL, 25, 5, 17),
(66, NULL, 25, 6, 24),
(67, NULL, 25, 7, 26),
(68, NULL, 25, 8, 34),
(69, NULL, 25, 9, 36),
(70, NULL, 25, 10, 44),
(71, 'Instructor was helpful.', 25, 11, NULL),
(72, 'More exercises needed.', 25, 12, NULL),
(73, 'Examples helped understanding.', 25, 13, NULL),
(74, 'Liked peer discussions.', 25, 14, NULL),
(75, 'Make use of online quizzes.', 25, 15, NULL),
(76, NULL, 31, 1, 4),
(77, NULL, 31, 2, 5),
(78, NULL, 31, 3, 12),
(79, NULL, 31, 4, 16),
(80, NULL, 31, 5, 20),
(81, NULL, 31, 6, 21),
(82, NULL, 31, 7, 26),
(83, NULL, 31, 8, 31),
(84, NULL, 31, 9, 37),
(85, NULL, 31, 10, 45),
(86, 'Need more activities.', 31, 11, NULL),
(87, 'Need more activities.', 31, 12, NULL),
(88, 'Need more activities.', 31, 13, NULL),
(89, 'Slides were helpful.', 31, 14, NULL),
(90, 'Slides were helpful.', 31, 15, NULL),
(91, NULL, 37, 1, 1),
(92, NULL, 37, 2, 8),
(93, NULL, 37, 3, 10),
(94, NULL, 37, 4, 15),
(95, NULL, 37, 5, 18),
(96, NULL, 37, 6, 25),
(97, NULL, 37, 7, 28),
(98, NULL, 37, 8, 35),
(99, NULL, 37, 9, 39),
(100, NULL, 37, 10, 45),
(101, 'Very informative.', 37, 11, NULL),
(102, 'Engaging content.', 37, 12, NULL),
(103, 'Could use improvement.', 37, 13, NULL),
(104, 'Engaging content.', 37, 14, NULL),
(105, 'Engaging content.', 37, 15, NULL),
(106, NULL, 43, 1, 4),
(107, NULL, 43, 2, 8),
(108, NULL, 43, 3, 12),
(109, NULL, 43, 4, 16),
(110, NULL, 43, 5, 20),
(111, NULL, 43, 6, 24),
(112, NULL, 43, 7, 29),
(113, NULL, 43, 8, 34),
(114, NULL, 43, 9, 36),
(115, NULL, 43, 10, 43),
(116, 'Could use improvement.', 43, 11, NULL),
(117, 'Need more activities.', 43, 12, NULL),
(118, 'Slides were helpful.', 43, 13, NULL),
(119, 'Slides were helpful.', 43, 14, NULL),
(120, 'Slides were helpful.', 43, 15, NULL),
(121, NULL, 49, 1, 4),
(122, NULL, 49, 2, 5),
(123, NULL, 49, 3, 9),
(124, NULL, 49, 4, 14),
(125, NULL, 49, 5, 19),
(126, NULL, 49, 6, 22),
(127, NULL, 49, 7, 29),
(128, NULL, 49, 8, 32),
(129, NULL, 49, 9, 39),
(130, NULL, 49, 10, 43),
(131, 'Slides were helpful.', 49, 11, NULL),
(132, 'Very informative.', 49, 12, NULL),
(133, 'Engaging content.', 49, 13, NULL),
(134, 'Very informative.', 49, 14, NULL),
(135, 'Slides were helpful.', 49, 15, NULL),
(136, NULL, 55, 1, 2),
(137, NULL, 55, 2, 5),
(138, NULL, 55, 3, 11),
(139, NULL, 55, 4, 14),
(140, NULL, 55, 5, 17),
(141, NULL, 55, 6, 25),
(142, NULL, 55, 7, 29),
(143, NULL, 55, 8, 35),
(144, NULL, 55, 9, 39),
(145, NULL, 55, 10, 45),
(146, 'Engaging content.', 55, 11, NULL),
(147, 'Need more activities.', 55, 12, NULL),
(148, 'Very informative.', 55, 13, NULL),
(149, 'Slides were helpful.', 55, 14, NULL),
(150, 'Slides were helpful.', 55, 15, NULL),
(151, NULL, 3, 31, 91),
(152, NULL, 3, 32, 95),
(153, NULL, 3, 33, 99),
(154, NULL, 3, 34, 103),
(155, NULL, 3, 35, 107),
(156, NULL, 3, 36, 111),
(157, NULL, 3, 37, 116),
(158, NULL, 3, 38, 121),
(159, NULL, 3, 39, 126),
(160, NULL, 3, 40, 131),
(161, 'Need more activities.', 3, 41, NULL),
(162, 'Need more activities.', 3, 42, NULL),
(163, 'Need more activities.', 3, 43, NULL),
(164, 'Slides were helpful.', 3, 44, NULL),
(165, 'Slides were helpful.', 3, 45, NULL),
(166, NULL, 9, 31, 92),
(167, NULL, 9, 32, 98),
(168, NULL, 9, 33, 100),
(169, NULL, 9, 34, 105),
(170, NULL, 9, 35, 108),
(171, NULL, 9, 36, 112),
(172, NULL, 9, 37, 118),
(173, NULL, 9, 38, 123),
(174, NULL, 9, 39, 128),
(175, NULL, 9, 40, 131),
(176, 'Very informative.', 9, 41, NULL),
(177, 'Engaging content.', 9, 42, NULL),
(178, 'Could use improvement.', 9, 43, NULL),
(179, 'Engaging content.', 9, 44, NULL),
(180, 'Engaging content.', 9, 45, NULL),
(181, NULL, 15, 31, 94),
(182, NULL, 15, 32, 98),
(183, NULL, 15, 33, 102),
(184, NULL, 15, 34, 106),
(185, NULL, 15, 35, 110),
(186, NULL, 15, 36, 113),
(187, NULL, 15, 37, 120),
(188, NULL, 15, 38, 124),
(189, NULL, 15, 39, 130),
(190, NULL, 15, 40, 134),
(191, 'Could use improvement.', 15, 41, NULL),
(192, 'Need more activities.', 15, 42, NULL),
(193, 'Slides were helpful.', 15, 43, NULL),
(194, 'Slides were helpful.', 15, 44, NULL),
(195, 'Slides were helpful.', 15, 45, NULL),
(196, NULL, 21, 31, 91),
(197, NULL, 21, 32, 95),
(198, NULL, 21, 33, 99),
(199, NULL, 21, 34, 103),
(200, NULL, 21, 35, 107),
(201, NULL, 21, 36, 114),
(202, NULL, 21, 37, 119),
(203, NULL, 21, 38, 125),
(204, NULL, 21, 39, 130),
(205, NULL, 21, 40, 134),
(206, 'Slides were helpful.', 21, 41, NULL),
(207, 'Very informative.', 21, 42, NULL),
(208, 'Engaging content.', 21, 43, NULL),
(209, 'Very informative.', 21, 44, NULL),
(210, 'Slides were helpful.', 21, 45, NULL),
(211, NULL, 27, 31, 92),
(212, NULL, 27, 32, 95),
(213, NULL, 27, 33, 101),
(214, NULL, 27, 34, 103),
(215, NULL, 27, 35, 107),
(216, NULL, 27, 36, 115),
(217, NULL, 27, 37, 120),
(218, NULL, 27, 38, 125),
(219, NULL, 27, 39, 130),
(220, NULL, 27, 40, 135),
(221, 'Engaging content.', 27, 41, NULL),
(222, 'Need more activities.', 27, 42, NULL),
(223, 'Very informative.', 27, 43, NULL),
(224, 'Slides were helpful.', 27, 44, NULL),
(225, 'Slides were helpful.', 27, 45, NULL),
(226, NULL, 33, 31, 93),
(227, NULL, 33, 32, 96),
(228, NULL, 33, 33, 101),
(229, NULL, 33, 34, 106),
(230, NULL, 33, 35, 109),
(231, NULL, 33, 36, 111),
(232, NULL, 33, 37, 117),
(233, NULL, 33, 38, 121),
(234, NULL, 33, 39, 127),
(235, NULL, 33, 40, 132),
(236, 'Feedback was helpful.', 33, 41, NULL),
(237, 'Too short.', 33, 42, NULL),
(238, 'Loved the slides.', 33, 43, NULL),
(239, 'Good pacing.', 33, 44, NULL),
(240, 'Good pacing.', 33, 45, NULL),
(241, NULL, 39, 31, 91),
(242, NULL, 39, 32, 97),
(243, NULL, 39, 33, 102),
(244, NULL, 39, 34, 104),
(245, NULL, 39, 35, 108),
(246, NULL, 39, 36, 112),
(247, NULL, 39, 37, 118),
(248, NULL, 39, 38, 123),
(249, NULL, 39, 39, 128),
(250, NULL, 39, 40, 133),
(251, 'Very interactive.', 39, 41, NULL),
(252, 'Needs more visuals.', 39, 42, NULL),
(253, 'Very informative.', 39, 43, NULL),
(254, 'Loved it!', 39, 44, NULL),
(255, 'Loved it!', 39, 45, NULL),
(256, NULL, 45, 31, 94),
(257, NULL, 45, 32, 98),
(258, NULL, 45, 33, 99),
(259, NULL, 45, 34, 105),
(260, NULL, 45, 35, 110),
(261, NULL, 45, 36, 113),
(262, NULL, 45, 37, 119),
(263, NULL, 45, 38, 124),
(264, NULL, 45, 39, 129),
(265, NULL, 45, 40, 135),
(266, 'Interesting session.', 45, 41, NULL),
(267, 'Slides were helpful.', 45, 42, NULL),
(268, 'Could be improved.', 45, 43, NULL),
(269, 'Clear instructions.', 45, 44, NULL),
(270, 'Clear instructions.', 45, 45, NULL),
(271, NULL, 51, 31, 91),
(272, NULL, 51, 32, 95),
(273, NULL, 51, 33, 100),
(274, NULL, 51, 34, 103),
(275, NULL, 51, 35, 107),
(276, NULL, 51, 36, 114),
(277, NULL, 51, 37, 120),
(278, NULL, 51, 38, 124),
(279, NULL, 51, 39, 130),
(280, NULL, 51, 40, 134),
(281, 'Useful information.', 51, 41, NULL),
(282, 'Nice delivery.', 51, 42, NULL),
(283, 'Informative.', 51, 43, NULL),
(284, 'Concise and clear.', 51, 44, NULL),
(285, 'Concise and clear.', 51, 45, NULL),
(286, NULL, 57, 31, 92),
(287, NULL, 57, 32, 95),
(288, NULL, 57, 33, 101),
(289, NULL, 57, 34, 106),
(290, NULL, 57, 35, 109),
(291, NULL, 57, 36, 115),
(292, NULL, 57, 37, 121),
(293, NULL, 57, 38, 125),
(294, NULL, 57, 39, 130),
(295, NULL, 57, 40, 135),
(296, 'Well done.', 57, 41, NULL),
(297, 'Needs improvement.', 57, 42, NULL),
(298, 'Clear content.', 57, 43, NULL),
(299, 'Very engaging.', 57, 44, NULL),
(300, 'Very engaging.', 57, 45, NULL),
(301, NULL, 5, 61, 181),
(302, NULL, 5, 62, 186),
(303, NULL, 5, 63, 189),
(304, NULL, 5, 64, 193),
(305, NULL, 5, 65, 200),
(306, NULL, 5, 66, 201),
(307, NULL, 5, 67, 206),
(308, NULL, 5, 68, 211),
(309, NULL, 5, 69, 216),
(310, NULL, 5, 70, 221),
(311, 'Helpful.', 5, 71, NULL),
(312, 'More examples.', 5, 72, NULL),
(313, 'Great session.', 5, 73, NULL),
(314, 'Interesting.', 5, 74, NULL),
(315, 'Clear slides.', 5, 75, NULL),
(316, NULL, 11, 61, 182),
(317, NULL, 11, 62, 185),
(318, NULL, 11, 63, 190),
(319, NULL, 11, 64, 194),
(320, NULL, 11, 65, 197),
(321, NULL, 11, 66, 202),
(322, NULL, 11, 67, 207),
(323, NULL, 11, 68, 212),
(324, NULL, 11, 69, 217),
(325, NULL, 11, 70, 222),
(326, 'Informative.', 11, 71, NULL),
(327, 'Needs improvement.', 11, 72, NULL),
(328, 'Well-paced.', 11, 73, NULL),
(329, 'Clear content.', 11, 74, NULL),
(330, 'Nice flow.', 11, 75, NULL),
(331, NULL, 17, 61, 183),
(332, NULL, 17, 62, 188),
(333, NULL, 17, 63, 192),
(334, NULL, 17, 64, 195),
(335, NULL, 17, 65, 199),
(336, NULL, 17, 66, 203),
(337, NULL, 17, 67, 208),
(338, NULL, 17, 68, 213),
(339, NULL, 17, 69, 218),
(340, NULL, 17, 70, 223),
(341, 'Too fast.', 17, 71, NULL),
(342, 'Loved the topic.', 17, 72, NULL),
(343, 'Great discussion.', 17, 73, NULL),
(344, 'Slides helped.', 17, 74, NULL),
(345, 'Very clear.', 17, 75, NULL),
(346, NULL, 23, 61, 184),
(347, NULL, 23, 62, 185),
(348, NULL, 23, 63, 191),
(349, NULL, 23, 64, 196),
(350, NULL, 23, 65, 198),
(351, NULL, 23, 66, 204),
(352, NULL, 23, 67, 209),
(353, NULL, 23, 68, 214),
(354, NULL, 23, 69, 219),
(355, NULL, 23, 70, 224),
(356, 'Excellent session.', 23, 71, NULL),
(357, 'Engaging!', 23, 72, NULL),
(358, 'Could improve pacing.', 23, 73, NULL),
(359, 'Well-organized.', 23, 74, NULL),
(360, 'Slides were effective.', 23, 75, NULL),
(361, NULL, 29, 61, 181),
(362, NULL, 29, 62, 186),
(363, NULL, 29, 63, 189),
(364, NULL, 29, 64, 193),
(365, NULL, 29, 65, 197),
(366, NULL, 29, 66, 205),
(367, NULL, 29, 67, 210),
(368, NULL, 29, 68, 215),
(369, NULL, 29, 69, 220),
(370, NULL, 29, 70, 225),
(371, 'Good delivery.', 29, 71, NULL),
(372, 'Very helpful.', 29, 72, NULL),
(373, 'Slides were clear.', 29, 73, NULL),
(374, 'Add more visuals.', 29, 74, NULL),
(375, 'Well explained.', 29, 75, NULL),
(376, NULL, 35, 61, 182),
(377, NULL, 35, 62, 188),
(378, NULL, 35, 63, 190),
(379, NULL, 35, 64, 194),
(380, NULL, 35, 65, 200),
(381, NULL, 35, 66, 201),
(382, NULL, 35, 67, 206),
(383, NULL, 35, 68, 211),
(384, NULL, 35, 69, 216),
(385, NULL, 35, 70, 221),
(386, 'Nice interaction.', 35, 71, NULL),
(387, 'Topic was relevant.', 35, 72, NULL),
(388, 'Interesting topic.', 35, 73, NULL),
(389, 'Effective slides.', 35, 74, NULL),
(390, 'Very engaging.', 35, 75, NULL),
(391, NULL, 41, 61, 183),
(392, NULL, 41, 62, 187),
(393, NULL, 41, 63, 192),
(394, NULL, 41, 64, 196),
(395, NULL, 41, 65, 199),
(396, NULL, 41, 66, 202),
(397, NULL, 41, 67, 207),
(398, NULL, 41, 68, 212),
(399, NULL, 41, 69, 217),
(400, NULL, 41, 70, 222),
(401, 'Engaging content.', 41, 71, NULL),
(402, 'Could improve clarity.', 41, 72, NULL),
(403, 'Good timing.', 41, 73, NULL),
(404, 'Helpful visuals.', 41, 74, NULL),
(405, 'Very good.', 41, 75, NULL),
(406, NULL, 47, 61, 184),
(407, NULL, 47, 62, 185),
(408, NULL, 47, 63, 191),
(409, NULL, 47, 64, 195),
(410, NULL, 47, 65, 198),
(411, NULL, 47, 66, 203),
(412, NULL, 47, 67, 208),
(413, NULL, 47, 68, 213),
(414, NULL, 47, 69, 218),
(415, NULL, 47, 70, 223),
(416, 'Session was informative.', 47, 71, NULL),
(417, 'Clear examples.', 47, 72, NULL),
(418, 'Needs more depth.', 47, 73, NULL),
(419, 'Good pace.', 47, 74, NULL),
(420, 'Excellent slides.', 47, 75, NULL),
(421, NULL, 53, 61, 181),
(422, NULL, 53, 62, 186),
(423, NULL, 53, 63, 190),
(424, NULL, 53, 64, 193),
(425, NULL, 53, 65, 199),
(426, NULL, 53, 66, 204),
(427, NULL, 53, 67, 209),
(428, NULL, 53, 68, 214),
(429, NULL, 53, 69, 219),
(430, NULL, 53, 70, 224),
(431, 'Engaging session.', 53, 71, NULL),
(432, 'More real-life examples.', 53, 72, NULL),
(433, 'Interesting delivery.', 53, 73, NULL),
(434, 'Helpful notes.', 53, 74, NULL),
(435, 'Good energy.', 53, 75, NULL),
(436, NULL, 59, 61, 183),
(437, NULL, 59, 62, 187),
(438, NULL, 59, 63, 192),
(439, NULL, 59, 64, 196),
(440, NULL, 59, 65, 197),
(441, NULL, 59, 66, 205),
(442, NULL, 59, 67, 210),
(443, NULL, 59, 68, 215),
(444, NULL, 59, 69, 220),
(445, NULL, 59, 70, 225),
(446, 'Very clear delivery.', 59, 71, NULL),
(447, 'Could be shorter.', 59, 72, NULL),
(448, 'Excellent content.', 59, 73, NULL),
(449, 'Loved the approach.', 59, 74, NULL),
(450, 'Relevant and clear.', 59, 75, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `choice`
--

CREATE TABLE `choice` (
  `choice_id` int(11) NOT NULL,
  `choice_text` varchar(1000) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `choice`
--

INSERT INTO `choice` (`choice_id`, `choice_text`, `question_id`) VALUES
(1, 'Excellent', 1),
(2, 'Good', 1),
(3, 'Fair', 1),
(4, 'Poor', 1),
(5, 'Always', 2),
(6, 'Often', 2),
(7, 'Sometimes', 2),
(8, 'Never', 2),
(9, 'Very Clear', 3),
(10, 'Clear', 3),
(11, 'Unclear', 3),
(12, 'Very Unclear', 3),
(13, 'Yes', 4),
(14, 'No', 4),
(15, 'Partially', 4),
(16, 'Not Sure', 4),
(17, 'Too Fast', 5),
(18, 'Just Right', 5),
(19, 'Too Slow', 5),
(20, 'Varied', 5),
(21, 'Strongly Agree', 6),
(22, 'Agree', 6),
(23, 'Neutral', 6),
(24, 'Disagree', 6),
(25, 'Strongly Disagree', 6),
(26, 'Strongly Agree', 7),
(27, 'Agree', 7),
(28, 'Neutral', 7),
(29, 'Disagree', 7),
(30, 'Strongly Disagree', 7),
(31, 'Strongly Agree', 8),
(32, 'Agree', 8),
(33, 'Neutral', 8),
(34, 'Disagree', 8),
(35, 'Strongly Disagree', 8),
(36, 'Strongly Agree', 9),
(37, 'Agree', 9),
(38, 'Neutral', 9),
(39, 'Disagree', 9),
(40, 'Strongly Disagree', 9),
(41, 'Strongly Agree', 10),
(42, 'Agree', 10),
(43, 'Neutral', 10),
(44, 'Disagree', 10),
(45, 'Strongly Disagree', 10),
(91, 'Very Clear', 31),
(92, 'Clear', 31),
(93, 'Unclear', 31),
(94, 'Very Unclear', 31),
(95, 'Always', 32),
(96, 'Often', 32),
(97, 'Sometimes', 32),
(98, 'Never', 32),
(99, 'Highly Relevant', 33),
(100, 'Relevant', 33),
(101, 'Somewhat Relevant', 33),
(102, 'Not Relevant', 33),
(103, 'Yes', 34),
(104, 'No', 34),
(105, 'Partially', 34),
(106, 'Not Sure', 34),
(107, 'Very Confident', 35),
(108, 'Confident', 35),
(109, 'Somewhat Confident', 35),
(110, 'Not Confident', 35),
(111, 'Strongly Agree', 36),
(112, 'Agree', 36),
(113, 'Neutral', 36),
(114, 'Disagree', 36),
(115, 'Strongly Disagree', 36),
(116, 'Strongly Agree', 37),
(117, 'Agree', 37),
(118, 'Neutral', 37),
(119, 'Disagree', 37),
(120, 'Strongly Disagree', 37),
(121, 'Strongly Agree', 38),
(122, 'Agree', 38),
(123, 'Neutral', 38),
(124, 'Disagree', 38),
(125, 'Strongly Disagree', 38),
(126, 'Strongly Agree', 39),
(127, 'Agree', 39),
(128, 'Neutral', 39),
(129, 'Disagree', 39),
(130, 'Strongly Disagree', 39),
(131, 'Strongly Agree', 40),
(132, 'Agree', 40),
(133, 'Neutral', 40),
(134, 'Disagree', 40),
(135, 'Strongly Disagree', 40),
(181, 'Very Well', 61),
(182, 'Well', 61),
(183, 'Poorly', 61),
(184, 'Very Poorly', 61),
(185, 'Yes', 62),
(186, 'No', 62),
(187, 'Partially', 62),
(188, 'Not Sure', 62),
(189, 'Very Helpful', 63),
(190, 'Helpful', 63),
(191, 'Unhelpful', 63),
(192, 'Very Unhelpful', 63),
(193, 'Yes', 64),
(194, 'No', 64),
(195, 'Partially', 64),
(196, 'Not Sure', 64),
(197, 'Significantly', 65),
(198, 'Moderately', 65),
(199, 'Slightly', 65),
(200, 'Not at all', 65),
(201, 'Strongly Agree', 66),
(202, 'Agree', 66),
(203, 'Neutral', 66),
(204, 'Disagree', 66),
(205, 'Strongly Disagree', 66),
(206, 'Strongly Agree', 67),
(207, 'Agree', 67),
(208, 'Neutral', 67),
(209, 'Disagree', 67),
(210, 'Strongly Disagree', 67),
(211, 'Strongly Agree', 68),
(212, 'Agree', 68),
(213, 'Neutral', 68),
(214, 'Disagree', 68),
(215, 'Strongly Disagree', 68),
(216, 'Strongly Agree', 69),
(217, 'Agree', 69),
(218, 'Neutral', 69),
(219, 'Disagree', 69),
(220, 'Strongly Disagree', 69),
(221, 'Strongly Agree', 70),
(222, 'Agree', 70),
(223, 'Neutral', 70),
(224, 'Disagree', 70),
(225, 'Strongly Disagree', 70);

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `college_code` varchar(10) NOT NULL,
  `college_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`college_code`, `college_name`) VALUES
('CICT', 'College of Information Technology'),
('COE', 'College of Engineering'),
('COED', 'College of Education'),
('CON', 'College of Nursing');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `email_add` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `email_add`, `first_name`, `middle_name`, `last_name`, `password`) VALUES
(242501, 'jhon.alcanices@bulsu.edu.ph', 'Jhon Emmanuele', 'S.', 'Alcanices', 'pass123'),
(242502, 'aldrin.elamparo@bulsu.edu.ph', 'Aldrin', 'S.', 'Elamparo', 'pass123'),
(242503, 'isaiah.victoria@bulsu.edu.ph', 'Isaiah', 'C.', 'Victoria', 'pass123'),
(242504, 'maria.santos@bulsu.edu.ph', 'Maria', 'L.', 'Santos', 'pass123'),
(242505, 'daniel.reyes@bulsu.edu.ph', 'Daniel', 'M.', 'Reyes', 'pass123'),
(242506, 'anna.cruz@bulsu.edu.ph', 'Anna', 'T.', 'Cruz', 'pass123'),
(242507, 'james.delacruz@bulsu.edu.ph', 'James', 'R.', 'Dela Cruz', 'pass123'),
(242508, 'karen.garcia@bulsu.edu.ph', 'Karen', 'F.', 'Garcia', 'pass123'),
(242509, 'mark.torres@bulsu.edu.ph', 'Mark', 'G.', 'Torres', 'pass123'),
(242510, 'angelica.ramos@bulsu.edu.ph', 'Angelica', 'B.', 'Ramos', 'pass123'),
(242511, 'aaron.delarosa@bulsu.edu.ph', 'Aaron Paul', 'M.', 'Dela Rosa', 'pass123');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `program_code` varchar(10) NOT NULL,
  `program_name` varchar(100) NOT NULL,
  `college_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`program_code`, `program_name`, `college_code`) VALUES
('BEEd', 'Bachelor of Elementary Education', 'COED'),
('BSCpE', 'Bachelor of Science in Computer Engineering', 'COE'),
('BSEd-Eng', 'Bachelor of Secondary Education major in English', 'COED'),
('BSEd-Math', 'Bachelor of Secondary Education major in Mathematics', 'COED'),
('BSEE', 'Bachelor of Science in Electrical Engineering', 'COE'),
('BSIS', 'Bachelor of Science in Information System', 'CICT'),
('BSIT', 'Bachelor of Science in Information Technology', 'CICT'),
('BSME', 'Bachelor of Science in Mechanical Engineering', 'COE'),
('BSN', 'Bachelor of Science in Nursing', 'CON');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `question_text` varchar(1000) NOT NULL,
  `question_type` varchar(2) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `REQUIRED` varchar(3) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `question_text`, `question_type`, `survey_id`, `REQUIRED`) VALUES
(1, 'How would you rate the course content?', 'MC', 1, 'yes'),
(2, 'Was the instructor approachable?', 'MC', 1, 'yes'),
(3, 'How clear were the explanations during lectures?', 'MC', 1, 'yes'),
(4, 'Did the course meet your expectations?', 'MC', 1, 'no'),
(5, 'How was the pacing of the course?', 'MC', 1, 'no'),
(6, 'Rate the relevance of the course to your program.', 'LS', 1, 'no'),
(7, 'Rate the instructor’s preparedness.', 'LS', 1, 'no'),
(8, 'Rate the fairness of the assessments.', 'LS', 1, 'no'),
(9, 'Rate the usefulness of learning materials.', 'LS', 1, 'yes'),
(10, 'Rate the overall learning experience.', 'LS', 1, 'no'),
(11, 'What did you like most about the course?', 'SA', 1, 'no'),
(12, 'What could be improved in the course?', 'SA', 1, 'no'),
(13, 'Any suggestions for the instructor?', 'SA', 1, 'no'),
(14, 'What topics did you find most interesting?', 'SA', 1, 'no'),
(15, 'How can the course delivery be improved?', 'SA', 1, 'no'),
(31, 'Was the research process explained clearly?', 'MC', 3, 'no'),
(32, 'Did the instructor provide helpful feedback?', 'MC', 3, 'no'),
(33, 'Were the research topics relevant?', 'MC', 3, 'no'),
(34, 'Was there enough time for your research?', 'MC', 3, 'no'),
(35, 'Did you feel confident in presenting your research?', 'MC', 3, 'no'),
(36, 'Rate the clarity of research guidelines.', 'LS', 3, 'no'),
(37, 'Rate the instructor’s research guidance.', 'LS', 3, 'no'),
(38, 'Rate the relevance of research topics.', 'LS', 3, 'no'),
(39, 'Rate the workload of research projects.', 'LS', 3, 'no'),
(40, 'Rate the usefulness of research materials.', 'LS', 3, 'no'),
(41, 'What was the most valuable part of the course?', 'SA', 3, 'no'),
(42, 'What challenges did you face in research?', 'SA', 3, 'no'),
(43, 'What suggestions do you have for research topics?', 'SA', 3, 'no'),
(44, 'How can research mentoring be improved?', 'SA', 3, 'no'),
(45, 'What would you change about the research process?', 'SA', 3, 'no'),
(61, 'Was the ERD concept explained well?', 'MC', 5, 'no'),
(62, 'Did you understand normalization techniques?', 'MC', 5, 'no'),
(63, 'Was SQL practice helpful?', 'MC', 5, 'no'),
(64, 'Were database concepts clearly demonstrated?', 'MC', 5, 'no'),
(65, 'Did the course enhance your DBMS skills?', 'MC', 5, 'no'),
(66, 'Rate the clarity of DBMS topics.', 'LS', 5, 'no'),
(67, 'Rate the usefulness of SQL assignments.', 'LS', 5, 'no'),
(68, 'Rate the instructor’s support in database topics.', 'LS', 5, 'no'),
(69, 'Rate the relevance of DBMS to your program.', 'LS', 5, 'no'),
(70, 'Rate your confidence in DBMS concepts.', 'LS', 5, 'no'),
(71, 'What DBMS topics were most useful?', 'SA', 5, 'no'),
(72, 'What difficulties did you face in database design?', 'SA', 5, 'no'),
(73, 'What could improve SQL practice sessions?', 'SA', 5, 'no'),
(74, 'Any suggestions for future DBMS topics?', 'SA', 5, 'no'),
(75, 'How can DBMS labs be enhanced?', 'SA', 5, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `response_id` int(11) NOT NULL,
  `submit_date` date NOT NULL,
  `survey_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `response`
--

INSERT INTO `response` (`response_id`, `submit_date`, `survey_id`, `student_id`) VALUES
(1, '2025-05-25', 1, 202501),
(3, '2025-05-25', 3, 202501),
(5, '2025-05-25', 5, 202501),
(7, '2025-05-25', 1, 202502),
(9, '2025-05-25', 3, 202502),
(11, '2025-05-25', 5, 202502),
(13, '2025-05-25', 1, 202503),
(15, '2025-05-25', 3, 202503),
(17, '2025-05-25', 5, 202503),
(19, '2025-05-25', 1, 202504),
(21, '2025-05-25', 3, 202504),
(23, '2025-05-25', 5, 202504),
(25, '2025-05-25', 1, 202505),
(27, '2025-05-25', 3, 202505),
(29, '2025-05-25', 5, 202505),
(31, '2025-05-25', 1, 202506),
(33, '2025-05-25', 3, 202506),
(35, '2025-05-25', 5, 202506),
(37, '2025-05-25', 1, 202507),
(39, '2025-05-25', 3, 202507),
(41, '2025-05-25', 5, 202507),
(43, '2025-05-25', 1, 202508),
(45, '2025-05-25', 3, 202508),
(47, '2025-05-25', 5, 202508),
(49, '2025-05-25', 1, 202509),
(51, '2025-05-25', 3, 202509),
(53, '2025-05-25', 5, 202509),
(55, '2025-05-25', 1, 202510),
(57, '2025-05-25', 3, 202510),
(59, '2025-05-25', 5, 202510);

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_code` varchar(50) NOT NULL,
  `program_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_code`, `program_code`) VALUES
('BEEd 2A', 'BEEd'),
('BEEd 2B', 'BEEd'),
('BSCpE 2A', 'BSCpE'),
('BSCpE 2B', 'BSCpE'),
('BSEd-Eng 2A', 'BSEd-Eng'),
('BSEd-Eng 2B', 'BSEd-Eng'),
('BSEd-Math 2A', 'BSEd-Math'),
('BSEd-Math 2B', 'BSEd-Math'),
('BSEE 2A', 'BSEE'),
('BSEE 2B', 'BSEE'),
('BSIS 2A-G1', 'BSIS'),
('BSIS 2A-G2', 'BSIS'),
('BSIS 2B-G1', 'BSIS'),
('BSIS 2B-G2', 'BSIS'),
('BSIT 2A-G1', 'BSIT'),
('BSIT 2A-G2', 'BSIT'),
('BSIT 2B-G1', 'BSIT'),
('BSIT 2B-G2', 'BSIT'),
('BSIT 2C-G1', 'BSIT'),
('BSIT 2C-G2', 'BSIT'),
('BSIT 2D-G1', 'BSIT'),
('BSIT 2D-G2', 'BSIT'),
('BSIT 2E-G1', 'BSIT'),
('BSIT 2E-G2', 'BSIT'),
('BSIT 2F-G1', 'BSIT'),
('BSIT 2F-G2', 'BSIT'),
('BSIT 2G-G1', 'BSIT'),
('BSIT 2G-G2', 'BSIT'),
('BSIT 2H-G1', 'BSIT'),
('BSIT 2H-G2', 'BSIT'),
('BSME 2A', 'BSME'),
('BSME 2B', 'BSME'),
('BSN 2A', 'BSN'),
('BSN 2B', 'BSN');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `email_add` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `section_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `email_add`, `first_name`, `middle_name`, `last_name`, `password`, `section_code`) VALUES
(202501, 'mark.perez@bulsu.edu.ph', 'Mark Jimmel', 'T.', 'Perez', 'pass123', 'BSIT 2B-G2'),
(202502, 'chino.bernardino@bulsu.edu.ph', 'Chino', 'S.', 'Bernardino', 'pass123', 'BSIT 2B-G2'),
(202503, 'johnpaul.oca@bulsu.edu.ph', 'John Paul', 'T.', 'Oca', 'pass123', 'BSIT 2B-G2'),
(202504, 'mary.gonzales@bulsu.edu.ph', 'Mary', 'R.', 'Gonzales', 'pass123', 'BSIT 2B-G2'),
(202505, 'ronald.bautista@bulsu.edu.ph', 'Ronald', 'D.', 'Bautista', 'pass123', 'BSIT 2B-G2'),
(202506, 'jessica.ramos@bulsu.edu.ph', 'Jessica', 'L.', 'Ramos', 'pass123', 'BSIT 2B-G1'),
(202507, 'adrian.delacruz@bulsu.edu.ph', 'Adrian', 'M.', 'Dela Cruz', 'pass123', 'BSIT 2B-G1'),
(202508, 'camille.torres@bulsu.edu.ph', 'Camille', 'F.', 'Torres', 'pass123', 'BSIT 2B-G1'),
(202509, 'eric.mendoza@bulsu.edu.ph', 'Eric', 'J.', 'Mendoza', 'pass123', 'BSIT 2B-G1'),
(202510, 'pauline.morales@bulsu.edu.ph', 'Pauline', 'S.', 'Morales', 'pass123', 'BSIT 2B-G1'),
(202511, 'peter.villeno@bulsu.edu.ph', 'Peter Alfred', 'DG.', 'Villeno', 'pass123', 'BSIT 2B-G2');

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `survey_id` int(11) NOT NULL,
  `survey_title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `date_created` date NOT NULL,
  `date_modified` date DEFAULT NULL,
  `due_date` date NOT NULL,
  `faculty_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `survey`
--

INSERT INTO `survey` (`survey_id`, `survey_title`, `description`, `date_created`, `date_modified`, `due_date`, `faculty_id`) VALUES
(1, 'End-of-Semester Feedback', 'Gathering feedback on course delivery and materials.', '2025-05-25', NULL, '2025-05-31', 242501),
(3, 'Research Methods Feedback', 'Evaluate the Research Methods course.', '2025-05-25', NULL, '2025-05-31', 242502),
(5, 'Database Systems Feedback', 'Feedback on database course coverage and delivery.', '2025-05-25', NULL, '2025-05-27', 242503);

-- --------------------------------------------------------

--
-- Table structure for table `survey_section`
--

CREATE TABLE `survey_section` (
  `survey_id` int(11) NOT NULL,
  `section_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `survey_section`
--

INSERT INTO `survey_section` (`survey_id`, `section_code`) VALUES
(1, 'BSIT 2B-G1'),
(1, 'BSIT 2B-G2'),
(3, 'BSIT 2B-G1'),
(3, 'BSIT 2B-G2'),
(5, 'BSIT 2B-G1'),
(5, 'BSIT 2B-G2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `response_id_fk` (`response_id`),
  ADD KEY `question_id_fk` (`question_id`),
  ADD KEY `choice_id_fk` (`choice_id`);

--
-- Indexes for table `choice`
--
ALTER TABLE `choice`
  ADD PRIMARY KEY (`choice_id`),
  ADD KEY `question_id_fk` (`question_id`);

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`college_code`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`program_code`),
  ADD KEY `college_code` (`college_code`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `survey_id_fk` (`survey_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `survey_id_fk` (`survey_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_code`),
  ADD KEY `program_code` (`program_code`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `stud_fk` (`section_code`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`survey_id`),
  ADD KEY `survey_fk` (`faculty_id`);

--
-- Indexes for table `survey_section`
--
ALTER TABLE `survey_section`
  ADD PRIMARY KEY (`survey_id`,`section_code`),
  ADD KEY `section_code` (`section_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=451;

--
-- AUTO_INCREMENT for table `choice`
--
ALTER TABLE `choice`
  MODIFY `choice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242512;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202512;

--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `survey_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`response_id`) REFERENCES `response` (`response_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answer_ibfk_3` FOREIGN KEY (`choice_id`) REFERENCES `choice` (`choice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `choice`
--
ALTER TABLE `choice`
  ADD CONSTRAINT `choice_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `program`
--
ALTER TABLE `program`
  ADD CONSTRAINT `program_ibfk_1` FOREIGN KEY (`college_code`) REFERENCES `college` (`college_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`survey_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `response`
--
ALTER TABLE `response`
  ADD CONSTRAINT `response_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`survey_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `response_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`program_code`) REFERENCES `program` (`program_code`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`section_code`) REFERENCES `section` (`section_code`);

--
-- Constraints for table `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `survey_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`);

--
-- Constraints for table `survey_section`
--
ALTER TABLE `survey_section`
  ADD CONSTRAINT `survey_section_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`survey_id`),
  ADD CONSTRAINT `survey_section_ibfk_2` FOREIGN KEY (`section_code`) REFERENCES `section` (`section_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
