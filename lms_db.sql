-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 25 Haz 2024, 16:34:07
-- Sunucu sürümü: 10.4.21-MariaDB
-- PHP Sürümü: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `lms_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `announcements`
--

INSERT INTO `announcements` (`id`, `course_id`, `teacher_id`, `title`, `content`, `created_at`) VALUES
(1, 9, 11, 'D', 'Derse gelmeyeni birakirim ona gore hadi gelin', '2024-06-19 08:59:46'),
(2, 6, 20, '23', 'enrzer', '2024-06-19 09:06:17'),
(13, 8, 20, '22', 'yarın ders olmayacak', '2024-06-19 23:25:47'),
(14, 19, 25, 'Mantık Tasarım', 'Haftaya Ders olmayacak', '2024-06-21 20:01:47'),
(15, 21, 30, 'Fizik 2 ', 'Haftaya Ders olmayacak', '2024-06-24 20:46:47'),
(16, 22, 32, 'Türk Dili ', 'haftaya Ders Olmayacak', '2024-06-24 21:15:41');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `assignment_title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `assignments`
--

INSERT INTO `assignments` (`id`, `course_id`, `assignment_title`, `file_path`, `description`, `created_at`, `start_date`, `end_date`, `teacher_id`) VALUES
(50, 6, 'asss', '../uploads/shell-for.txt.txt', 'S', '2024-06-17 09:27:05', '2024-06-17', '2024-06-29', 20),
(52, 9, 'df', '../uploads/semaphore_counting_py.txt.txt', 'ukyu', '2024-06-19 08:50:46', '2024-06-19', '2024-06-27', 11),
(58, 6, 'Bitirme Projesi', '../uploads/commands-3.txt.txt', 'proje raporu ve kodları olmak üzere 2 farklı dosya sisteme yükleyecektir', '2024-06-19 23:44:29', '2024-06-20', '2024-06-27', 20),
(60, 19, 'Proje ', '../uploads/ödev.docx', 'Henüz ödev yüklemedi', '2024-06-21 20:43:54', '2024-06-21', '2024-06-23', 25),
(59, 19, 'kod çözücüler (decoder)', '../uploads/ödev mantık.docx', 'henüz ödev yüklememiş', '2024-06-21 19:59:50', '2024-06-21', '2024-06-27', 25),
(61, 21, ' elektrik alan çizgileri', '../uploads/ödev.docx', 'henüz ödev yüklemedi', '2024-06-24 20:31:56', '2024-06-24', '2024-06-27', 30),
(62, 22, 'il-ulus-dil-düşünce ve dil-kültür ilişkisi', '../uploads/ödev.docx', 'Henuz ödev yülemedi', '2024-06-24 21:14:50', '2024-06-25', '2024-06-26', 32);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `assignment_submissions`
--

