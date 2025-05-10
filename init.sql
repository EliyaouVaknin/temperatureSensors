CREATE TABLE IF NOT EXISTS sensor_data (
    timestamp TIMESTAMP NOT NULL,
    id INTEGER NOT NULL,
    face VARCHAR(10) NOT NULL,
    temperature DOUBLE PRECISION NOT NULL
);

CREATE TABLE IF NOT EXISTS hourly_face_aggregates (
    hour TIMESTAMP NOT NULL,
    face VARCHAR(10) NOT NULL,
    avg_temperature DOUBLE PRECISION NOT NULL,
    sample_count INTEGER NOT NULL DEFAULT 1,
    PRIMARY KEY (hour, face)
);

CREATE TABLE IF NOT EXISTS malfunctioning_sensors (
    timestamp TIMESTAMP NOT NULL,
    face VARCHAR(10) NOT NULL,
    id INTEGER NOT NULL,
    avg_value DOUBLE PRECISION NOT NULL
);
