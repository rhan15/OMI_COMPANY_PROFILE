<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

 <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>



<div id="map_page" style="display: none;">
    <div id="mapid" style="height: 500px;"></div>
</div>

<script>
    function bukapetanya(){
        $("#munculpeta").css("display", "none");
        $("#map_page").css("display", "block");
        geolock();
    }
</script>

<script>
    function geolock(){
        $( "#map_page" ).empty();
        $( "#map_page" ).append('<div id="mapid" style="height: 500px;"></div>');
        var cityname_longlat = $("#cities2 option:selected").html();
        // if (cityname_longlat.includes("Kab.") == true) {
        //     cityname_longlat = cityname_longlat.replace('Kab. ','');
        // }else{
        //     if (cityname_longlat.includes("Kota") == true) {
        //         cityname_longlat = cityname_longlat.replace('Kota ','');
        //     }
        // }
        $.ajax({
            url: "{{url('/')}}/getlonglat/"+cityname_longlat,
            type: "GET",
            data: {
            },
                success: function(response) {
                    // console.log(response);
                    var new_longitude = response['longitude'];
                    var new_latitude = response['latitude'];
                    var mymap = L.map('mapid').setView([new_latitude, new_longitude], 11);
                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                        maxZoom: 18,
                        id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1,
                        accessToken: 'pk.eyJ1IjoiZGFuYWtlcmphIiwiYSI6ImNraWlpZHhrdTAyejgyeXAwcTNxYzBtdjQifQ.Bw4Ip_uw-q5S-qyTV0Cbvw'
                    }).addTo(mymap);

                    // marker
                    var theMarker = {};

                    function onMapClick(e) {
                        lat = e.latlng.lat;
                        lon = e.latlng.lng;
                        document.getElementById("latitude").value = lat;
                        document.getElementById("longitude").value = lon;

                        console.log("You clicked the map at LAT: "+ lat+" and LONG: "+lon );
                            //Clear existing marker,

                            if (theMarker != undefined) {
                                mymap.removeLayer(theMarker);
                            };

                        //Add a marker to show where you clicked.
                        theMarker = L.marker([lat,lon]).addTo(mymap);
                    }

                    mymap.on('click', onMapClick);
                },error: function(response) {
                    alert('Terjadi kesalahan : Kelurahan tidak ditemukan');
                    Swal.fire({
                    position: 'center',
                    text: 'Kelurahan tidak ditemukan',
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    });
                },
            });

    }
</script>
