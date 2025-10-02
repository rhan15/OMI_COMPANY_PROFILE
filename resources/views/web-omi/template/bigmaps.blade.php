    <!--The div element for the map -->
    <div id="map"></div>

    <div style="margin-top:25px;">
        <img src="" onerror="this.src='{{ url('/') }}/images/dummy/Default_Berita.png';this.onerror='';" alt="" style="max-height:200px;border-radius:8px;">
    </div>
    <div style="font-size: 20px;font-weight:bold;margin-top:10px;">
        OMI Mitra Keluarga
    </div>
    <div style="margin-top:5px;margin-bottom:30px;">
        Jalan landas pacu utara, Kebon Kosong, Kemayoran, Jakarta Pusat, DKI Jakarta
    </div>

<script
      src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&callback=initMap"
      defer
    ></script>
    <style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        height: 400px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
      }
    </style>
    <script>
      // Initialize and add the map
      function initMap() {
        // The location of Uluru
        const uluru = { lat: -25.344, lng: 131.036 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 4,
          center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
          position: uluru,
          map: map,
        });
      }
    </script>


