const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');

const app = express();
const port = 5000;

mongoose.connect('mongodb://localhost:27017/estufa', { useNewUrlParser: true, useUnifiedTopology: true });

const SensorSchema = new mongoose.Schema({
    co2_levels: Number,
    humidity: Number,
    light_intensity: Number,
    soil_moisture: Number,
    soil_ph: Number,
    temperature: Number,
    timestamp: String
});

const Sensor = mongoose.model('Sensor', SensorSchema);

app.use(cors());

app.get('/api/sensors', async (req, res) => {
    try {
        const sensors = await Sensor.find();
        res.json(sensors);
    } catch (err) {
        res.status(500).send(err);
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}/`);
});
