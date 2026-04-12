-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2026 at 07:23 PM
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
-- Database: `wypozyczalnia`
--

-- --------------------------------------------------------

--
-- Table structure for table `doplata`
--

CREATE TABLE `doplata` (
  `DoplataID` int(11) NOT NULL,
  `WypozyczenieID` int(11) NOT NULL,
  `TypDoplatyID` int(11) NOT NULL,
  `Opis` varchar(255) NOT NULL,
  `DataNaliczenia` date NOT NULL,
  `Kwota` decimal(10,2) NOT NULL,
  `StatusDoplatyID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metodaplatnosci`
--

CREATE TABLE `metodaplatnosci` (
  `MetodaPlatnosciID` int(11) NOT NULL,
  `MetodaPlatnosci` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metodaplatnosci`
--

INSERT INTO `metodaplatnosci` (`MetodaPlatnosciID`, `MetodaPlatnosci`) VALUES
(4, 'BLIK'),
(1, 'Gotówka'),
(2, 'Karta'),
(5, 'PayPal'),
(3, 'Przelew bankowy');

-- --------------------------------------------------------

--
-- Table structure for table `oddzial`
--

CREATE TABLE `oddzial` (
  `OddzialID` int(11) NOT NULL,
  `Nazwa` varchar(100) NOT NULL,
  `Adres` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oddzial`
--

INSERT INTO `oddzial` (`OddzialID`, `Nazwa`, `Adres`) VALUES
(1, 'Cieszyn Carenteo', 'Cieszyn ul. Ignacego Kraszewskiego 11'),
(2, 'Chybie Carenteo', 'Chybie ul. Cieszyńska 12'),
(3, 'Pszczyna Carenteo', 'Pszczyna ul. Bielska 18');

-- --------------------------------------------------------

--
-- Table structure for table `osoba`
--

CREATE TABLE `osoba` (
  `OsobaID` int(11) NOT NULL,
  `Imie` varchar(50) NOT NULL,
  `Nazwisko` varchar(100) NOT NULL,
  `DataUrodzenia` date NOT NULL,
  `PESEL` char(11) NOT NULL,
  `NrTelefonu` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Adres` varchar(255) NOT NULL,
  `NrPrawaJazdy` varchar(20) DEFAULT NULL,
  `DataWaznosciPrawaJazdy` date DEFAULT NULL,
  `DataZatrudnienia` date DEFAULT NULL,
  `Pensja` decimal(10,2) DEFAULT NULL,
  `UzytkownikID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `osoba`
--

INSERT INTO `osoba` (`OsobaID`, `Imie`, `Nazwisko`, `DataUrodzenia`, `PESEL`, `NrTelefonu`, `Email`, `Adres`, `NrPrawaJazdy`, `DataWaznosciPrawaJazdy`, `DataZatrudnienia`, `Pensja`, `UzytkownikID`) VALUES
(1, 'Jan', 'Kowalski', '1996-02-07', '96020759695', '660788524', 'jan.kowalski@gmail.com', 'Pszczyna ul. Parkowa 5', 'KRA582913', '2041-04-02', NULL, NULL, 2),
(2, 'Mariusz', 'Górski', '1991-02-07', '91020746397', '668985768', 'gorski.jan@wp.pl', 'Jasienica ul. Kościelna 7', NULL, NULL, NULL, 7000.00, 3);

-- --------------------------------------------------------

--
-- Table structure for table `platnosc`
--

CREATE TABLE `platnosc` (
  `PlatnoscID` int(11) NOT NULL,
  `WypozyczenieID` int(11) NOT NULL,
  `Kwota` decimal(10,2) NOT NULL,
  `DataPlatnosci` date DEFAULT NULL,
  `MetodaPlatnosciID` int(11) DEFAULT NULL,
  `StatusPlatnosciID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `platnosc`
--

INSERT INTO `platnosc` (`PlatnoscID`, `WypozyczenieID`, `Kwota`, `DataPlatnosci`, `MetodaPlatnosciID`, `StatusPlatnosciID`) VALUES
(1, 1, 870.00, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rola`
--

CREATE TABLE `rola` (
  `RolaID` int(11) NOT NULL,
  `Rola` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rola`
--

INSERT INTO `rola` (`RolaID`, `Rola`) VALUES
(3, 'admin'),
(1, 'klient'),
(2, 'pracownik');

-- --------------------------------------------------------

--
-- Table structure for table `samochod`
--

CREATE TABLE `samochod` (
  `SamochodID` int(11) NOT NULL,
  `Marka` varchar(50) NOT NULL,
  `Model` varchar(50) NOT NULL,
  `Kolor` varchar(30) NOT NULL,
  `TypPaliwaID` int(11) NOT NULL,
  `SkrzyniaID` int(11) NOT NULL,
  `TypNadwoziaID` int(11) NOT NULL,
  `Moc` smallint(6) NOT NULL,
  `RokProdukcji` year(4) NOT NULL,
  `CenaZaDzien` decimal(10,2) NOT NULL,
  `StatusSamochoduID` int(11) NOT NULL,
  `NrRejestracyjny` varchar(10) NOT NULL,
  `VIN` char(17) NOT NULL,
  `Przebieg` int(11) NOT NULL,
  `OddzialID` int(11) NOT NULL,
  `Opis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `samochod`
--

INSERT INTO `samochod` (`SamochodID`, `Marka`, `Model`, `Kolor`, `TypPaliwaID`, `SkrzyniaID`, `TypNadwoziaID`, `Moc`, `RokProdukcji`, `CenaZaDzien`, `StatusSamochoduID`, `NrRejestracyjny`, `VIN`, `Przebieg`, `OddzialID`, `Opis`) VALUES
(2, 'Cupra', 'Formentor 2.0 TSI', 'Czarny', 1, 2, 4, 190, '2023', 250.00, 1, 'SCI 3940J', 'VSSZZZK1ZPR892614', 23560, 2, 'Cupra Formentor 2023 to sportowy crossover klasy premium, który wyróżnia się agresywną stylistyką, świetnymi osiągami i wysokim komfortem jazdy. Pod maską znajduje się dynamiczny silnik 2.0 TSI o mocy 190 KM, współpracujący z szybką skrzynią DSG oraz napędem 4Drive, co zapewnia pewność prowadzenia w każdych warunkach. Auto przyspiesza pewnie, prowadzi się stabilnie i daje kierowcy dużą przyjemność z jazdy.\r\n\r\nWnętrze zostało zaprojektowane z myślą o ergonomii i nowoczesności — sportowe fotele, ambientowe oświetlenie, duży ekran multimedialny oraz wysokiej jakości materiały tworzą wyjątkową atmosferę. Formentor oferuje także praktyczny bagażnik o pojemności 450 litrów, dzięki czemu świetnie sprawdza się zarówno na co dzień, jak i podczas dłuższych wyjazdów.\r\n\r\nTo idealny wybór dla osób, które oczekują połączenia sportowego charakteru, komfortu i nowoczesnych technologii w jednym stylowym samochodzie.'),
(3, 'BMW', 'X3 2.0', 'Szary', 2, 2, 4, 190, '2023', 290.00, 2, 'SK 5431X', '5UX63DP06P9961396', 41520, 3, 'BMW X3 xDrive20d 2023 to SUV, który łączy sportowy charakter z elegancją klasy premium. Pod maską pracuje nowoczesny silnik 2.0 TwinPower Turbo Diesel o mocy 190 KM i 400 Nm, który zapewnia natychmiastową reakcję na gaz i dynamiczne przyspieszenie w każdej sytuacji. Napęd xDrive dba o perfekcyjną trakcję, a 8‑stopniowy automat ZF zmienia biegi płynnie i błyskawicznie, utrzymując auto w idealnym zakresie mocy.\r\n\r\nWnętrze to połączenie minimalizmu i luksusu — wysokiej jakości materiały, sportowa pozycja za kierownicą i zaawansowane systemy wsparcia kierowcy tworzą atmosferę nowoczesnego komfortu. X3 oferuje przestronny bagażnik, świetne wyciszenie kabiny i stabilność, która daje pewność zarówno w mieście, jak i na autostradzie.\r\n\r\nTo samochód dla tych, którzy chcą czuć moc, precyzję i kontrolę — bez rezygnacji z wygody i elegancji. BMW X3 2023 to idealny wybór na dłuższe trasy, rodzinne wyjazdy i dynamiczną jazdę na co dzień.');

-- --------------------------------------------------------

--
-- Table structure for table `skrzyniabiegow`
--

CREATE TABLE `skrzyniabiegow` (
  `SkrzyniaID` int(11) NOT NULL,
  `SkrzyniaBiegow` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skrzyniabiegow`
--

INSERT INTO `skrzyniabiegow` (`SkrzyniaID`, `SkrzyniaBiegow`) VALUES
(2, 'Automatyczna'),
(1, 'Manualna');

-- --------------------------------------------------------

--
-- Table structure for table `statusdoplaty`
--

CREATE TABLE `statusdoplaty` (
  `StatusDoplatyID` int(11) NOT NULL,
  `StatusDoplaty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statusdoplaty`
--

INSERT INTO `statusdoplaty` (`StatusDoplatyID`, `StatusDoplaty`) VALUES
(2, 'Nieopłacona'),
(1, 'Opłacona');

-- --------------------------------------------------------

--
-- Table structure for table `statusplatnosci`
--

CREATE TABLE `statusplatnosci` (
  `StatusPlatnosciID` int(11) NOT NULL,
  `StatusPlatnosci` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statusplatnosci`
--

INSERT INTO `statusplatnosci` (`StatusPlatnosciID`, `StatusPlatnosci`) VALUES
(2, 'Nieopłacona'),
(1, 'Opłacona');

-- --------------------------------------------------------

--
-- Table structure for table `statussamochodu`
--

CREATE TABLE `statussamochodu` (
  `StatusSamochoduID` int(11) NOT NULL,
  `StatusSamochodu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statussamochodu`
--

INSERT INTO `statussamochodu` (`StatusSamochoduID`, `StatusSamochodu`) VALUES
(1, 'Dostępny'),
(2, 'Wypożyczony');

-- --------------------------------------------------------

--
-- Table structure for table `statuswypozyczenia`
--

CREATE TABLE `statuswypozyczenia` (
  `StatusWypozyczeniaID` int(11) NOT NULL,
  `StatusWypozyczenia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statuswypozyczenia`
--

INSERT INTO `statuswypozyczenia` (`StatusWypozyczeniaID`, `StatusWypozyczenia`) VALUES
(2, 'Oddany'),
(1, 'Wypożyczony');

-- --------------------------------------------------------

--
-- Table structure for table `typdoplaty`
--

CREATE TABLE `typdoplaty` (
  `TypDoplatyID` int(11) NOT NULL,
  `TypDoplaty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `typdoplaty`
--

INSERT INTO `typdoplaty` (`TypDoplatyID`, `TypDoplaty`) VALUES
(4, 'Brak paliwa'),
(2, 'Brud'),
(1, 'Opóźnienie'),
(3, 'Uszkodzenie');

-- --------------------------------------------------------

--
-- Table structure for table `typnadwozia`
--

CREATE TABLE `typnadwozia` (
  `TypNadwoziaID` int(11) NOT NULL,
  `TypNadwozia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `typnadwozia`
--

INSERT INTO `typnadwozia` (`TypNadwoziaID`, `TypNadwozia`) VALUES
(5, 'Coupe'),
(2, 'Hatchback'),
(6, 'Kabriolet'),
(3, 'Kombi'),
(7, 'Minivan'),
(1, 'Sedan'),
(4, 'SUV');

-- --------------------------------------------------------

--
-- Table structure for table `typpaliwa`
--

CREATE TABLE `typpaliwa` (
  `TypPaliwaID` int(11) NOT NULL,
  `TypPaliwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `typpaliwa`
--

INSERT INTO `typpaliwa` (`TypPaliwaID`, `TypPaliwa`) VALUES
(1, 'Benzyna'),
(2, 'Diesel'),
(5, 'Elektryczny'),
(4, 'Hybryda'),
(3, 'LPG');

-- --------------------------------------------------------

--
-- Table structure for table `uzytkownik`
--

CREATE TABLE `uzytkownik` (
  `UzytkownikID` int(11) NOT NULL,
  `Login` varchar(100) NOT NULL,
  `Haslo` varchar(255) NOT NULL,
  `RolaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownik`
--

INSERT INTO `uzytkownik` (`UzytkownikID`, `Login`, `Haslo`, `RolaID`) VALUES
(1, 'admin', '$2y$10$NTAuM.Dzc8Chx9qZOL0Euuzt4UeA/9/moXykAIMo1uTQoU573JXr2', 3),
(2, 'jkowalski', '$2y$10$riKt07LeHg95EilWFcJGBuO8ysAcDf92Oqq76ClGBTVMu629AWmFW', 1),
(3, 'pracownik1', '$2y$10$Q8ifN33kyCFk/AMF00LPse/lp2ZoJDX5U6s.D4aCxDdMq8TcFmhm.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `wypozyczenie`
--

CREATE TABLE `wypozyczenie` (
  `WypozyczenieID` int(11) NOT NULL,
  `SamochodID` int(11) NOT NULL,
  `KlientOsobaID` int(11) NOT NULL,
  `PracownikOsobaID` int(11) DEFAULT NULL,
  `DataWypozyczenia` date NOT NULL,
  `PlanowanaDataZwrotu` date NOT NULL,
  `RzeczywistaDataZwrotu` date DEFAULT NULL,
  `StatusWypozyczeniaID` int(11) NOT NULL,
  `KosztCalkowity` decimal(10,2) NOT NULL,
  `NrUmowy` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wypozyczenie`
--

INSERT INTO `wypozyczenie` (`WypozyczenieID`, `SamochodID`, `KlientOsobaID`, `PracownikOsobaID`, `DataWypozyczenia`, `PlanowanaDataZwrotu`, `RzeczywistaDataZwrotu`, `StatusWypozyczeniaID`, `KosztCalkowity`, `NrUmowy`) VALUES
(1, 3, 1, 2, '2026-04-07', '2026-04-10', NULL, 1, 870.00, 'AGR-1775543554743-7664');

-- --------------------------------------------------------

--
-- Table structure for table `zdjeciesamochodu`
--

CREATE TABLE `zdjeciesamochodu` (
  `ZdjecieID` int(11) NOT NULL,
  `SamochodID` int(11) NOT NULL,
  `Sciezka` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zdjeciesamochodu`
--

INSERT INTO `zdjeciesamochodu` (`ZdjecieID`, `SamochodID`, `Sciezka`) VALUES
(1, 2, '/uploads/cars/69cf776b9182c_cupra1.jpg'),
(2, 2, '/uploads/cars/69cf776b90688_cupra5.jpg'),
(3, 2, '/uploads/cars/69cf776b9098a_cupra4.jpg'),
(4, 2, '/uploads/cars/69cf776b91164_cupra3.jpg'),
(5, 2, '/uploads/cars/69cf776b91504_cupra2.jpg'),
(6, 2, '/uploads/cars/69cf776b8fcef_cupra6.jpg'),
(7, 3, '/uploads/cars/69d2a31cbbd7d_x3_5.jpg'),
(8, 3, '/uploads/cars/69d2a31cbc234_x3_4.jpg'),
(9, 3, '/uploads/cars/69d2a31cbc598_x3_3.jpg'),
(10, 3, '/uploads/cars/69d2a31cbd39d_x3_2.jpg'),
(11, 3, '/uploads/cars/69d2a31cbd81a_x3_1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doplata`
--
ALTER TABLE `doplata`
  ADD PRIMARY KEY (`DoplataID`),
  ADD KEY `WypozyczenieID` (`WypozyczenieID`),
  ADD KEY `TypDoplatyID` (`TypDoplatyID`),
  ADD KEY `StatusDoplatyID` (`StatusDoplatyID`);

--
-- Indexes for table `metodaplatnosci`
--
ALTER TABLE `metodaplatnosci`
  ADD PRIMARY KEY (`MetodaPlatnosciID`),
  ADD UNIQUE KEY `MetodaPlatnosci` (`MetodaPlatnosci`);

--
-- Indexes for table `oddzial`
--
ALTER TABLE `oddzial`
  ADD PRIMARY KEY (`OddzialID`),
  ADD UNIQUE KEY `Adres` (`Adres`);

--
-- Indexes for table `osoba`
--
ALTER TABLE `osoba`
  ADD PRIMARY KEY (`OsobaID`),
  ADD UNIQUE KEY `PESEL` (`PESEL`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `UzytkownikID` (`UzytkownikID`);

--
-- Indexes for table `platnosc`
--
ALTER TABLE `platnosc`
  ADD PRIMARY KEY (`PlatnoscID`),
  ADD KEY `WypozyczenieID` (`WypozyczenieID`),
  ADD KEY `MetodaPlatnosciID` (`MetodaPlatnosciID`),
  ADD KEY `StatusPlatnosciID` (`StatusPlatnosciID`);

--
-- Indexes for table `rola`
--
ALTER TABLE `rola`
  ADD PRIMARY KEY (`RolaID`),
  ADD UNIQUE KEY `Rola` (`Rola`);

--
-- Indexes for table `samochod`
--
ALTER TABLE `samochod`
  ADD PRIMARY KEY (`SamochodID`),
  ADD UNIQUE KEY `NrRejestracyjny` (`NrRejestracyjny`),
  ADD UNIQUE KEY `VIN` (`VIN`),
  ADD KEY `TypPaliwaID` (`TypPaliwaID`),
  ADD KEY `SkrzyniaID` (`SkrzyniaID`),
  ADD KEY `TypNadwoziaID` (`TypNadwoziaID`),
  ADD KEY `StatusSamochoduID` (`StatusSamochoduID`),
  ADD KEY `OddzialID` (`OddzialID`);

--
-- Indexes for table `skrzyniabiegow`
--
ALTER TABLE `skrzyniabiegow`
  ADD PRIMARY KEY (`SkrzyniaID`),
  ADD UNIQUE KEY `SkrzyniaBiegow` (`SkrzyniaBiegow`);

--
-- Indexes for table `statusdoplaty`
--
ALTER TABLE `statusdoplaty`
  ADD PRIMARY KEY (`StatusDoplatyID`),
  ADD UNIQUE KEY `StatusDoplaty` (`StatusDoplaty`);

--
-- Indexes for table `statusplatnosci`
--
ALTER TABLE `statusplatnosci`
  ADD PRIMARY KEY (`StatusPlatnosciID`),
  ADD UNIQUE KEY `StatusPlatnosci` (`StatusPlatnosci`);

--
-- Indexes for table `statussamochodu`
--
ALTER TABLE `statussamochodu`
  ADD PRIMARY KEY (`StatusSamochoduID`),
  ADD UNIQUE KEY `StatusSamochodu` (`StatusSamochodu`);

--
-- Indexes for table `statuswypozyczenia`
--
ALTER TABLE `statuswypozyczenia`
  ADD PRIMARY KEY (`StatusWypozyczeniaID`),
  ADD UNIQUE KEY `StatusWypozyczenia` (`StatusWypozyczenia`);

--
-- Indexes for table `typdoplaty`
--
ALTER TABLE `typdoplaty`
  ADD PRIMARY KEY (`TypDoplatyID`),
  ADD UNIQUE KEY `TypDoplaty` (`TypDoplaty`);

--
-- Indexes for table `typnadwozia`
--
ALTER TABLE `typnadwozia`
  ADD PRIMARY KEY (`TypNadwoziaID`),
  ADD UNIQUE KEY `TypNadwozia` (`TypNadwozia`);

--
-- Indexes for table `typpaliwa`
--
ALTER TABLE `typpaliwa`
  ADD PRIMARY KEY (`TypPaliwaID`),
  ADD UNIQUE KEY `TypPaliwa` (`TypPaliwa`);

--
-- Indexes for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD PRIMARY KEY (`UzytkownikID`),
  ADD UNIQUE KEY `Login` (`Login`),
  ADD KEY `RolaID` (`RolaID`);

--
-- Indexes for table `wypozyczenie`
--
ALTER TABLE `wypozyczenie`
  ADD PRIMARY KEY (`WypozyczenieID`),
  ADD UNIQUE KEY `NrUmowy` (`NrUmowy`),
  ADD KEY `SamochodID` (`SamochodID`),
  ADD KEY `KlientOsobaID` (`KlientOsobaID`),
  ADD KEY `PracownikOsobaID` (`PracownikOsobaID`),
  ADD KEY `StatusWypozyczeniaID` (`StatusWypozyczeniaID`);

--
-- Indexes for table `zdjeciesamochodu`
--
ALTER TABLE `zdjeciesamochodu`
  ADD PRIMARY KEY (`ZdjecieID`),
  ADD KEY `SamochodID` (`SamochodID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doplata`
--
ALTER TABLE `doplata`
  MODIFY `DoplataID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metodaplatnosci`
--
ALTER TABLE `metodaplatnosci`
  MODIFY `MetodaPlatnosciID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `oddzial`
--
ALTER TABLE `oddzial`
  MODIFY `OddzialID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `osoba`
--
ALTER TABLE `osoba`
  MODIFY `OsobaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `platnosc`
--
ALTER TABLE `platnosc`
  MODIFY `PlatnoscID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rola`
--
ALTER TABLE `rola`
  MODIFY `RolaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `samochod`
--
ALTER TABLE `samochod`
  MODIFY `SamochodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skrzyniabiegow`
--
ALTER TABLE `skrzyniabiegow`
  MODIFY `SkrzyniaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `statusdoplaty`
--
ALTER TABLE `statusdoplaty`
  MODIFY `StatusDoplatyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `statusplatnosci`
--
ALTER TABLE `statusplatnosci`
  MODIFY `StatusPlatnosciID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `statussamochodu`
--
ALTER TABLE `statussamochodu`
  MODIFY `StatusSamochoduID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `statuswypozyczenia`
--
ALTER TABLE `statuswypozyczenia`
  MODIFY `StatusWypozyczeniaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `typdoplaty`
--
ALTER TABLE `typdoplaty`
  MODIFY `TypDoplatyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `typnadwozia`
--
ALTER TABLE `typnadwozia`
  MODIFY `TypNadwoziaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `typpaliwa`
--
ALTER TABLE `typpaliwa`
  MODIFY `TypPaliwaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  MODIFY `UzytkownikID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wypozyczenie`
--
ALTER TABLE `wypozyczenie`
  MODIFY `WypozyczenieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zdjeciesamochodu`
--
ALTER TABLE `zdjeciesamochodu`
  MODIFY `ZdjecieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doplata`
--
ALTER TABLE `doplata`
  ADD CONSTRAINT `doplata_ibfk_1` FOREIGN KEY (`WypozyczenieID`) REFERENCES `wypozyczenie` (`WypozyczenieID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `doplata_ibfk_2` FOREIGN KEY (`TypDoplatyID`) REFERENCES `typdoplaty` (`TypDoplatyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `doplata_ibfk_3` FOREIGN KEY (`StatusDoplatyID`) REFERENCES `statusdoplaty` (`StatusDoplatyID`) ON UPDATE CASCADE;

--
-- Constraints for table `osoba`
--
ALTER TABLE `osoba`
  ADD CONSTRAINT `osoba_ibfk_1` FOREIGN KEY (`UzytkownikID`) REFERENCES `uzytkownik` (`UzytkownikID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `platnosc`
--
ALTER TABLE `platnosc`
  ADD CONSTRAINT `platnosc_ibfk_1` FOREIGN KEY (`WypozyczenieID`) REFERENCES `wypozyczenie` (`WypozyczenieID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `platnosc_ibfk_2` FOREIGN KEY (`MetodaPlatnosciID`) REFERENCES `metodaplatnosci` (`MetodaPlatnosciID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `platnosc_ibfk_3` FOREIGN KEY (`StatusPlatnosciID`) REFERENCES `statusplatnosci` (`StatusPlatnosciID`) ON UPDATE CASCADE;

--
-- Constraints for table `samochod`
--
ALTER TABLE `samochod`
  ADD CONSTRAINT `samochod_ibfk_1` FOREIGN KEY (`TypPaliwaID`) REFERENCES `typpaliwa` (`TypPaliwaID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `samochod_ibfk_2` FOREIGN KEY (`SkrzyniaID`) REFERENCES `skrzyniabiegow` (`SkrzyniaID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `samochod_ibfk_3` FOREIGN KEY (`TypNadwoziaID`) REFERENCES `typnadwozia` (`TypNadwoziaID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `samochod_ibfk_4` FOREIGN KEY (`StatusSamochoduID`) REFERENCES `statussamochodu` (`StatusSamochoduID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `samochod_ibfk_5` FOREIGN KEY (`OddzialID`) REFERENCES `oddzial` (`OddzialID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD CONSTRAINT `uzytkownik_ibfk_1` FOREIGN KEY (`RolaID`) REFERENCES `rola` (`RolaID`) ON UPDATE CASCADE;

--
-- Constraints for table `wypozyczenie`
--
ALTER TABLE `wypozyczenie`
  ADD CONSTRAINT `wypozyczenie_ibfk_1` FOREIGN KEY (`SamochodID`) REFERENCES `samochod` (`SamochodID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wypozyczenie_ibfk_2` FOREIGN KEY (`KlientOsobaID`) REFERENCES `osoba` (`OsobaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wypozyczenie_ibfk_3` FOREIGN KEY (`PracownikOsobaID`) REFERENCES `osoba` (`OsobaID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `wypozyczenie_ibfk_4` FOREIGN KEY (`StatusWypozyczeniaID`) REFERENCES `statuswypozyczenia` (`StatusWypozyczeniaID`) ON UPDATE CASCADE;

--
-- Constraints for table `zdjeciesamochodu`
--
ALTER TABLE `zdjeciesamochodu`
  ADD CONSTRAINT `zdjeciesamochodu_ibfk_1` FOREIGN KEY (`SamochodID`) REFERENCES `samochod` (`SamochodID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