INSERT INTO `assignment_submissions` (`id`, `assignment_id`, `student_id`, `file_path`, `submitted_at`) VALUES
(1, 50, 16, 'semaphore_binary_with_py.txt.txt', '2024-06-18 09:06:55'),
(2, 59, 26, 'İşletim-Sistemleri-Ders-Notu.pdf', '2024-06-21 20:06:29'),
(3, 61, 29, 'ödevi.docx', '2024-06-24 20:51:52');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `course_description`) VALUES
(2, 'Veri Yapıları ve Algoritmalar', 'Veri yapıları (listeler, yığınlar, kuyruklar, ağaçlar, grafikler) ve bunların algoritmalarla etkin kullanımı.'),
(3, 'Yazılım Mühendisliği', 'Yazılım geliştirme yaşam döngüsü, proje yönetimi, tasarım desenleri ve yazılım kalite güvencesi'),
(4, 'Bilgisayar Ağları', 'Ağ protokolleri, TCP/IP, ağ katmanları, yönlendirme ve veri iletimi'),
(5, 'Veritabanı Yönetim Sistemleri', 'SQL, veritabanı tasarımı, normalizasyon ve veritabanı yönetimi.'),
(6, 'İşletim Sistemleri', 'İşlem yönetimi, bellek yönetimi, dosya sistemleri ve işletim sistemlerinin genel yapısı. '),
(7, 'Yapay Zeka', 'Makine öğrenimi, doğal dil işleme, arama algoritmaları ve yapay sinir ağları.'),
(8, 'Bilgisayar Mimarisi', 'Bilgisayar donanımı, işlemci tasarımı, bellek hiyerarşisi ve giriş/çıkış sistemleri.'),
(9, 'Programlama Dilleri', 'Farklı programlama paradigmalari, dil tasarımı ve derleyici teorisi.'),
(10, 'Siber Güvenlik', 'Şifreleme, ağ güvenliği, saldırı tespit sistemleri ve güvenlik politikaları'),
(11, 'Web Teknolojileri', 'HTML, CSS, JavaScript, web sunucuları ve istemci-sunucu mimarisi.'),
(12, 'Mobil Uygulama Geliştirme', 'iOS ve Android için uygulama geliştirme, kullanıcı arayüzü tasarımı ve mobil mimariler.'),
(13, 'Bulut Bilişim', 'Bulut hizmet modelleri, sanallaştırma, konteynerizasyon ve bulut güvenliği.'),
(14, 'Robotik', 'Robot kontrol sistemleri, sensörler, aktüatörler ve otonom sistemler.'),
(15, 'Veri Bilimi ve Analitiği', 'Büyük veri analizi, veri görselleştirme, veri madenciliği ve istatistiksel analiz.'),
(17, 'Gömülü Sistemler', 'Mikrodenetleyiciler, gömülü yazılım geliştirme, gerçek zamanlı işletim sistemleri ve sensör entegrasyonu.'),
(19, 'Mantık Tasarım', 'Karnaugh Haritaları, Lojiğin sadeleştirilmesi ve optimizasyonu için kullanılan grafik yöntem.'),
(20, 'Oyun programlama', 'Sayfa ve kenar kaydırma algoritmaları; Sprite ve bitmap animasyonu; Çakışma Tespiti; Fizik tabanlı modelleme'),
(21, 'Fızık 2', 'lektrik yükü, elektriksel kuvvet ve Coulomb yasası, elektrik alan çizgileri, noktasal yükün elektrik \r\nalanı, elektrik dipolün elektrik alanı, sürekli yük dağılımların elektrik alanı, elektrik alan içinde noktasal yükün \r\ndavranışı, elektrik alan içinde dipol, Gauss yasası; '),
(22, 'Türk Dili I', 'Dilin tanımı, özellikleri, dil-ulus-dil-düşünce ve dil-kültür ilişkisi. Yeryüzündeki diller. Türk dilinin bu \r\ndiller arasındaki yeri ve tarihsel gelişimi.'),
(23, 'Yabancı Dil I', 'Ders üniversite öğrencilerine dil becerilerini geliştirmede yardımcı olacak gerçek iletişim becerilerini \r\ngösteren sınıf içi aktiviteleri kapsar');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `course_files`
--

CREATE TABLE `course_files` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `week` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `course_files`
--

