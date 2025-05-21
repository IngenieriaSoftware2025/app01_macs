CREATE TABLE categorias (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE prioridades (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL UNIQUE,
    valor INT NOT NULL
);

CREATE TABLE productos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cantidad INT NOT NULL,
    categoria_id INT NOT NULL,
    prioridad_id INT NOT NULL,
    comprado BOOLEAN DEFAULT 'f',
    fecha_creacion DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id),
    FOREIGN KEY (prioridad_id) REFERENCES prioridades(id)
);