<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beats Per Minute Calculator and Counter</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
          integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --blue: hsl(192, 38%, 48%);
            --violet: hsl(266, 34%, 53%);
            --white: hsl(0, 0%, 100%);
            --dark-gray: hsl(243, 19%, 19%);
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            color: #A3A3AD;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        strong {
            font-weight: 500;
            color: var(--dark-gray);
        }

        .btn,
        button {
            border-radius: 50px;
            padding: 15px 20px;
            background-color: #F6F6F6;
            border: 1px solid #F6F6F6;
            cursor: pointer;
            font-weight: 500;
            transition: all 300ms ease-in-out;
        }

        .btn--blue {
            background-color: var(--blue);
            color: var(--white);
        }

        .btn--blue:hover {
            background-color: hsl(192, 38%, 38%);
        }

        .btn--blue:active,
        .btn--blue:focus {
            box-shadow: 0 0 0 3px hsla(192, 38%, 48%, 0.5);
        }

        .btn--violet {
            background-color: var(--violet);
            color: var(--white);
        }

        .btn--violet:hover {
            background-color: hsl(266, 34%, 34%);
        }

        .btn--violet:active,
        .btn--violet:focus {
            box-shadow: 0 0 0 3px hsla(266, 34%, 53%, 0.5);
        }

        .app-header,
        .app-main {
            max-width: 600px;
            margin: 0 auto;
        }

        .app-header {
            padding: 50px 0;
        }

        .app-buttons {
            margin-top: 50px;
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(2, 1fr);
        }
    </style>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const counterBtn = document.querySelector('#bpmCounter');
            const average = document.querySelector('#bpmAverage');
            const nearestWhole = document.querySelector('#bpmNearestWhole');
            const timingTaps = document.querySelector('#bpmTimingTaps');
            const resetBtn = document.querySelector('#bpmReset');
            const wait = document.querySelector('#bpmWait');

            let count = 0;
            let msecsFirst = 0;
            let msecsPrevious = 0;

            function countBpm() {
                const timeSeconds = new Date();
                const msecs = timeSeconds.getTime();
                const waitValue = wait.value || 2;

                if ((msecs - msecsPrevious) > 1000 * waitValue) {
                    count = 0;
                }

                if (count == 0) {
                    average.textContent = "First Beat";
                    timingTaps.textContent = "First Beat";
                    msecsFirst = msecs;
                    count = 1;
                } else {
                    let bpmAvg = 60000 * count / (msecs - msecsFirst);
                    average.textContent = Math.round(bpmAvg * 100) / 100;
                    nearestWhole.textContent = Math.round(bpmAvg);
                    count++;
                    timingTaps.textContent = count;
                }
                msecsPrevious = msecs;
            }

            function resetCounter() {
                average.textContent = '';
                nearestWhole.textContent = '';
                timingTaps.textContent = '';
                count = 0;
                msecsFirst = 0;
                msecsPrevious = 0;
                wait.value = 2;
            }

            function debounce(func, delay) {
                let timeout;
                return function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, arguments), delay);
                };
            }

            document.addEventListener('keypress', debounce(countBpm, 100));
            counterBtn.addEventListener('click', countBpm);
            resetBtn.addEventListener('click', resetCounter);
        });
    </script>
</head>

<body>
<noscript>
    <h2>Please enable JavaScript in your browser to use the Beats Per Minute Calculator and Counter.</h2>
</noscript>
<header class="app-header">
    <h1>Beats Per Minute Calculator and Counter</h1>
    <p>Click button or tap any key along with the beat to find your BPM tempo in seconds.</p>
</header>
<main class="app-main">
    <p>Average BPM: <strong id="bpmAverage"></strong></p>
    <p>Nearest Whole: <strong id="bpmNearestWhole"></strong></p>
    <p>Timing Taps: <strong id="bpmTimingTaps"></strong></p>
    <label for="bpmWait">Pause: </label>
    <select id="bpmWait" name="bpm_wait">
        <option value="1">1 second</option>
        <option value="2" selected>2 seconds</option>
        <option value="3">3 seconds</option>
        <option value="4">4 seconds</option>
        <option value="5">5 seconds</option>
    </select>

    <div class="app-buttons">
        <button id="bpmCounter" class="btn btn--blue">Count</button>
        <button id="bpmReset" class="btn btn--violet">Reset</button>
    </div>
</main>
</body>

</html>