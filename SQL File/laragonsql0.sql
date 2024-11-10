CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role VARCHAR(50) default 'user'
);

CREATE TABLE IF NOT EXISTS Categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
-- ALTER TABLE Categories ADD COLUMN type VARCHAR(255);categories


CREATE TABLE IF NOT EXISTS Games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    instructions TEXT,
    video_url VARCHAR(255),
    materials TEXT,
    time_required INT,
    document_url VARCHAR(255),
    id_category INT,
    FOREIGN KEY (id_category) REFERENCES Categories(id)
);

CREATE TABLE IF NOT EXISTS Location (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    latitude DECIMAL(9, 6),
    longitude DECIMAL(9, 6),
    geolocation VARCHAR(255),
    avatar VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Itineraries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location_id INT,
    game_id INT,
    name VARCHAR(255),
    description TEXT,
    FOREIGN KEY (location_id) REFERENCES Location(id),
    FOREIGN KEY (game_id) REFERENCES Games(id)
);


CREATE TABLE IF NOT EXISTS Contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(255)
);

-- Insert r-- Thêm một vài bản ghi mẫu vào bảng Users
INSERT INTO Users (username, password, email, phone, role) VALUES
('john_doe', 'password123', 'john@example.com', '1234567890', 'user'),
('admin', 'adminpassword', 'admin@example.com', '0987654321', 'admin');

-- Thêm một vài bản ghi mẫu vào bảng Categories
INSERT INTO Categories (name, type) VALUES
('Outdoor Games', 'Outdoor'),
('Indoor Games', 'Indoor'),
('Male Games', 'Outdoor'),
('Female Games', 'Outdoor'),
('Kids Games', 'Outdoor'),
('Family Games', 'Outdoor'),

-- Thêm một vài bản ghi mẫu vào bảng Games
INSERT INTO Games (name, instructions, video_url, materials, time_required, document_url, id_category) VALUES
('Tug of War', 'Instructions for Tug of War', 'http://example.com/tugofwar.mp4', 'Rope', '15', 'http://example.com/tugofwar.doc', 1),
('Hide and Seek', 'Instructions for Hide and Seek', 'http://example.com/hideandseek.mp4', 'None', '30', 'http://example.com/hideandseek.doc', 2);


-- Thêm một vài bản ghi mẫu vào bảng Location
INSERT INTO Location (name, description, latitude, longitude) VALUES
('Central Park', 'A large public park in New York City', 40.785091, -73.968285),
('Golden Gate Park', 'A large urban park in San Francisco', 37.769420, -122.486214);



-- Thêm một vài bản ghi mẫu vào bảng Itineraries
INSERT INTO Itineraries (location_id, game_id, name, description) VALUES
(1, 1, 'Central Park Tug of War', 'Join us for a fun game of Tug of War in Central Park.'),
(2, 2, 'Golden Gate Hide and Seek', 'Join us for a fun game of Hide and Seek in Golden Gate Park.');

-- Thêm một vài bản ghi mẫu vào bảng Contact
INSERT INTO Contact (address, phone, email, geolocation) VALUES
('123 Main St, New York, NY', '123-456-7890', 'info@example.com', '40.785091,-73.968285'),
('456 Elm St, San Francisco, CA', '987-654-3210', 'contact@example.com', '37.769420,-122.486214');









