from flask import Flask, jsonify
from flask_pymongo import PyMongo
import random
from apscheduler.schedulers.background import BackgroundScheduler

app = Flask(__name__)

# Configuração do MongoDB
app.config["MONGO_URI"] = "mongodb://localhost:27017/estufa"
mongo = PyMongo(app)

# Estados iniciais e configurações dos sensores
last_temperature = 25.0
last_humidity = 50.0
last_soil_moisture = 30.0
last_co2 = 400.0
last_light = 200.0
last_soil_ph = 6.5

# Função para armazenar dados dos sensores no MongoDB
def store_sensor_data():
    global last_temperature, last_humidity, last_soil_moisture, last_co2, last_light, last_soil_ph

    # Atualizações graduais
    last_temperature += random.uniform(-0.1, 0.1)
    last_humidity += random.uniform(-0.5, 0.5)
    last_soil_moisture += random.uniform(-1, 1)
    last_co2 += random.uniform(-10, 10)
    last_light += random.uniform(-5, 5)
    last_soil_ph += random.uniform(-0.05, 0.05)

    # Mantendo os valores dentro de limites realistas
    last_temperature = max(20, min(30, last_temperature))
    last_humidity = max(40, min(60, last_humidity))
    last_soil_moisture = max(10, min(50, last_soil_moisture))
    last_co2 = max(350, min(450, last_co2))
    last_light = max(100, min(300, last_light))
    last_soil_ph = max(6.0, min(7.0, last_soil_ph))

    sensores = {
        'temperature': round(last_temperature, 2),
        'humidity': round(last_humidity, 2),
        'soil_moisture': round(last_soil_moisture, 2),
        'co2_levels': round(last_co2, 2),
        'light_intensity': round(last_light, 2),
        'soil_ph': round(last_soil_ph, 2)
    }
    # Inserção dos dados no MongoDB
    mongo.db.sensors.insert_one(sensores)

scheduler = BackgroundScheduler()
scheduler.add_job(func=store_sensor_data, trigger='interval', seconds=1)
scheduler.start()

# Endpoint para obter dados de todos os sensores
@app.route('/api/sensors', methods=['GET'])
def all_sensors():
    return jsonify({
        'temperature': round(last_temperature, 2),
        'humidity': round(last_humidity, 2),
        'soil_moisture': round(last_soil_moisture, 2),
        'co2_levels': round(last_co2, 2),
        'light_intensity': round(last_light, 2),
        'soil_ph': round(last_soil_ph, 2)
    })

# Endpoint para desligar o scheduler e o servidor
@app.route('/shutdown', methods=['GET'])
def shutdown():
    scheduler.shutdown(wait=False)
    func = request.environ.get('werkzeug.server.shutdown')
    if func is None:
        raise RuntimeError('Not running with the Werkzeug Server')
    func()
    return "Shutting down..."

if __name__ == '__main__':
    app.run(debug=True, port=5000)
