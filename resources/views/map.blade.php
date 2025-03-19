@extends('layout.template')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

    <style>
        #map {
            width: 100%;
            height: calc(100vh - 56px);
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>

    <!-- Modal -->
    <div class="modal fade" id="PointModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambahkan Marker</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pointForm" method="POST" action="{{ route('points.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Isi disini">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geom_point" class="form-label">Geometri</label>
                            <textarea class="form-control" id="geom_point" name="geom_point" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelPoint" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="savePoint" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Polyline Modal -->
    <div class="modal fade" id="PolylineModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="polylineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="polylineModalLabel">Tambahkan Polyline</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="polylineForm" method="POST" action="{{ route('polylines.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="polyline_name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="polyline_name" name="name"
                                placeholder="Isi disini">
                        </div>
                        <div class="mb-3">
                            <label for="polyline_description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="polyline_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geom_polyline" class="form-label">Geometri</label>
                            <textarea class="form-control" id="geom_polyline" name="geom_polyline" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelPolyline"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" id="savePolyline" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Polygon Modal -->
    <div class="modal fade" id="PolygonModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="polygonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="polygonModalLabel">Tambahkan Polygon</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="polygonForm" method="POST" action="{{ route('polygons.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="polygon_name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="polygon_name" name="name"
                                placeholder="Isi disini">
                        </div>
                        <div class="mb-3">
                            <label for="polygon_description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="polygon_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geom_polygon" class="form-label">Geometri</label>
                            <textarea class="form-control" id="geom_polygon" name="geom_polygon" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelPolygon"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" id="savePolygon" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <script>
        // Koordinat Yogyakarta dan Zoom Level 13
        var map = L.map('map').setView([-7.797068, 110.370529], 13);

        // Menyimpan referensi layer marker yang sedang dibuat
        var currentMarker = null;
        var currentPolyline = null;
        var currentPolygon = null;

        // Menambahkan Tile dari OpenStreetMap
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Menambahkan Marker di Yogyakarta
        L.marker([-7.797068, 110.370529]).addTo(map)
            .bindPopup('Yogyakarta<br>Kota Pelajar.')
            .openPopup();

        /* Digitize Function */
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: {
                polyline: true,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: false
            },
            edit: false
        });

        map.addControl(drawControl);

        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;

            console.log(type);
            var drawnJSONObject = layer.toGeoJSON();
            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

            console.log(drawnJSONObject);
            //console.log(objectGeometry);

            if (type === 'polyline') {
                console.log("Create " + type);
                //nanti memunculkan modal create polyline
                currentPolyline = layer;
                $('#geom_polyline').val(objectGeometry);
                $('#PolylineModal').modal('show');
            } else if (type === 'polygon' || type === 'rectangle') {
                console.log("Create " + type);
                currentPolygon = layer;
                $('#geom_polygon').val(objectGeometry)
                $('#PolygonModal').modal('show');
            } else if (type === 'marker') {
                console.log("Create " + type);
                // Simpan referensi ke marker yang sedang dibuat
                currentMarker = layer;
                $('#geom_point').val(objectGeometry);
                //memunculkan modal create marker
                $('#PointModal').modal('show');
                // Tidak langsung menambahkan ke drawnItems, tunggu hingga disimpan
            } else {
                console.log('__undefined__');
                drawnItems.addLayer(layer);
            }
        });

        // Event listener untuk tombol Save
        $('#savePoint').on('click', function(e) {
            // Cek apakah nama sudah diisi
            if (!$('#name').val().trim()) {
                $('#errorToastBody').text('Nama point tidak boleh kosong!');
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
                return false;
            }

            let pointName = $('#name').val();
            let pointDesc = $('#description').val();

            $.ajax({
                url: $('#pointForm').attr('action'),
                method: 'POST',
                data: $('#pointForm').serialize(),
                success: function(response) {
                    $('#PointModal').modal('hide');

                    // Tambahkan layer hanya jika save berhasil
                    if (currentMarker) {
                        // Tambahkan popup dengan informasi point
                        currentMarker.bindPopup("<b>" + pointName + "</b><br>" + pointDesc);
                        drawnItems.addLayer(currentMarker);
                        currentMarker = null; // Reset referensi marker
                    }

                    // Tampilkan toast sukses
                    var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                    successToast.show();
                },
                error: function(xhr) {
                    // Ambil pesan error dari response
                    let errorMessage = "Terjadi kesalahan. Silakan coba lagi.";

                    // Cek apakah ada error validasi
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        if (xhr.responseJSON.errors.name) {
                            // Jika error terkait nama duplikat
                            errorMessage = "Nama point sudah digunakan. Silakan gunakan nama lain.";
                        } else {
                            // Jika ada error validasi lain
                            errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                    }

                    // Tampilkan pesan error di toast
                    $('#errorToastBody').text(errorMessage);
                    var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                    errorToast.show();
                }
            });
        });
        // Event listener for Polyline Save button
        $('#savePolyline').on('click', function(e) {
            // Cek apakah nama sudah diisi
            if (!$('#polyline_name').val().trim()) {
                $('#errorToastBody').text('Nama polyline tidak boleh kosong!');
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
                return false;
            }

            let polylineName = $('#polyline_name').val();
            let polylineDesc = $('#polyline_description').val();

            $.ajax({
                url: $('#polylineForm').attr('action'),
                method: 'POST',
                data: $('#polylineForm').serialize(),
                success: function(response) {
                    $('#PolylineModal').modal('hide');

                    // Tambahkan layer hanya jika save berhasil
                    if (currentPolyline) {
                        // Tambahkan popup dengan informasi polyline
                        currentPolyline.bindPopup("<b>" + polylineName + "</b><br>" + polylineDesc);
                        drawnItems.addLayer(currentPolyline);
                        currentPolyline = null; // Reset referensi polyline
                    }

                    // Update success toast message
                    $('#successToast .toast-body').text('Polyline berhasil disimpan!');
                    // Tampilkan toast sukses
                    var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                    successToast.show();
                },
                error: function(xhr) {
                    // Ambil pesan error dari response
                    let errorMessage = "Terjadi kesalahan. Silakan coba lagi.";

                    // Cek apakah ada error validasi
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        if (xhr.responseJSON.errors.name) {
                            // Jika error terkait nama duplikat
                            errorMessage = "Nama polyline sudah digunakan. Silakan gunakan nama lain.";
                        } else {
                            // Jika ada error validasi lain
                            errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                    }

                    // Tampilkan pesan error di toast
                    $('#errorToastBody').text(errorMessage);
                    var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                    errorToast.show();
                }
            });
        });

        // Event listener for Polygon Save button
        $('#savePolygon').on('click', function(e) {
            // Cek apakah nama sudah diisi
            if (!$('#polygon_name').val().trim()) {
                $('#errorToastBody').text('Nama polygon tidak boleh kosong!');
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
                return false;
            }

            let polygonName = $('#polygon_name').val();
            let polygonDesc = $('#polygon_description').val();

            $.ajax({
                url: $('#polygonForm').attr('action'),
                method: 'POST',
                data: $('#polygonForm').serialize(),
                success: function(response) {
                    $('#PolygonModal').modal('hide');

                    // Tambahkan layer hanya jika save berhasil
                    if (currentPolygon) {
                        // Tambahkan popup dengan informasi polygon
                        currentPolygon.bindPopup("<b>" + polygonName + "</b><br>" + polygonDesc);
                        drawnItems.addLayer(currentPolygon);
                        currentPolygon = null; // Reset referensi polygon
                    }

                    // Update success toast message
                    $('#successToast .toast-body').text('Polygon berhasil disimpan!');
                    // Tampilkan toast sukses
                    var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                    successToast.show();
                },
                error: function(xhr) {
                    // Ambil pesan error dari response
                    let errorMessage = "Terjadi kesalahan. Silakan coba lagi.";

                    // Cek apakah ada error validasi
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        if (xhr.responseJSON.errors.name) {
                            // Jika error terkait nama duplikat
                            errorMessage = "Nama polygon sudah digunakan. Silakan gunakan nama lain.";
                        } else {
                            // Jika ada error validasi lain
                            errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                    }

                    // Tampilkan pesan error di toast
                    $('#errorToastBody').text(errorMessage);
                    var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                    errorToast.show();
                }
            });
        });

        // Reset form dan hapus marker jika modal ditutup tanpa disimpan
        $('#PointModal').on('hidden.bs.modal', function() {
            // Reset fields
            $('#name').val('');
            $('#description').val('');
            $('#geom_point').val('');

            // Hapus marker jika cancel
            if (currentMarker && !drawnItems.hasLayer(currentMarker)) {
                map.removeLayer(currentMarker);
                currentMarker = null;
            }
        });

        // Handler khusus untuk tombol Cancel
        $('#cancelPoint').on('click', function() {
            // Hapus marker saat tombol cancel di-klik
            if (currentMarker) {
                map.removeLayer(currentMarker);
                currentMarker = null;
            }
        });

        // Reset form dan hapus polyline jika modal ditutup tanpa disimpan
        $('#PolylineModal').on('hidden.bs.modal', function() {
            // Reset fields
            $('#polyline_name').val('');
            $('#polyline_description').val('');
            $('#geom_polyline').val('');

            // Hapus polyline jika cancel
            if (currentPolyline && !drawnItems.hasLayer(currentPolyline)) {
                map.removeLayer(currentPolyline);
                currentPolyline = null;
            }
        });

        // Handler khusus untuk tombol Cancel polyline
        $('#cancelPolyline').on('click', function() {
            // Hapus polyline saat tombol cancel di-klik
            if (currentPolyline) {
                map.removeLayer(currentPolyline);
                currentPolyline = null;
            }
        });

        // Reset form dan hapus polygon jika modal ditutup tanpa disimpan
        $('#PolygonModal').on('hidden.bs.modal', function() {
            // Reset fields
            $('#polygon_name').val('');
            $('#polygon_description').val('');
            $('#geom_polygon').val('');

            // Hapus polygon jika cancel
            if (currentPolygon && !drawnItems.hasLayer(currentPolygon)) {
                map.removeLayer(currentPolygon);
                currentPolygon = null;
            }
        });

        // Handler khusus untuk tombol Cancel polygon
        $('#cancelPolygon').on('click', function() {
            // Hapus polygon saat tombol cancel di-klik
            if (currentPolygon) {
                map.removeLayer(currentPolygon);
                currentPolygon = null;
            }
        });
    </script>

    <script>
        // Pastikan toast sudah terinisialisasi
        document.addEventListener('DOMContentLoaded', function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000 // Toast akan hilang setelah 5 detik
                });
            });
        });
    </script>
@endsection
