CREATE TABLE lectures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    courseId INT NOT NULL,
    lecturerId INT NOT NULL,
    topic VARCHAR(255) NOT NULL,
    lectureDate DATE NOT NULL,
    startTime TIME NOT NULL,
    endTime TIME NOT NULL,

    qrCode VARCHAR(255) DEFAULT NULL, -- dynamically generated QR for the lecture
    qrExpiresAt INT(25) DEFAULT NULL, -- when the QR code becomes invalid
    
    latitude DECIMAL(10,8) DEFAULT NULL, -- geo location of the lecture
    longitude DECIMAL(11,8) DEFAULT NULL,
    locationRadius INT DEFAULT 50, -- radius in meters for attendance validation

    status ENUM('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (courseId) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (lecturerId) REFERENCES lecturers(id) ON DELETE CASCADE
);
