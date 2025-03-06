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
                            <h6 class="m-0 font-semibold text-gray-700">History</h6>
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

                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mt-4">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-700">
                                        <th class="px-4 py-2 border">Suhu</th>
                                        <th class="px-4 py-2 border">pH</th>
                                        <th class="px-4 py-2 border">TDS</th>
                                        <th class="px-4 py-2 border">DO</th>
                                        <th class="px-4 py-2 border">Hasil</th>
                                        <th class="px-4 py-2 border">Label</th>
                                        <th class="px-4 py-2 border">ID Alat</th>
                                        <th class="px-4 py-2 border">Tanggal Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-2 border text-center">{{ $item->suhu }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $item->ph }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $item->tds }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $item->do }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $item->hasil }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $item->label }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $item->id_alat }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $item->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4">
                                {{ $data->links() }}
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