INSERT INTO `course_files` (`id`, `course_id`, `week`, `file_path`, `description`) VALUES
(1, 9, 1, '../uploads/course_9_week_1.pdf', NULL),
(2, 9, 1, '../uploads/course_9_week_1.pdf', NULL),
(9, 6, 1, '../uploads/course_6_week_1_race_cond_below_39_py.txt.txt', 'Ders tanitimi'),
(10, 13, 3, '../uploads/course_13_week_3_semaphore_counting_py.txt.txt', 'csdnvjsnv'),
(12, 6, 2, '../uploads/course_6_week_2_İşletim-Sistemleri-Ders-Notu.pdf', 'Donanım (CPU, Bellek, G/Ç Aygıtları),'),
(13, 10, 1, '../uploads/course_10_week_1_İşletim-Sistemleri-Ders-Notu.pdf', 'Bilişim temeleri'),
(14, 10, 2, '../uploads/course_10_week_2_Ders-4.pdf.pdf.pdf', 'kriptografiye Giriş ve Güvenlik'),
(15, 10, 3, '../uploads/course_10_week_3_Ders-7.pdf (3).pdf', 'Ağ ve web Güvenliği'),
(16, 19, 1, '../uploads/course_19_week_1_Sayısal Tasarım Ders Notları-1.pdf', 'kod çözücüler (decoder), çoğullayışılar (Multiplexer), kodlayıcılar, geri besleme ile sayısal \r\nmantık,'),
(18, 21, 1, '../uploads/course_21_week_1_Sayısal Tasarım Ders Notları-1.pdf', 'elektriksel kuvvet ve Coulomb yasası, elektrik alan çizgileri, noktasal yükün elektrik \r\nalanı,');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student_courses`
--

CREATE TABLE `student_courses` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` enum('pending','approved') DEFAULT 'pending'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `student_courses`
--

