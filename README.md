# TMX-collector
Translation Memory .TMX collection tool.  It analyzes Russian text against its translation in English and then composes Translation Memory Database in .TMX format to be uploaded to Machine Translation systems such as Promt, Trados, Context.Reverso and others.

MySql table stucture:

CREATE TABLE `tmdata` (
  `id` int(11) NOT NULL,
  `direction` int(11) NOT NULL,
  `source` longtext NOT NULL,
  `target` longtext NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

direction = 0 # ru->en
direction = 1 # en->ru
