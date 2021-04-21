
<html>
    <head>
        <title>Geolocation Testing</title>
    </head>
    <body>
        My Latitude: <span id="lat">0.00</span><br/>
        My Longitude: <span id="long">0.00</span>
    </body>
    <script>
        const watcher = navigator.geolocation.watchPosition(displayLocationInfo);

        setTimeout(() => {
        navigator.geolocation.clearWatch(watcher);
        }, 15000);

        function displayLocationInfo(position) {
            const lng = position.coords.longitude;
            const lat = position.coords.latitude;

            document.getElementById('lat').innerHTML = lat;
            document.getElementById('long').innerHTML = lng;
            console.log(`longitude: ${ lng } | latitude: ${ lat }`);
        }
    </script>
</html>