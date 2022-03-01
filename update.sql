ALTER TABLE `og_report` ADD `sync` INT(5) NOT NULL DEFAULT '0' AFTER `location`;
ALTER TABLE `og_report` ADD `object_link` INT(11) NOT NULL DEFAULT '0' AFTER `sync`;
ALTER TABLE `og_subreplay_comment` ADD `sync` INT(5) NOT NULL DEFAULT '0' AFTER `file`;

--
-- Table structure for table `og_surveyitem_task`
--

CREATE TABLE `og_surveyitem_task` (
  `id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `og_surveyitem_task`
--
ALTER TABLE `og_surveyitem_task`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `og_surveyitem_task`
--