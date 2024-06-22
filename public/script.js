document.addEventListener('DOMContentLoaded', async function() {
    async function fetchSensorData() {
        const response = await fetch('http://localhost:5000/api/sensors');
        return response.json();
    }

    function convertTimestampToDate(timestamp) {
        return moment(timestamp).format('YYYY-MM-DD HH:mm:ss');
    }

    const sensorData = await fetchSensorData();

    if (sensorData.length === 0) {
        console.error("No sensor data available.");
        return;
    }

    const tableBody = document.getElementById('sensorTableBody');
    function populateTable(data) {
        tableBody.innerHTML = '';
        data.forEach(sensor => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${convertTimestampToDate(sensor.timestamp)}</td>
                <td>${sensor.temperature}</td>
                <td>${sensor.humidity}</td>
                <td>${sensor.soil_moisture}</td>
                <td>${sensor.co2_levels}</td>
                <td>${sensor.light_intensity}</td>
                <td>${sensor.soil_ph}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    populateTable(sensorData);

    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredData = sensorData.filter(sensor => 
            convertTimestampToDate(sensor.timestamp).toLowerCase().includes(searchTerm) ||
            sensor.temperature.toString().toLowerCase().includes(searchTerm) ||
            sensor.humidity.toString().toLowerCase().includes(searchTerm) ||
            sensor.soil_moisture.toString().toLowerCase().includes(searchTerm) ||
            sensor.co2_levels.toString().toLowerCase().includes(searchTerm) ||
            sensor.light_intensity.toString().toLowerCase().includes(searchTerm) ||
            sensor.soil_ph.toString().toLowerCase().includes(searchTerm)
        );
        populateTable(filteredData);
    });

    function createChart(context, label, data, color) {
        return new Chart(context, {
            type: 'line',
            data: {
                labels: sensorData.map(sensor => convertTimestampToDate(sensor.timestamp)),
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: color,
                    borderColor: color,
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Time',
                            color: 'white'
                        },
                        ticks: {
                            color: 'white'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: label,
                            color: 'white'
                        },
                        ticks: {
                            color: 'white'
                        }
                    }
                }
            }
        });
    }

});
