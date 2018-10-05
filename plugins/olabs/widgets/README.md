- Dynamically add report widgets to user dashboard
- Widget should support html as well as php contents
- Add permission to manage widgets

- Widget Property is set by all active custom widgets saved in database

- Report widget permission set to manage : Access to manage custom widgets


- DB Updates

--
-- Table structure for table `olabs_widgets_reportwidgets`
--

CREATE TABLE `olabs_widgets_reportwidgets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `olabs_widgets_reportwidgets`
--
ALTER TABLE `olabs_widgets_reportwidgets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `olabs_widgets_reportwidgets`
--
ALTER TABLE `olabs_widgets_reportwidgets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

