<div id="minimap" style="width: 100%; height: 100%"></div>
<script>
    // Initialize and add the map
    function initMap() {
    // The location of Uluru
    var lat = parseFloat("{{$Company[0]['latitude']}}");
    var long = parseFloat("{{$Company[0]['longitude']}}");
    var minimap = {lat: lat, lng: long};
    // The map, centered at Uluru
    var map = new google.maps.Map(
        document.getElementById('minimap'), {zoom: 15, center: minimap});
    // The marker, positioned at Uluru
    var marker = new google.maps.Marker({position: minimap, map: map});
    }
</script>
<script defer
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&callback=initMap">
</script>
