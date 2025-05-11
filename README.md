# 📡 temperatureSensors

A high-throughput sensor monitoring system built with PHP (Slim Framework), PostgreSQL, Redis, and Docker.  
Designed to receive up to **10,000 sensor inputs per second**, detect faulty sensors, and provide hourly/weekly temperature reports.

---

## 🚀 Features

- Accepts real-time temperature data from thousands of sensors
- Stores data efficiently in PostgreSQL
- Detects malfunctioning sensors
- Aggregates hourly temperature data per face (N/S/E/W)
- Provides APIs for data retrieval
- Uses Redis for task queuing (via worker service)
- Fully containerized with Docker

---

## 🧱 Tech Stack

- **Backend**: PHP (Slim Framework)
- **Database**: PostgreSQL
- **Cache/Queue**: Redis
- **Orchestration**: Docker & Docker Compose

---

## 📂 Project Structure

```
temperatureSensors/
├── docker-compose.yml
├── public/
│   └── index.php             # Slim app entrypoint
├── src/
│   ├── routes.php            # API routes
│   ├── SensorController.php  # Handles API logic
│   └── Worker.php            # Redis worker script
├── sql/
│   └── init.sql              # Initial DB schema
├── .env                      # Environment variables
├── worker.Dockerfile         # Dockerfile for worker
└── php.Dockerfile            # Dockerfile for Slim app
```

---

## ⚙️ Setup & Run

### 1. Clone the repository
```bash
git clone https://github.com/EliyaouVaknin/temperatureSensors.git
cd temperatureSensors
```

### 2. Build and start the containers
```bash
docker-compose up --build
```

### 3. Access the API
The app will be available at:  
📍 `http://localhost:8080`

---

## 📡 API Endpoints

| Method | Endpoint                          | Description                               |
|--------|-----------------------------------|-------------------------------------------|
| GET    | `/ping`                           | Health check                              |
| POST   | `/sensor-data`                    | Send sensor temperature data              |
| GET    | `/reports/hourly`                 | Get hourly average per face               |
| GET    | `/reports/hourly/{face}`          | Hourly average for specific face          |
| GET    | `/reports/malfunctioning`         | List of all malfunctioning sensors        |
| GET    | `/reports/malfunctioning/{face}`  | Malfunctioning sensors for specific face  |

---

## 🧪 Simulate Load

You can simulate 10,000+ sensor inputs per second by writing a script (e.g., in Python or Node.js) that sends bulk POST requests to `/sensor-data`.

---

## 🛠 Troubleshooting

- Make sure Docker is running properly.
- If Redis or PostgreSQL containers crash, check logs:
  ```bash
  docker-compose logs redis
  docker-compose logs postgres
  ```

---

## 👨‍💻 Author

**Eliyahu Vaknin**  
🔗 [GitHub Profile](https://github.com/EliyaouVaknin)

---

## 📜 License

This project is open-source and available under the [MIT License](LICENSE).
