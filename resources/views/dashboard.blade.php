<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')

    <style>
        .progress-container {
            position: relative;
            width: 100%;
            height: 20px;
            background: linear-gradient(to right, red, yellow, green);
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .progress-bar-fill {
            height: 100%;
            width: 0;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .progress-needle {
            position: absolute;
            top: -10px;
            width: 2px;
            height: 40px;
            background: black;
            transition: left 0.5s;
        }

        .datetime-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin: 20px;
            font-family: Arial, sans-serif;
        }

        /* Date styling */
        .date {
            font-size: 1.2em;
            color: white;
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .date i {
            margin-right: 8px;
        }

        /* Time styling */
        .clock {
            font-size: 1.0em;
            color: white;
            font-weight: bold;
            letter-spacing: 1.5px;
            display: flex;
            align-items: center;
        }

        .clock i {
            margin-right: 8px;
        }
    </style>

</head>

<body class="flex flex-col h-screen">
    <div class="flex h-screen">
        @livewire('partials.sidebar')
        <!-- Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            @livewire('partials.header')

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-4">
                <div class="gap-4">
                    <div class="bg-white shadow-lg rounded-lg mb-4">
                        <div class="flex justify-between items-center px-4 py-3 border-b border-gray-200 bg-gray-50">
                            <h6 class="m-0 font-semibold text-gray-700">Dashboard</h6>
                        </div>
                        <div class="px-4 py-4 md:px-8 md:py-8">
                            <div class="datetime-container">
                                <div id="daterange" class="py-2 px-3 bg-dgreen text-body font-semibold text-lwhite rounded-md flex items-center space-x-2">
                                    <p class="date"><i class="fas fa-calendar-alt"></i><span id="date"></span></p>
                                </div>
                                <br />
                                <div id="daterange" class="py-2 px-3 bg-dgreen text-body font-semibold text-lwhite rounded-md flex items-center space-x-2">
                                    <p class="clock"><i class="fas fa-clock"></i><span id="clock"></span></p>
                                </div>
                            </div>

                            <br />
                            <div class="flex justify-center items-center">

                                <!-- <div class="bg-blue-400 h-full p-4 md:px-8 rounded-lg shadow-lg flex flex-col justify-center items-center">
                                    <div class="w-full mb-6 items-center mt-4">
                                        <p class="text-white text-lg font-bold text-center"> Alat 1</p>
                                        <br />
                                        <hr style="border: 1px solid black; width: 100%;">
                                        <br />
                                        <p class="text-white text-sm font-bold">
                                            Status : <span id="status1-text">Checking...</span>
                                            <span id="status1-circle" class="inline-block w-3 h-3 rounded-full ml-2" style="background-color: yellow;"></span>
                                        <p class="text-white text-sm text-right" id="date1"> Tanggal : {{ $created_at_date1 }}</p>
                                        <p class="text-white text-sm text-right" id="hour1"> Jam : {{ $created_at_hour1 }}</p>
                                        </p>
                                        <br />
                                        <hr style="border: 1px solid black; width: 100%;">
                                    </div>
                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">Suhu</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="temperature1">
                                                    {{ $temperature1 . ' C' ?? 'No Temperature data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">pH</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="ph1">
                                                    {{ $ph1 ?? 'No pH data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">Amonia</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="amonia1">
                                                    {{ $amonia1 . ' mg/L' ?? 'No Amonia data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">TDS</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="tds1">
                                                    {{ $tds1 . ' Ppm' ?? 'No TDS data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">DO</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="do1">
                                                    {{ $do1 . ' Ppm' ?? 'No DO data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black; width: 100%;">
                                    <br />
                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">Kualitas Air</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="label1">
                                                    {{ $label1 ?? 'No label data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="bg-blue-400 h-full p-4 md:px-8 rounded-lg shadow-lg flex flex-col justify-center items-center w-1/2">
                                    <div class="w-full mb-6 items-center mt-4">
                                        <p class="text-white text-lg font-bold text-center"> Data Alat </p>
                                        <br />
                                        <hr style="border: 1px solid black; width: 100%;">
                                        <br />
                                        <p class="text-white text-sm font-bold">
                                            Status : <span id="status2-text">Checking...</span>
                                            <span id="status2-circle" class="inline-block w-3 h-3 rounded-full ml-2" style="background-color: yellow;"></span>
                                        <p class="text-white text-sm text-right" id="date1"> Tanggal : {{ $created_at_date1 }}</p>
                                        <p class="text-white text-sm text-right" id="hour1"> Jam : {{ $created_at_hour1 }}</p>
                                        </p>
                                        <br />
                                        <hr style="border: 1px solid black; width: 100%;">
                                    </div>
                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">Suhu</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="temperature1">
                                                    {{ $temperature1 . ' C' ?? 'No Temperature data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">pH</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="ph1">
                                                    {{ $ph1 ?? 'No pH data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">Amonia</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="amonia2">
                                                    {{ $amonia2 . ' mg/L' ?? 'No Amonia data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">TDS</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="tds1">
                                                    {{ $tds1 . ' Ppm' ?? 'No TDS data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">DO</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="do1">
                                                    {{ $do1 . ' Ppm' ?? 'No DO data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black; width: 100%;">
                                    <br />
                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">Kualitas Air</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="label1">
                                                    {{ $label1 ?? 'No label data available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full mb-6">
                                        <div class="flex justify-between">
                                            <div class="flex w-full">
                                                <p class="text-white text-md font-bold w-1/3">Keadaan Relay</p>
                                                <p class="text-white text-md font-bold w-1/6">:</p>
                                                <p class="text-white text-md font-bold w-1/2" id="label1">
                                                    @if(isset($label1) && $label1 === 'Sangat Baik')
                                                    Mati
                                                    @elseif(isset($label1) && $label1 === 'Baik')
                                                    Mati
                                                    @elseif(isset($label1) && $label1 === 'Cukup')
                                                    Hidup(1 Menit)
                                                    @elseif(isset($label1) && $label1 === 'Buruk')
                                                    Hidup(3 Menit)
                                                    @elseif(isset($label1) && $label1 === 'Sangat Buruk')
                                                    Hidup(5 Menit)
                                                    @else
                                                    {{ $label1 ?? 'No label data available.' }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            @livewire('partials.footer')

            <!-- Logout form (hidden by default) -->
            <form id="logout-form" action="#" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="logout" value="true">
            </form>
        </div>
    </div>
    @vite('resources/js/app.js')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchData(id_alat) {
            $.ajax({
                url: '/dashboard/data/' + id_alat,
                method: 'GET',
                success: function(data) {
                    let currentTime = new Date().getTime(); // Current time
                    let lastUpdated = new Date(data.created_at).getTime();

                    let timeDifference = currentTime - lastUpdated;

                    let status = timeDifference <= 600000 ? 'online' : 'offline'; // 10 minutes = 600000 ms

                    // Handle the status and other data for each device (Alat)
                    if (id_alat === 1) {
                        let statusTextElement1 = '#status1-text';
                        let statusCircleElement1 = '#status1-circle';

                        if (status === 'online') {
                            $(statusTextElement1).text('Online');
                            $(statusCircleElement1).css('background-color', 'green');
                        } else {
                            $(statusTextElement1).text('Offline');
                            $(statusCircleElement1).css('background-color', 'red');
                        }

                        // Update data for Alat 1
                        $('#temperature1').text(data.temperature + ' C');
                        $('#ph1').text(data.ph);
                        $('#tds1').text(data.tds + ' Ppm');
                        $('#do1').text(data.do + ' Ppm');
                        $('#amonia1').text(data.amonia + ' mg/L');
                        $('#label1').text(data.label);
                        $('#status1').text(status);
                        $('#date1').text(data.created_at_date);
                        $('#hour1').text(data.created_at_hour);

                    } else if (id_alat === 2) {
                        let statusTextElement2 = '#status2-text';
                        let statusCircleElement2 = '#status2-circle';

                        if (status === 'online') {
                            $(statusTextElement2).text('Online');
                            $(statusCircleElement2).css('background-color', 'green');
                        } else {
                            $(statusTextElement2).text('Offline');
                            $(statusCircleElement2).css('background-color', 'red');
                        }

                        // Update data for Alat 2
                        $('#temperature2').text(data.temperature + ' C');
                        $('#ph2').text(data.ph);
                        $('#tds2').text(data.tds + ' Ppm');
                        $('#do2').text(data.do + ' Ppm');
                        $('#amonia2').text(data.amonia + ' mg/L');
                        $('#label2').text(data.label);
                        $('#status2').text(status);
                        $('#date2').text(data.created_at_date);
                        $('#hour2').text(data.created_at_hour);
                    }
                }
            });
        }

        setInterval(function() {
            fetchData(1);
            fetchData(2);
        }, 10000);
    </script>
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;

            document.getElementById('clock').textContent = timeString;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
    <script>
        function updateDate() {
            const now = new Date();
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = now.getFullYear();
            const dateString = `${day}-${month}-${year}`;

            document.getElementById('date').textContent = dateString;
        }

        updateDate();
    </script>
</body>

</html>