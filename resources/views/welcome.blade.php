<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Noctivent</title>
</head>

<body>
    {{-- logo section --}}
    <section id="logo">
        <div class="container">
            <div class="row ">
                <div class="col-sm-12 ">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" style="margin-left: 22%;"
                        class="img-fluid d-flex justify-content-start" width="15%">
                </div>
            </div>
        </div>
    </section>

    {{-- navbar section --}}
    <section id="navbar">
        <div class="container mt-4">
            <div class="row">
                <div class="col">
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#" data-tab="weather">Weather</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-tab="summary">Summary</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    {{-- weather --}}
    <section id="content" class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div id="weather-content" class="tab-content active">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="tab-content">
                                        <h1 class="weather-title">Weather</h1>

                                        <div class="container">
                                            <div class="date-time" style="margin-left: 30%; font-weight:500"></div>
                                        </div>

                                        <div class="weather-card" id="weatherCard">

                                            <div class="row weather-labels">
                                                <div class="col-4 text-start">Day</div>
                                                <div class="col-4 text-center">Temperature</div>
                                                <div class="col-4 text-end">Humidity</div>
                                            </div>

                                            <div class="weather-main">
                                                <div class="thermometer-icon">
                                                    <img width="50%" src="{{ asset('assets/thermometer.png') }}"
                                                        alt="Thermometer">
                                                </div>

                                                <div class="temperature-section">
                                                    <div class="temperature">
                                                        28<span class="temp-unit">°C</span>
                                                    </div>
                                                </div>

                                                <div class="humidity-section">
                                                    <div class="humidity">78%</div>
                                                </div>
                                            </div>

                                            <div class="location">
                                                <p class="location-main">Yogyakarta, D.I.Y.</p>
                                                <p class="location-sub">Yogyakarta</p>
                                            </div>
                                        </div>

                                        <div class="container mt-4">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="switch-container">
                                                        <div class="text-center mb-2">
                                                            <small class="switch-label">
                                                                Vent Status:
                                                                <span id="ventStatusText">
                                                                    <span id="statusDot"
                                                                        class="status-indicator status-close"></span>
                                                                    <span id="statusLabel">Tertutup</span>
                                                                </span>
                                                            </small>
                                                        </div>

                                                        <div
                                                            class="form-check form-switch d-flex justify-content-center mb-5">
                                                            <input class="form-check-input" type="checkbox"
                                                                role="switch" id="flexSwitchCheck">
                                                            <label class="form-check-label ms-2" for="flexSwitchCheck">
                                                                <span id="switchActionText">Buka Vent</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- summary --}}

    <section id="content" class="mt-1">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div id="summary-content" class="tab-content" style="display: none;">
                        <h1 class="weather-title">Summary</h1>
                        <div class="card mb-5" style="max-width: 380px; margin: 0 auto;">
                            <div class="card-body">
                                <table class="table table-sm" style="font-size: 14px;">
                                    <thead>
                                        <tr>
                                            <th style="border-bottom: 2px solid #dee2e6; padding: 8px 4px;">Date</th>
                                            <th style="border-bottom: 2px solid #dee2e6; padding: 8px 4px;">Hour</th>
                                            <th style="border-bottom: 2px solid #dee2e6; padding: 8px 4px;">
                                                T<sub>in</sub></th>
                                            <th style="border-bottom: 2px solid #dee2e6; padding: 8px 4px;">
                                                H<sub>in</sub></th>
                                            <th style="border-bottom: 2px solid #dee2e6; padding: 8px 4px;">
                                                T<sub>out</sub></th>
                                            <th style="border-bottom: 2px solid #dee2e6; padding: 8px 4px;">
                                                H<sub>out</sub></th>
                                            <th style="border-bottom: 2px solid #dee2e6; padding: 8px 4px;">
                                                V<sub>ent</sub></th>
                                        </tr>
                                    </thead>
                                    <tbody id="summary-table-body">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted" style="padding: 20px;">
                                                Loading data...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    {{-- script load data summary --}}
    <script>
        async function loadSummaryData() {
            console.log('Loading summary data...');

            const tableBody = document.getElementById('summary-table-body');
            if (!tableBody) {
                console.error('Table body element not found');
                return;
            }

            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted" style="padding: 20px;">
                        Loading data...
                    </td>
                </tr>
            `;

            try {
                console.log('Fetching data from /firebase/dummy-data...');
                const response = await fetch('/firebase/dummy-data');
                console.log('Response status:', response.status);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                console.log('Data received:', result);

                if (result.success && result.data && result.data.length > 0) {
                    tableBody.innerHTML = '';

                    const displayData = result.data.slice(0, 10);
                    console.log('Displaying data:', displayData);

                    displayData.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td style="padding: 8px 4px; border-bottom: 1px solid #f8f9fa;">${item.date}</td>
                            <td style="padding: 8px 4px; border-bottom: 1px solid #f8f9fa;">${item.hour}</td>
                            <td style="padding: 8px 4px; border-bottom: 1px solid #f8f9fa;">${item.Tin}</td>
                            <td style="padding: 8px 4px; border-bottom: 1px solid #f8f9fa;">${item.Hin}</td>
                            <td style="padding: 8px 4px; border-bottom: 1px solid #f8f9fa;">${item.Tout}</td>
                            <td style="padding: 8px 4px; border-bottom: 1px solid #f8f9fa;">${item.Hout}</td>
                            <td style="padding: 8px 4px; border-bottom: 1px solid #f8f9fa;">${item.vent}</td>
                        `;
                        tableBody.appendChild(row);
                    });

                    console.log('Data loaded successfully');
                } else {
                    console.warn('No data available in response');
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center text-muted" style="padding: 20px;">
                                No data available
                            </td>
                        </tr>
                    `;
                }
            } catch (error) {
                console.error('Error loading summary data:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-danger" style="padding: 20px;">
                            Error: ${error.message}
                        </td>
                    </tr>
                `;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link[data-tab]');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    navLinks.forEach(sibling => {
                        sibling.classList.remove('active');
                    });

                    this.classList.add('active');

                    if (this.dataset.tab === 'weather') {
                        document.getElementById('weather-content').style.display = 'block';
                        document.getElementById('summary-content').style.display = 'none';
                    } else if (this.dataset.tab === 'summary') {
                        document.getElementById('weather-content').style.display = 'none';
                        document.getElementById('summary-content').style.display = 'block';

                        console.log('Summary tab clicked, loading data...');
                        setTimeout(loadSummaryData, 100);
                    }
                });
            });

            function updateTime() {
                const now = new Date();
                const options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const dateStr = now.toLocaleDateString('en-US', options);
                const timeStr = now.toLocaleTimeString('en-GB', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const dateTimeElement = document.querySelector('.date-time');
                if (dateTimeElement) {
                    dateTimeElement.innerHTML = `${dateStr}<br>${timeStr} (GMT +7)`;
                }
            }

            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>

    {{-- script vent --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const switchElement = document.getElementById('flexSwitchCheck');
            const statusDot = document.getElementById('statusDot');
            const statusLabel = document.getElementById('statusLabel');
            const switchActionText = document.getElementById('switchActionText');

            if (!switchElement) {
                console.error('Switch element tidak ditemukan!');
                return;
            }

            function isWithinAutoTime() {
                const now = new Date();
                const currentHour = now.getHours();
                const currentMinute = now.getMinutes();
                const currentTime = currentHour + (currentMinute / 60);

                return currentTime >= 4 && currentTime < 6;
            }

            function updateUI(status, updateInfo = null, isLoading = false) {
                if (isLoading) {
                    switchElement.disabled = true;
                    return;
                }

                switchElement.disabled = false;
                switchElement.checked = (status === 'open');

                if (status === 'open') {
                    statusDot.className = 'status-indicator status-open';
                    statusLabel.textContent = 'Terbuka';
                    switchActionText.textContent = 'Tutup Vent';
                } else {
                    statusDot.className = 'status-indicator status-close';
                    statusLabel.textContent = 'Tertutup';
                    switchActionText.textContent = 'Buka Vent';
                }

                showAutoTimeInfo(updateInfo);
            }

            function showAutoTimeInfo(updateInfo) {
                let existingMessage = document.getElementById('autoTimeMessage');
                if (existingMessage) {
                    existingMessage.remove();
                }

                const messageDiv = document.createElement('div');
                messageDiv.id = 'autoTimeMessage';

                const isAutoTime = isWithinAutoTime();

                if (isAutoTime) {
                    messageDiv.className = 'alert alert-info mt-2';
                    messageDiv.innerHTML = `
                <small>
                    <i class="fas fa-clock"></i> Periode auto-update aktif (04:00 - 06:00). 
                    Perubahan manual tetap dimungkinkan.
                </small>
            `;
                } else if (updateInfo && updateInfo.update_type === 'manual') {
                    messageDiv.className = 'alert alert-success mt-2';
                    messageDiv.innerHTML = `
                <small>
                    <i class="fas fa-user"></i> Terakhir diubah secara manual pada ${updateInfo.updated_at}
                </small>
            `;
                }

                if (messageDiv.innerHTML) {
                    const switchContainer = switchElement.closest('.form-check') || switchElement.parentElement;
                    switchContainer.parentNode.insertBefore(messageDiv, switchContainer.nextSibling);
                }
            }

            async function loadInitialStatus() {
                try {
                    updateUI(null, null, true);

                    const response = await fetch('/vent/get-status', {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || ''
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        updateUI(data.status, data.update_info);
                        console.log('Status awal loaded:', data.status);
                    } else {
                        console.warn('Gagal mengambil status awal:', data.message);
                        updateUI('close');
                    }
                } catch (error) {
                    console.error('Error loading initial status:', error);
                    updateUI('close');
                }
            }
            loadInitialStatus();
            switchElement.addEventListener('change', async function() {
                const isChecked = this.checked;
                const newStatus = isChecked ? 'open' : 'close';

                updateUI(null, null, true);

                try {
                    const response = await fetch('/vent/update-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || '',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        const updateInfo = {
                            updated_at: data.updated_at,
                            update_type: data.update_type
                        };
                        updateUI(newStatus, updateInfo);
                        console.log('✅ Status berhasil diubah ke:', newStatus);

                        const messageText = data.update_type === 'auto_period' ?
                            `Vent ${newStatus === 'open' ? 'dibuka' : 'ditutup'} (periode auto-update)` :
                            `Vent ${newStatus === 'open' ? 'dibuka' : 'ditutup'} secara manual`;

                        showNotification(messageText, 'success');
                    } else {
                        updateUI(isChecked ? 'close' : 'open');
                        showNotification('Gagal mengubah status: ' + data.message, 'error');
                    }
                } catch (error) {
                    console.error('❌ Error:', error);
                    updateUI(isChecked ? 'close' : 'open');
                    showNotification('Terjadi kesalahan saat mengubah status', 'error');
                }
            });

            function showNotification(message, type) {
                const alertDiv = document.createElement('div');
                let alertClass = 'alert-danger';
                let icon = '❌';

                if (type === 'success') {
                    alertClass = 'alert-success';
                    icon = '✅';
                } else if (type === 'warning') {
                    alertClass = 'alert-warning';
                    icon = '⚠️';
                } else if (type === 'info') {
                    alertClass = 'alert-info';
                    icon = 'ℹ️';
                }

                alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
                alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';

                alertDiv.innerHTML = `
            <strong>${icon}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

                document.body.appendChild(alertDiv);

                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 3000);
            }

            setInterval(loadInitialStatus, 30000);
        });
    </script>

    {{-- script vent schedule --}}
    <script>
        function isNightTime() {
            const now = new Date();
            const hours = now.getHours();
            return hours >= 18 || hours < 6;
        }

        async function getVentStatus() {
            try {
                const response = await fetch('/vent/get-status');
                const data = await response.json();

                if (data.success) {
                    updateCardStatus(data.status);
                } else {
                    console.error('Error getting status:', data.message);
                    updateCardStatus('close');
                }
            } catch (error) {
                console.error('Network error:', error);
                updateCardStatus('close');
            }
        }

        function updateCardStatus(status) {
            const weatherCard = document.getElementById('weatherCard');
            const statusDisplay = document.getElementById('statusDisplay');
            const body = document.body;

            const isNight = isNightTime();

            weatherCard.classList.remove('vent-open', 'vent-close', 'night-mode');
            body.classList.remove('vent-open', 'vent-close', 'night-mode');

            if (isNight) {
                weatherCard.classList.add('night-mode');
                body.classList.add('night-mode');
            }

            const thermometerImg = document.querySelector('.thermometer-icon img');
            if (thermometerImg) {
                if (isNight) {
                    thermometerImg.src = "{{ asset('assets/thermometer.png') }}";
                } else {
                    thermometerImg.src = "{{ asset('assets/thermometer2.png') }}";
                }
            }

            if (status === 'open') {
                weatherCard.classList.add('vent-open');
                body.classList.add('vent-open');
                if (statusDisplay) statusDisplay.textContent = 'OPEN';
            } else {
                weatherCard.classList.add('vent-close');
                body.classList.add('vent-close');
                if (statusDisplay) statusDisplay.textContent = 'CLOSE';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateCardStatus('close');
            getVentStatus();
            setInterval(getVentStatus, 3000);
            setInterval(function() {
                updateCardStatus(document.getElementById('weatherCard').classList.contains('vent-open') ?
                    'open' : 'close');
            }, 60000);
        });
    </script>


</body>

</html>
