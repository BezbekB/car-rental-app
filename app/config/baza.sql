CREATE DATABASE IF NOT EXISTS wypozyczalnia;
USE wypozyczalnia;

CREATE TABLE Rola (
    RolaID INT AUTO_INCREMENT PRIMARY KEY,
    Rola VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE TypPaliwa (
    TypPaliwaID INT AUTO_INCREMENT PRIMARY KEY,
    TypPaliwa VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE SkrzyniaBiegow (
    SkrzyniaID INT AUTO_INCREMENT PRIMARY KEY,
    SkrzyniaBiegow VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE TypNadwozia (
    TypNadwoziaID INT AUTO_INCREMENT PRIMARY KEY,
    TypNadwozia VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE StatusSamochodu (
    StatusSamochoduID INT AUTO_INCREMENT PRIMARY KEY,
    StatusSamochodu VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE StatusWypozyczenia (
    StatusWypozyczeniaID INT AUTO_INCREMENT PRIMARY KEY,
    StatusWypozyczenia VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE StatusPlatnosci (
    StatusPlatnosciID INT AUTO_INCREMENT PRIMARY KEY,
    StatusPlatnosci VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE MetodaPlatnosci (
    MetodaPlatnosciID INT AUTO_INCREMENT PRIMARY KEY,
    MetodaPlatnosci VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE TypDoplaty (
    TypDoplatyID INT AUTO_INCREMENT PRIMARY KEY,
    TypDoplaty VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE StatusDoplaty (
    StatusDoplatyID INT AUTO_INCREMENT PRIMARY KEY,
    StatusDoplaty VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Oddzial (
    OddzialID INT AUTO_INCREMENT PRIMARY KEY,
    Nazwa VARCHAR(100) NOT NULL,
    Adres VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE Uzytkownik (
    UzytkownikID INT AUTO_INCREMENT PRIMARY KEY,
    Login VARCHAR(100) UNIQUE NOT NULL,
    Haslo VARCHAR(255) NOT NULL,
    RolaID INT NOT NULL,
    FOREIGN KEY (RolaID) REFERENCES Rola(RolaID)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE Osoba (
    OsobaID INT AUTO_INCREMENT PRIMARY KEY,
    Imie VARCHAR(50) NOT NULL,
    Nazwisko VARCHAR(100) NOT NULL,
    DataUrodzenia DATE NOT NULL,
    PESEL CHAR(11) UNIQUE NOT NULL,
    NrTelefonu VARCHAR(15) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Adres VARCHAR(255) NOT NULL,
    NrPrawaJazdy VARCHAR(20),
    DataWaznosciPrawaJazdy DATE,
    DataZatrudnienia DATE,
    Pensja DECIMAL(10,2),
    UzytkownikID INT UNIQUE,
    FOREIGN KEY (UzytkownikID) REFERENCES Uzytkownik(UzytkownikID)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE Samochod (
    SamochodID INT AUTO_INCREMENT PRIMARY KEY,
    Marka VARCHAR(50) NOT NULL,
    Model VARCHAR(50) NOT NULL,
    Kolor VARCHAR(30) NOT NULL,
    TypPaliwaID INT NOT NULL,
    SkrzyniaID INT NOT NULL,
    TypNadwoziaID INT NOT NULL,
    Moc SMALLINT NOT NULL,
    RokProdukcji YEAR NOT NULL,
    CenaZaDzien DECIMAL(10,2) NOT NULL,
    StatusSamochoduID INT NOT NULL,
    NrRejestracyjny VARCHAR(10) UNIQUE NOT NULL,
    VIN CHAR(17) UNIQUE NOT NULL,
    Przebieg INT NOT NULL,
    OddzialID INT NOT NULL,

    FOREIGN KEY (TypPaliwaID) REFERENCES TypPaliwa(TypPaliwaID) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (SkrzyniaID) REFERENCES SkrzyniaBiegow(SkrzyniaID) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (TypNadwoziaID) REFERENCES TypNadwozia(TypNadwoziaID) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (StatusSamochoduID) REFERENCES StatusSamochodu(StatusSamochoduID) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (OddzialID) REFERENCES Oddzial(OddzialID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Wypozyczenie (
    WypozyczenieID INT AUTO_INCREMENT PRIMARY KEY,
    SamochodID INT NOT NULL,
    KlientOsobaID INT NOT NULL,
    PracownikOsobaID INT NULL,
    DataWypozyczenia DATE NOT NULL,
    PlanowanaDataZwrotu DATE NOT NULL,
    RzeczywistaDataZwrotu DATE,
    StatusWypozyczeniaID INT NOT NULL,
    KosztCalkowity DECIMAL(10,2) NOT NULL,
    NrUmowy VARCHAR(30) UNIQUE NOT NULL,

    FOREIGN KEY (SamochodID) REFERENCES Samochod(SamochodID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (KlientOsobaID) REFERENCES Osoba(OsobaID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (PracownikOsobaID) REFERENCES Osoba(OsobaID)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    FOREIGN KEY (StatusWypozyczeniaID) REFERENCES StatusWypozyczenia(StatusWypozyczeniaID)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE Platnosc (
    PlatnoscID INT AUTO_INCREMENT PRIMARY KEY,
    WypozyczenieID INT NOT NULL,
    Kwota DECIMAL(10,2) NOT NULL,
    DataPlatnosci DATE NOT NULL,
    MetodaPlatnosciID INT NOT NULL,
    StatusPlatnosciID INT NOT NULL,

    FOREIGN KEY (WypozyczenieID) REFERENCES Wypozyczenie(WypozyczenieID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (MetodaPlatnosciID) REFERENCES MetodaPlatnosci(MetodaPlatnosciID)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    FOREIGN KEY (StatusPlatnosciID) REFERENCES StatusPlatnosci(StatusPlatnosciID)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE Doplata (
    DoplataID INT AUTO_INCREMENT PRIMARY KEY,
    WypozyczenieID INT NOT NULL,
    TypDoplatyID INT NOT NULL,
    Opis VARCHAR(255) NOT NULL,
    DataNaliczenia DATE NOT NULL,
    Kwota DECIMAL(10,2) NOT NULL,
    StatusDoplatyID INT NOT NULL,

    FOREIGN KEY (WypozyczenieID) REFERENCES Wypozyczenie(WypozyczenieID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (TypDoplatyID) REFERENCES TypDoplaty(TypDoplatyID)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    FOREIGN KEY (StatusDoplatyID) REFERENCES StatusDoplaty(StatusDoplatyID)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE ZdjecieSamochodu (
    ZdjecieID INT AUTO_INCREMENT PRIMARY KEY,
    SamochodID INT NOT NULL,
    Sciezka VARCHAR(255) NOT NULL,

    FOREIGN KEY (SamochodID) REFERENCES Samochod(SamochodID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