INSERT INTO `student_courses` (`id`, `student_id`, `course_id`, `status`) VALUES
(1, 16, 2, 'approved'),
(2, 16, 3, 'pending'),
(3, 16, 6, 'approved'),
(4, 22, 14, 'approved'),
(5, 22, 7, 'approved'),
(6, 22, 17, 'approved'),
(7, 22, 10, 'approved'),
(8, 26, 19, 'approved'),
(9, 26, 11, 'approved'),
(10, 29, 21, 'approved'),
(11, 31, 22, 'approved'),
(12, 31, 23, 'approved');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teacher_courses`
--
-- lms_db.teacher_courses tablosu için yapı okuma hatası: #144 - Table '.\lms_db\teacher_courses' is marked as crashed and last (automatic?) repair failed
-- lms_db.teacher_courses tablosu için veri okuma hatası: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `lms_db`.`teacher_courses`' at line 1

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'Dr.Ayla KAYABAS', '$2y$10$p5166.zV7uMc.juzaZwA/.FsBjVTX3J2L.JHPSBLZVepfmwJyx55m', 'teacher'),
(12, 'Ahmet Yılmaz', '$2y$10$CgfD6ugYOQJpdImC4wrn9uIlVabgKib3zsaltO2FGh43zo/LgKqLu', 'admin'),
(4, 'Mehmet Kaya ', '$2y$10$Kdqqhxd.mQCzF8WqeOfXc.jgZHO4rQ45R7fOlECdhKABAWhOBdXd.', 'student'),
(5, 'Sidi Mohamed', '$2y$10$bXabcnlR2xgW6eHEMWhnY.chvi9fw5IlbAzBdX2N5e.EHzvmHD2Xa', 'student'),
(6, 'Ethmane', '$2y$10$xZNObUfFEF1q3ccm1uP0u.RhmMAntD1r/SHWB4cstF009Mdoa0U7m', 'admin'),
(20, 'Dr. Volkan Gunes', '$2y$10$pL8Q2CGSoUvUYT2DsxQjouCadYH8yFTEXR.y3O9sXMexwCv9ESdrq', 'teacher'),
(14, 'Dr. Hüseyin Yıldırım', '$2y$10$kDd.9Wx1lnf/SMi25oj3OeyGweInmLzHoKD8mBr/AntXlRlAfrK2e', 'teacher'),
(9, 'Ahmed Elmouna', '$2y$10$taKkQm/r7AzZcFhHcV8H5eGHifUxCg/fvez9mPfPYGwTf2GS61mgu', 'student'),
(10, 'Ahmed Elmouna', '$2y$10$z3.E7yoQh3Zz2ltR4vlt/.SAFQz/pZf0./YJBUxsCVEDKdpiCMfNa', 'student'),
(11, 'Dr. Firat Atas', '$2y$10$rrpCOyn4r9c7XHvxj.osBObci8L2yelXs4WO0lfcnu5ek6oj6ntCq', 'teacher'),
(15, 'Dr.Seda Karaca', '$2y$10$PbDYQm8bm2QNNeoD.gzWAuYTOKS.rsAgEzmR.o7jlsWV0VGQBcDb.', 'teacher'),
(16, 'Merve Kaplan', '$2y$10$K52.OJ3WN2jyVnJFdyPCuuNvNjvIl6NuQQ5z6JW8YjLWJyBvnJKfm', 'student'),
(17, 'Elif Kılıç', '$2y$10$3I0odwtbSKrWrxBuZUVkG.Vup2vnkT.eZTCLKaVDBnP3Xvug5bRWC', 'student'),
(18, 'Cemal Taş', '$2y$10$IN9yj281cgPHHGuiYFu41OJQbGKlKmGEk3vSWP7DzoTBdOlbzgJWO', 'student'),
(19, 'Sibel Keskin', '$2y$10$IOrwEGAubma382yxnsRwTe3YCfPh6p4EnJObWtLutghhqqGnZfVJ6', 'student'),
(21, 'Dr.Mehmet Ali Yalçınkaya', '$2y$10$MmnS5oeruqmHHSPjDerCMe6QYDeL.HTrpYOxUYAN3lmjfDXp56k7a', 'teacher'),
(22, 'Samet Yılmaz', '$2y$10$cbnzW.WLwjD4uf0yoB/qbOFwV3rlAwTp0s2rCiZGxhalwXhMG34x.', 'student'),
(23, 'Dr.Mustafa Yağıcı', '$2y$10$Etz9wkKZbuM.NZ9Jy.uOc.0f0ULixhXOLUJ8yo6631VMXABTPb5PK', 'teacher'),
(27, 'Dr.İbrahim ŞALANIP', '$2y$10$/65FQ8cW.J2.C71UcCoWZugt3NLhXCtx2gLoZ30xlPVYoHrbmvn/q', 'teacher'),
(25, 'Dr.Murat İşık', '$2y$10$StTB2uljeqFDNYhtVs5Kqe9.4J037b2Li.5s1j2gGJzQzhGeKDq/i', 'teacher'),
(26, 'Mehmet can', '$2y$10$fKW9MnLXZH3tJ.7Jc5BTve3JpWtxHAZc4o2qmoA7856WBy7X8RB/i', 'student'),
(28, 'Dr.Mustafa AkSU', '$2y$10$3YMcl4wA0GkArE9HeXAkXutFGy6zz0tgQZIcbPVGF.CjoVnUj24OW', 'admin'),
(29, 'khadıj Kerım', '$2y$10$lXpTuWjF.Ecaq4KaTBo9luhDBTjpO/4A2y.pVDkfEYzyu.AUGfyw2', 'student'),
(30, 'Dr.Ahmet Amar ', '$2y$10$/Eg7up.AIY.K5VQ3L6PftuotuGgWNWERLS6ic8yYR1C5UKyyEqWIa', 'teacher'),
(31, 'Ahmet kaya', '$2y$10$pOjJ.CR0UzaZibZC3kKCJuqCHW1XCg8xWnktNbYTYHG1ud.2MymtS', 'student'),
(32, 'Dr.Ali Can', '$2y$10$HTi7qEJjRh5fR0H4M3/fwOZAJQJ7res8tE5y1lvSEnuFsVavHGNu2', 'teacher');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Tablo için indeksler `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Tablo için indeksler `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Tablo için indeksler `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `course_files`
--
ALTER TABLE `course_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Tablo için indeksler `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Tablo için AUTO_INCREMENT değeri `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `course_files`
--
ALTER TABLE `course_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `student_courses`
--
ALTER TABLE `student_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
