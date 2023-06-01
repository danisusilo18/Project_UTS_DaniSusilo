Create database siakad ;
CREATE TABLE `dosen` (
  `id` int(11) NOT NULL auto_increment,
  `nama` varchar(255) default NULL,
  `nidn` char(8) default NULL,
  `jenjang_pendidikan` enum('S2','S3') default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL auto_increment,
  `nama` varchar(255) default NULL,
  `nim` char(10) default NULL,
  `program_studi` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `matakuliah` (
  `id` int(11) NOT NULL auto_increment,
  `nama` varchar(255) default NULL,
  `kode_matakuliah` char(5) default NULL,
  `deskripsi` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
