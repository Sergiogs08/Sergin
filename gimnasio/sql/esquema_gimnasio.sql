CREATE DATABASE IF NOT EXISTS gimnasio CHARACTER SET utf8mb4;
USE gimnasio;

/* Usuarios */
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  rol ENUM('administrador','entrenador','recepcionista','usuario') NOT NULL,
  trainer_id INT DEFAULT NULL,
  FOREIGN KEY (trainer_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB;

/* Clases */
CREATE TABLE clases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(100) NOT NULL,
  descripcion TEXT,
  fecha DATE,
  hora TIME,
  entrenador_id INT,
  FOREIGN KEY (entrenador_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

/* Reservas */
CREATE TABLE reservas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  clase_id INT NOT NULL,
  fecha_reserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (clase_id) REFERENCES clases(id) ON DELETE CASCADE
) ENGINE=InnoDB;

/* Planes de membresía */
CREATE TABLE membresias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_plan VARCHAR(50),
  duracion INT,
  precio DECIMAL(8,2)
) ENGINE=InnoDB;

/* Asignación de membresía */
CREATE TABLE usuario_membresia (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  membresia_id INT,
  fecha_inicio DATE,
  fecha_fin DATE,
  pago DECIMAL(8,2),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (membresia_id) REFERENCES membresias(id)
) ENGINE=InnoDB;

/* Rutinas */
CREATE TABLE rutinas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  entrenador_id INT,
  descripcion TEXT,
  fecha_asignacion DATE,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (entrenador_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

/* Inserciones básicas */
INSERT INTO usuarios (nombre,email,password,rol) VALUES
('Admin','admin@gim.com','$2y$10$w9/1U/LZUUl2gkFjTKLr9uU2cX8kN0PuxvaW8.6V72JniqEYExIiW','administrador'),
('Coach','entrenador@gim.com','$2y$10$w9/1U/LZUUl2gkFjTKLr9uU2cX8kN0PuxvaW8.6V72JniqEYExIiW','entrenador'),
('Front','recep@gim.com','$2y$10$w9/1U/LZUUl2gkFjTKLr9uU2cX8kN0PuxvaW8.6V72JniqEYExIiW','recepcionista');
