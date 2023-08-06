-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 06 2023 г., 13:28
-- Версия сервера: 8.0.30
-- Версия PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `my_project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `author_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `author_id`, `name`, `text`, `created_at`) VALUES
(1, 1, 'Про прогулки', '<h1>XZXZXZZXZ</h1>Прогулки на свежем воздухе - одна из самых доступных и эффективных форм физической активности, которая приносит множество пользы для здоровья и общего благополучия. Во-первых, свежий воздух наполняет легкие кислородом, улучшает их функционирование и способствует более эффективному кровообращению. Это помогает укрепить иммунную систему и повысить уровень энергии.\r\n\r\nПрогулки на свежем воздухе также способствуют улучшению настроения и снижению уровня стресса. Контакт с природой и естественной красотой окружающей среды помогает расслабиться, снять напряжение и улучшить психическое самочувствие. Это особенно полезно в современном мире, где мы постоянно подвергаемся стрессу и напряжению.\r\n\r\nКроме того, прогулки на свежем воздухе способствуют физической активности, помогают поддерживать здоровый вес и укреплять мышцы. Они также благотворно влияют на сердечно-сосудистую систему, снижая риск развития сердечно-сосудистых заболеваний.\r\n\r\nВ целом, регулярные прогулки на свежем воздухе - это простой и доступный способ улучшить здоровье и общее самочувствие. Они помогают поддерживать физическую форму, снять стресс и насладиться природой вокруг нас. Поэтому не упускайте возможность выйти на улицу и насладиться пользой прогулок на свежем воздухе для вашего тела и души.', '2023-06-12 18:02:07'),
(2, 1, 'Новое название статьи', 'Новый текст статьи', '2023-06-12 18:02:07'),
(3, 2, 'name', 'text', '2023-06-12 18:02:07'),
(4, 2, 'name', 'text', '2023-06-12 18:02:07'),
(5, 2, 'name', 'text', '2023-06-12 18:02:07'),
(6, 2, 'name', 'text', '2023-06-12 18:02:07'),
(8, 1, 'Новая статья1 name', 'Новая статья1 text', '2023-06-28 21:52:19'),
(9, 1, 'Новая статья1 name', 'Новая статья1 text', '2023-06-28 21:59:03'),
(10, 1, 'Новая статья1 name', 'Новая статья1 text', '2023-06-28 22:11:08'),
(11, 1, 'Новая статья1 name', 'Новая статья1 text', '2023-06-28 22:14:06'),
(13, 32, 'Новая статья моя', 'ывафывпварывапрыа', '2023-07-07 16:45:11'),
(14, 32, 'Новая статья моя 2', 'ывафывпварывапрыаsdfds', '2023-07-07 16:46:20'),
(15, 32, 'Новая статья моя 3', 'ывафывпварывапрыаsdfds', '2023-07-07 18:06:56'),
(16, 32, 'Новая статья моя 3', 'ывафывпварывапрыаsdfds', '2023-07-07 18:07:01'),
(17, 32, 'Новая статья моя 31243', 'ывафывпварывапрыаsdfds123123', '2023-07-07 18:07:03');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `author_id` int DEFAULT NULL,
  `article_id` int DEFAULT NULL,
  `comment_text` text,
  `publication_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `author_id`, `article_id`, `comment_text`, `publication_date`) VALUES
(6, 32, 1, 'dfgdsfg', '2023-07-08 14:59:10'),
(7, 32, 2, 'sdfs', '2023-07-09 08:50:10'),
(8, 32, 2, 'sdfs', '2023-07-09 08:53:28'),
(10, 32, 2, 'Очень клевая статья, мне нравится\r\n', '2023-07-09 09:22:55'),
(14, 33, 19, 'Крутая статья, осмысленная', '2023-07-09 13:52:19');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nickname` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `role` enum('admin','user') NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `nickname`, `email`, `is_confirmed`, `role`, `password_hash`, `auth_token`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', 1, 'admin', 'hash1', 'token1', '2023-06-12 18:01:38'),
(2, 'user', 'user@gmail.com', 1, 'user', 'hash2', 'token2', '2023-06-12 18:01:38'),
(3, 'nick', 'mimi@asdkl;m', 1, 'user', 'dsfds', 'fff', '2023-06-28 21:58:22'),
(30, 'test', 'test@gmail.com', 1, 'user', '$2y$10$ssstJ0RsB5hskgdAQOuIne6oyBGstxS/6XguNQzEoNJeTIngKkR3q', '0aec9d0adef5f8b1055b7defab63daab69573e6defc3de8aeabd814434e3c0c1a8bf3359d2703956', '2023-07-07 12:21:59'),
(32, 'miron', 'mirfees@gmail.com', 1, 'admin', '$2y$10$pb38DHcJ23wG5t78.FkEGup/cX4SX9AUmRme4HmFNeTZoD6Vd5vZq', '52b86c73a444065c321c087725860423efbdce427b4db39fa06f73f2576f9b23f87d33fe4c189dd3', '2023-07-07 13:17:49'),
(33, 'mirfees', 'mirfees.co@gmail.com', 1, 'user', '$2y$10$Ahv.g0ex75jfm2xkbhlt5uOmzie73OgldxeQF2f2GchmjSfc6ODJa', '4306c085b36923b6abae1a0d2896f8b2c2812180059c931feedbb7a59caedaf18c12503c814b1f2a', '2023-07-09 15:14:44');

-- --------------------------------------------------------

--
-- Структура таблицы `users_activation_codes`
--

CREATE TABLE `users_activation_codes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users_activation_codes`
--

INSERT INTO `users_activation_codes` (`id`, `user_id`, `code`) VALUES
(13, 29, '881df5762541135301613d32bf5c2423'),
(14, 30, '6b11ab3e6f5b7d09c8f3580335b0126e');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `users_activation_codes`
--
ALTER TABLE `users_activation_codes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `users_activation_codes`
--
ALTER TABLE `users_activation_codes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
