-- Users table (auth module)
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(20) DEFAULT '',
    city VARCHAR(50) DEFAULT '',
    gender VARCHAR(10) DEFAULT '',
    about TEXT DEFAULT '',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Movies table (CRUD module — Кінотеатр)
CREATE TABLE IF NOT EXISTS movies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(200) NOT NULL,
    director VARCHAR(100) NOT NULL,
    genre VARCHAR(50) DEFAULT '',
    year INTEGER DEFAULT 0,
    duration_min INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Seed movies
INSERT INTO movies (title, director, genre, year, duration_min) VALUES
    ('Пulp Fiction', 'Quentin Tarantino', 'Crime', 1994, 154),
    ('The Shawshank Redemption', 'Frank Darabont', 'Drama', 1994, 142),
    ('Inception', 'Christopher Nolan', 'Sci-Fi', 2010, 148),
    ('The Godfather', 'Francis Ford Coppola', 'Crime', 1972, 175),
    ('Forrest Gump', 'Robert Zemeckis', 'Drama', 1994, 142),
    ('The Matrix', 'The Wachowskis', 'Sci-Fi', 1999, 136),
    ('Titanic', 'James Cameron', 'Romance', 1997, 195),
    ('Avatar', 'James Cameron', 'Sci-Fi', 2009, 162),
    ('The Dark Knight', 'Christopher Nolan', 'Action', 2008, 152),
    ('Schindler''s List', 'Steven Spielberg', 'Historical', 1993, 195);
