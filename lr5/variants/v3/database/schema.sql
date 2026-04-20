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
    poster_image VARCHAR(255) DEFAULT '',
    description TEXT DEFAULT '',
    rating DECIMAL(3,1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Movie images/posters
CREATE TABLE IF NOT EXISTS movie_images (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);

-- Comments on movies
CREATE TABLE IF NOT EXISTS movie_comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    comment TEXT NOT NULL,
    rating INTEGER DEFAULT 5,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Reactions (likes/dislikes) on movies
CREATE TABLE IF NOT EXISTS movie_reactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    reaction_type VARCHAR(20) NOT NULL DEFAULT 'like',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(movie_id, user_id),
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Movie polls/voting
CREATE TABLE IF NOT EXISTS movie_polls (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER NOT NULL,
    question VARCHAR(255) NOT NULL,
    active INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);

-- Poll options
CREATE TABLE IF NOT EXISTS poll_options (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    poll_id INTEGER NOT NULL,
    option_text VARCHAR(200) NOT NULL,
    FOREIGN KEY (poll_id) REFERENCES movie_polls(id) ON DELETE CASCADE
);

-- Poll votes
CREATE TABLE IF NOT EXISTS poll_votes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    poll_id INTEGER NOT NULL,
    option_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(poll_id, user_id),
    FOREIGN KEY (poll_id) REFERENCES movie_polls(id) ON DELETE CASCADE,
    FOREIGN KEY (option_id) REFERENCES poll_options(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Cinema activities (for voting)
CREATE TABLE IF NOT EXISTS activities (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT '',
    activity_type VARCHAR(50) DEFAULT 'charity',
    image_path VARCHAR(255) DEFAULT '',
    active INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Activity votes
CREATE TABLE IF NOT EXISTS activity_votes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    activity_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    vote_value INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(activity_id, user_id),
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Cinema hall setup
CREATE TABLE IF NOT EXISTS halls (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    rows INTEGER NOT NULL DEFAULT 10,
    seats_per_row INTEGER NOT NULL DEFAULT 10,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Hall seats
CREATE TABLE IF NOT EXISTS hall_seats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    hall_id INTEGER NOT NULL,
    row_num INTEGER NOT NULL,
    seat_num INTEGER NOT NULL,
    is_available INTEGER DEFAULT 1,
    UNIQUE(hall_id, row_num, seat_num),
    FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE
);

-- Movie screenings (showings)
CREATE TABLE IF NOT EXISTS screenings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER NOT NULL,
    hall_id INTEGER NOT NULL,
    screening_datetime DATETIME NOT NULL,
    price_per_ticket DECIMAL(10,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE
);

-- Tickets
CREATE TABLE IF NOT EXISTS tickets (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    screening_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    seat_id INTEGER NOT NULL,
    ticket_number VARCHAR(50) NOT NULL UNIQUE,
    price DECIMAL(10,2) NOT NULL,
    booking_status VARCHAR(20) DEFAULT 'booked',
    purchase_datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (screening_id) REFERENCES screenings(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (seat_id) REFERENCES hall_seats(id) ON DELETE CASCADE
);

-- Movie statistics (cached)
CREATE TABLE IF NOT EXISTS movie_statistics (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    movie_id INTEGER NOT NULL UNIQUE,
    total_comments INTEGER DEFAULT 0,
    avg_rating DECIMAL(3,2) DEFAULT 0,
    total_likes INTEGER DEFAULT 0,
    total_votes INTEGER DEFAULT 0,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);

-- Seed movies with posters
INSERT INTO movies (title, director, genre, year, duration_min, description) VALUES
    ('Pulp Fiction', 'Quentin Tarantino', 'Crime', 1994, 154, 'Легендарний фільм про злочинців і гангстерів'),
    ('The Shawshank Redemption', 'Frank Darabont', 'Drama', 1994, 142, 'Історія дружби у в''язниці'),
    ('Inception', 'Christopher Nolan', 'Sci-Fi', 2010, 148, 'Подорож у світ снів'),
    ('The Godfather', 'Francis Ford Coppola', 'Crime', 1972, 175, 'Влада мафіози'),
    ('Forrest Gump', 'Robert Zemeckis', 'Drama', 1994, 142, 'Життя незвичайної людини'),
    ('The Matrix', 'The Wachowskis', 'Sci-Fi', 1999, 136, 'Реальність чи ілюзія?'),
    ('Titanic', 'James Cameron', 'Romance', 1997, 195, 'Любов на борту легендарного корабля'),
    ('Avatar', 'James Cameron', 'Sci-Fi', 2009, 162, 'Дослідження іншої планети'),
    ('The Dark Knight', 'Christopher Nolan', 'Action', 2008, 152, 'Бетмен проти Джокера'),
    ('Schindler''s List', 'Steven Spielberg', 'Historical', 1993, 195, 'Історія спасіння');

-- Insert default hall
INSERT INTO halls (name, rows, seats_per_row) VALUES ('Основна зала', 10, 12);

-- Seed hall seats (10 rows x 12 seats)
INSERT INTO hall_seats (hall_id, row_num, seat_num, is_available) 
SELECT 1, r.num, s.num, 1
FROM (SELECT 1 as num UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 
      UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) r
CROSS JOIN (SELECT 1 as num UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 
            UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 
            UNION SELECT 11 UNION SELECT 12) s;

-- Sample activities for voting
INSERT INTO activities (title, description, activity_type) VALUES
    ('Благодійна демонстрація "Рятування"', 'Фільми для збору коштів на благодійність', 'charity'),
    ('Дитячий кіноклуб', 'Напівлегалне кіно для дітей з цукерками', 'kids'),
    ('Нічна киножуття', 'Марафон фільмів з 23:00 до 7:00', 'special');
