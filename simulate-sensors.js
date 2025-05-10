const axios = require('axios');

const API_URL = 'http://localhost:8080/sensor-data';
const SENSORS = 1;
const FACES = ['north', 'south', 'east', 'west'];

function getRandomSensorData(id) {
  return {
    id,
    face: FACES[Math.floor(Math.random() * FACES.length)],
    timestamp: Math.floor(Date.now() / 1000),
    temperature: parseFloat((Math.random() * 10 + 20).toFixed(2))
  };
}

async function sendBatch() {
  const batch = [];

  for (let i = 0; i < SENSORS; i++) {
    const sensor = getRandomSensorData(i);
    batch.push(
      axios.post(API_URL, sensor).catch(err => {
        console.error(`❌ Sensor ${sensor.id} failed: ${err.code || err.message}`);
      })
    );
  }

  await Promise.all(batch);
  console.log(`✅ Sent ${SENSORS} sensors`);
}

// Run every second
setInterval(sendBatch, 1000);
