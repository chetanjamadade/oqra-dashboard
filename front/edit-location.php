<?php
$page_name = "edit-location.php";
include 'header.php';

$edit_id = ( isset($_GET["id"]) && $_GET["id"] > 0 ) ? $_GET["id"] : 0;

if( $edit_id > 0 && $location->exists( $edit_id ) ) {
    $location_data = $location->get_one($edit_id);
}

?>

    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 250px;
        }
        #description {
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
        }

        #infowindow-content .title {
            font-weight: bold;
        }

        #infowindow-content {
            display: none;
        }

        #map #infowindow-content {
            display: inline;
        }

        .pac-card {
            margin: 10px 10px 0 0;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            font-family: Roboto;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }
        #target {
            width: 345px;
        }
    </style>
    <style>
        #locationField, #controls {
            position: relative;
            width: 480px;
        }
        #autocomplete {
            position: relative;
            top: 0px;
            left: 0px;
            width: 99%;
        }
        .label {
            text-align: right;
            font-weight: bold;
            width: 100px;
            color: #303030;
        }
        #address {
            border: 1px solid #000090;
            background-color: #f0f0ff;
            width: 480px;
            padding-right: 2px;
        }
        #address td {
            font-size: 10pt;
        }
        .field {
            width: 99%;
        }
        .slimField {
            width: 80px;
        }
        .wideField {
            width: 200px;
        }
        #locationField {
            height: 20px;
            margin-bottom: 20px;
            display: inline-block;
            width: 100%;
        }
        #locationField input{
            width: 99%;
        }
    </style>


<div id="main-content">
    <div id="branding-bar">
        <a href="#" id="open-side-menu"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
    </div>
    <!-- // brandig bar  -->
    <header id="main-header">
        <h1>Edit Location</h1>
        <h2>Edit OQRA location</h2>
    </header>
    <!-- // main header  -->
    <form  action="<?php echo action_url(); ?>" method="POST" enctype="multipart/form-data" id="add-location-form">

        <?php hidden_action_inputs( 'edit_location' ); ?>
        <input type="hidden" name="location_id" value="<?php echo $location_data->location_id; ?>">
        <input type="hidden" name="client_id" value="<?php echo $location_data->client_id; ?>">
        <input type="hidden" name="lc_id" value="<?php echo $location_data->lc_id; ?>">



        <div id="clients-content">
            <div id="accordion-form">

                <!-- New location -->
                <h3>Edit Location</h3>
                    <div class="form-content">

                        <div class="row" >

                            <div class="form-horizontal col-xs-12 col-sm-6">
                            <div class="form-group">
                            <h4>Find by address:</h4>
                                <div id="locationField">
                            <input type="text" name="search"  placeholder="Start Typing Address" id="autocomplete" value="<?php echo $location_data->street . "," . $location_data->city; ?>"
                                   onFocus="geolocate()"/>
                            </div>
                            </div>
                            <div class="form-group">
                            <h4>Street: <span class="requiredRed">*</span></h4>
                            <input type="text" name="street" id="route" value="<?php echo $location_data->street; ?>"  class="required" />
                            </div>
                            <div class="form-group">
                            <h4>Zip Code: <span class="requiredRed">*</span></h4>
                            <input type="text" name="zip_code" id="postal_code" value="<?php echo $location_data->zip_code; ?>" class="required"/>
                            </div>


                            </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                            <h4>Name: <span class="requiredRed">*</span></h4>
                            <input type="text" name="location_name" id="name" placeholder="Adress" value="<?php echo $location_data->location_name; ?>" class="required" />
                            </div>
                            <div class="form-group">
                            <h4>City: <span class="requiredRed">*</span></h4>
                            <input type="text" name="city" id="locality" value="<?php echo $location_data->city; ?>" class="required" />
                            </div>
                            <div class="form-group">
                            <h4>State: <span class="requiredRed">*</span></h4>
                            <input type="text" name="state" id="country" value="<?php echo $location_data->state; ?>"  class="required" />
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div id="map"></div>
                                <div class="clear:both;"></div>
                                <div>You can drag and drop the marker to the correct location</div>
                            </div>
                        </div>
                        <input type="hidden" name="latitude" id="latitude" value="<?php echo $location_data->latitude; ?>">
                        <input type="hidden" name="longitude" id="longitude" value="<?php echo $location_data->longitude; ?>">
                    </div>
                <!-- Text configuration -->
                <h3>Text configuration for this client</h3>
                <div class="form-content">
                    <div class="row">
                        <div class="form-horizontal col-md-12">
                            <div class="panel-body" id="profileDetails">
                                <div class="row">
                                    <div class="form-horizontal col-md-6 col-xs-12">
                                        <h4>Extremly Satisfied Text: <span class="requiredRed">*</span></h4>
                                        <textarea name="ex_satisfied_txt" class="required"><?php echo $location_data->ex_satisfied_txt; ?></textarea>
                                    </div>
                                    <div class="form-horizontal col-md-6 col-xs-12">
                                        <h4>Very Satisfied Text: <span class="requiredRed">*</span></h4>
                                        <textarea name="very_satisfied_text" class="required"><?php echo $location_data->very_satisfied_text; ?></textarea>
                                    </div>
                                    <div class="form-horizontal col-md-6 col-xs-12">
                                        <h4>Satisfied Text: <span class="requiredRed">*</span></h4>
                                        <textarea name="satisfied_text" class="required"><?php echo $location_data->satisfied_text; ?></textarea>
                                    </div>
                                    <div class="form-horizontal col-md-6 col-xs-12">
                                        <h4>Dissatisfied Text: <span class="requiredRed">*</span></h4>
                                        <textarea name="dissatisfied_text" class="required"><?php echo $location_data->dissatisfied_text; ?></textarea>
                                    </div>
                                    <div class="form-horizontal col-md-6 col-xs-12">
                                        <h4>Very Dissatisfied Text: <span class="requiredRed">*</span></h4>
                                        <textarea name="very_dissat_text" class="required"><?php echo $location_data->very_dissat_text; ?></textarea>
                                    </div>
                                    <div class="form-horizontal col-md-6 col-xs-12">
                                        <h4>Thank you Text: <span class="requiredRed">*</span></h4>
                                        <textarea name="thank_you" class="required"><?php echo $location_data->thank_you; ?></textarea>
                                    </div>
                                    <div class="form-horizontal col-md-6 col-xs-12">
                                        <h4>Pre-defined text for audio review: <span class="requiredRed">*</span></h4>
                                        <textarea name="voice_text" class="required"><?php echo $location_data->voice_text; ?></textarea>
                                    </div>
                                    <div class="form-horizontal col-md-6">
                                        <h4>Pre-defined text for video review: <span class="requiredRed">*</span></h4>
                                        <textarea name="video_text" class="required"><?php echo $location_data->video_text; ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <p><strong>Short codes for audio/video review:</strong></p>
                                        <p>for customer full name</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Emails configuration -->
                <h3>Emails Configuration for this location</h3>
                <div class="form-content">
                    <div class="row">
                        <div class="form-horizontal col-md-6">
                            <h4>Image in email for 4-5 stars:</h4>
                                <!--<?php if (isset($companydetail['email_img']) && $companydetail['email_img'] != ''): ?> -->
                                <!--<a href="<?php echo $companydetail['email_img1']; ?>" target="_blank"><img src="" style="width:100%; margin-bottom:5px !important; margin-top:5px !important;" height="100"/></a> -->
                                <!-- <?php endif; ?>-->
                            <?php edit_image_4_5_box($location_data->email_image_4_5) ?>
                            <p>Best dimension: 600px x 156px</p>
                        </div>
                        <div class="form-horizontal col-md-6">
                            <h4>Image in email for 3 stars and under:</h4>
                             <?php edit_image_3_under_box($location_data->email_image_3_under) ?>
                            <p>Best dimension: 600px x 156px</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-horizontal col-md-6">
                            <h4>Email text for 4 and 5 star ratings: <span class="requiredRed">*</span></h4>
                            <textarea name="email_4_5" class="required"><?php echo $location_data->email_4_5; ?></textarea>
                        </div>
                        <div class="form-horizontal col-md-6">
                            <h4>Email/messaging text for 3 stars and under ratings: <span class="requiredRed">*</span></h4>
                            <textarea name="email_3_under" class="required"><?php echo $location_data->email_3_under; ?></textarea>
                        </div>
                        <div class="form-horizontal col-md-6">
                            <p><strong>For email texts use these short codes:</strong></p>
                            <p style="font-weight: bold;">%t for review text OR link to audio/video review | %s for customer first name</p>
                            <p style="font-weight: bold;">%l for lastname | %r for number of stars | e for customer email | %p for customer phone</p>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;" >
                        <div class="form-horizontal col-md-6">
                            <h4>E-mail addresses for 4-5 stars: <span class="requiredRed">*</span></h4>
                            <textarea class="required" name="email_address_4_5"><?php echo $location_data->email_address_4_5; ?></textarea>
                            <p>Above persons will receive emails for reviews rated with 4 and 5 stars</p>
                            <p>Note: use comma to separate between emails: user@mail.com,user1@mail.com ...</p>
                        </div>
                        <div class="form-horizontal col-md-6">
                            <h4>E-mail addresses for 3 and under stars: <span class="requiredRed">*</span></h4>
                            <textarea class="required" name="email_address_3_under"><?php echo $location_data->email_address_3_under; ?></textarea>
                            <p>Above persons will receive emails for reviews rated with 3 and under stars</p>
                            <p>Note: use comma to separate between emails: user@mail.com,user1@mail.com ...</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-horizontal col-md-6">
                            <h4>Text messaging number(s) for 4 and 5 stars:</h4>
                            <textarea name="sms_4_5" ><?php echo $location_data->sms_4_5; ?></textarea>
                            <p>Enter phone number(s) comma separated with country prefix: +12101234567</p>
                        </div>
                        <div class="form-horizontal col-md-6">
                            <h4>Text messaging number(s) for 3 and under stars</h4>
                            <textarea name="sms_3_under"><?php echo $location_data->sms_3_under; ?></textarea>
                            <p>Enter phone number(s) comma separated with country prefix: +12101234567</p>
                        </div>
                        <div class="form-horizontal col-md-6">
                            <p><strong>For text messaging texts use these short codes:</strong></p>
                            <p style="font-weight: bold;">%t for review text OR link to audio/video review | %s for customer first name</p>
                            <p style="font-weight: bold;">%l for lastname | %r for number of stars | e for customer email | %p for customer phone</p>
                        </div>
                    </div>
                </div>
                <!-- Admin Email -->
                <h3>Admin Email Notification</h3>
                <div class="form-content">
                    <div class="row">
                        <div class="form-horizontal col-md-6">
                            <h4>Email Text: <span class="requiredRed">*</span></h4>
                            <textarea class="required" name="admin_email"><?php echo $location_data->admin_email; ?></textarea>
                            <p>This email will be sent to emails defined above for 4-5 stars as notification that someone has reviewed your company</p>
                            <p><strong>Short codes:</strong></p>
                            <p>%t for review text OR link to audio/video review</p>
                            <p>%s for customer first name</p>
                            <p>%l for lastname</p>
                            <p>%r for number of stars</p>
                            <p>%e for customer email</p>
                            <p>%p for customer phone</p>
                        </div>
                    </div>
                </div>
                <!-- Appointment Button -->
                <h3>Appointment Settings</h3>
                <div class="form-content">
                    <div class="row">
                        <div class="form-horizontal col-md-6">
                            <h4>Enable Appointment Button:</h4>
                            <select name="ap_enabled">
                                <option value="1" <?php if ($location_data->ap_enabled == 1) echo ' selected="selected"'; ?>>Yes</option>
                                <option value="0" <?php if ($location_data->ap_enabled == 0) echo ' selected="selected"'; ?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-horizontal col-md-6">
                            <h4>Button Text</h4>
                            <input name="ap_text" type="text"  value="<?php echo $location_data->ap_text; ?>">
                        </div>
                        <div class="form-horizontal col-md-6">
                            <h4>Button URL</h4>
                            <input name="ap_url" type="text"  value="<?php echo $location_data->ap_url; ?>" data-validation="url" data-validation-optional="true"/>
                        </div>
                    </div>
                </div>
                <!-- Social Networks configuration -->
                <h3>Social Networks Configuration for this location</h3>
                <div class="form-content">
                    <div class="panel-body" id="profileDetails">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h2 style="margin-bottom: 25px; border-bottom:1px solid #ddd; color:#A0ACBF;">Facebook</h2>
                                <h4>Link: <span class="requiredRed">*</span></h4>
                                <input type="text" class="required" name="link_fb"  value="<?php echo $location_data->link_fb; ?>">
                                <p class="desc">Note: use short urls. Click <a target="_blank" href="https://bitly.com/">here</a> to generate one</p>
                                <h4>Is Active ?</h4>
                                <select name="active_fb">
                                    <option value="1" <?php if ($location_data->active_fb == 1) echo ' selected="selected"'; ?>>Yes</option>
                                    <option value="0" <?php if ($location_data->active_fb == 0) echo ' selected="selected"'; ?>>No</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <h2 style="margin-bottom: 25px; border-bottom:1px solid #ddd; color:#A0ACBF;">Twitter</h2>
                                <h4>Link: <span class="requiredRed">*</span></h4>
                                <input type="text" class="required" name="link_twitter"  value="<?php echo $location_data->link_twitter; ?>">
                                <p class="desc">Note: use short urls. Click <a target="_blank" href="https://bitly.com/">here</a> to generate one</p>
                                <h4>Description: </h4>
                                <textarea name="desc_twitter"><?php echo $location_data->desc_twitter; ?></textarea>
                                <h4>Is Active ?</h4>
                                <select name="active_twitter" value="<?php echo $location_data->active_twitter; ?>">
                                    <option value="1" <?php if ($location_data->active_twitter == 1) echo ' selected="selected"'; ?>>Yes</option>
                                    <option value="0" <?php if ($location_data->active_twitter == 0) echo ' selected="selected"'; ?>>No</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <h2 style="margin-bottom: 25px; border-bottom:1px solid #ddd; color:#A0ACBF;">Pinterest</h2>
                                <h4>Link: <span class="requiredRed">*</span></h4>
                                <input type="text" class="required" name="link_pinterest" value="<?php echo $location_data->link_pinterest; ?>">
                                <p class="desc">Note: use short urls. Click <a target="_blank" href="https://bitly.com/">here</a> to generate one</p>
                                <h4>Description: </h4>
                                <textarea name="desc_pinterest"><?php echo $location_data->desc_pinterest; ?></textarea>
                                <h4>Is Active ?</h4>
                                <select name="active_pinterest" value="<?php echo $location_data->active_pinterest; ?>">
                                    <option value="1" <?php if ($location_data->active_pinterest == 1) echo ' selected="selected"'; ?>>Yes</option>
                                    <option value="0" <?php if ($location_data->active_pinterest == 0) echo ' selected="selected"'; ?>>No</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <h2 style="margin-bottom: 25px; border-bottom:1px solid #ddd; color:#A0ACBF;">Yelp</h2>
                                <h4>Link: <span class="requiredRed">*</span></h4>
                                <input type="text" class="required" name="link_yelp" value="<?php echo $location_data->link_yelp; ?>">
                                <p class="desc">Note: use short urls. Click <a target="_blank" href="https://bitly.com/">here</a> to generate one</p>
                                <h4>Is Active ?</h4>
                                <select name="active_yelp">
                                    <option value="1" <?php if ($location_data->active_yelp == 1) echo ' selected="selected"'; ?>>Yes</option>
                                    <option value="0" <?php if ($location_data->active_yelp == 0) echo ' selected="selected"'; ?>>No</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <h2 style="margin-bottom: 25px; border-bottom:1px solid #ddd; color:#A0ACBF;">Gplus</h2>
                                <h4>Link: <span class="requiredRed">*</span></h4>
                                <input type="text" class="required" name="link_google" value="<?php echo $location_data->link_google; ?>">
                                <p class="desc">Note: use short urls. Click <a target="_blank" href="https://bitly.com/">here</a> to generate one</p>
                                <h4>Is Active ?</h4>
                                <select name="active_google">
                                    <option value="1" <?php if ($location_data->active_google == 1) echo ' selected="selected"'; ?>>Yes</option>
                                    <option value="0" <?php if ($location_data->active_google == 0) echo ' selected="selected"'; ?>>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Action area -->
        <div class="row" id="action-area">
            <div class="col-md-6">
                <button type="submit" class="save-setting-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
            </div>
            <div class="col-md-6">
            </div>
        </div>
</div>

</form>
<!-- // app content   -->

<?php include 'footer.php'; ?>
<script type="text/javascript">
    prepare_for_validation(['street', 'zip_code', 'location_name', 'city' ,'state','ex_satisfied_txt','very_satisfied_text', 'satisfied_text', 'dissatisfied_text', 'very_dissat_text','thank_you', 'voice_text','video_text','email_4_5','email_3_under', 'email_address_4_5', 'email_address_3_under'],'add-location-form');
</script>
<script>
    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>
    <script>

        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: document.getElementById('latitude'), lng: document.getElementById('longitude')},
                zoom: 8
            });
        }

        $(document).ready(function() {
            $('#zipcode').on('keypress',function(e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });


            function updateFields(address) {
                $('#city').val(address.city);
                $('#state').val(address.stateOrProvince);
                $('#zipcode').val(address.postalCode);
                $('#address1').val(address.addressLine1);
            }

        });
    </script>
<script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    var placeSearch, autocomplete;

    var componentForm = {
        route: 'long_name',
        country: 'long_name',
        locality: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        // autocomplete.addListener('place_changed', fillInAddress);

        //map
        var MyLatLng= {lat: parseFloat(document.getElementById('latitude').value), lng: parseFloat(document.getElementById('longitude').value)};

        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: parseFloat(document.getElementById('latitude').value), lng: parseFloat(document.getElementById('longitude').value)},
            zoom: 13,
            mapTypeId: 'roadmap'
        });

        var markers = [];
        markers.push(new google.maps.Marker({
            map: map,
            title: '',
            draggable: true,
            position: MyLatLng
        }));
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;
        google.maps.event.addListener(markers[0], 'dragend', function (event) {
            document.getElementById("latitude").value =  this.getPosition().lat();
            document.getElementById("longitude").value =  this.getPosition().lng();
            geocodeLatLng(geocoder,map,infowindow, markers[0])

        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('autocomplete');
        var searchBox = new google.maps.places.SearchBox(input);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });



        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            var place = places[0];

            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
            document.getElementById("name").value = place.name;



            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];
            var geocoder = new google.maps.Geocoder;
            var infowindow = new google.maps.InfoWindow;

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    draggable: true,
                    position: place.geometry.location
                }));


                google.maps.event.addListener(markers[0], 'dragend', function (event) {
                    document.getElementById("latitude").value =  this.getPosition().lat();
                    document.getElementById("longitude").value =  this.getPosition().lng();
                    geocodeLatLng(geocoder,map,infowindow, markers[0])

                });

                document.getElementById("longitude").value = place.geometry.location.lng();
                document.getElementById("latitude").value = place.geometry.location.lat();

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);


        });
    }

    function geocodeLatLng(geocoder, map, infowindow, marker) {
        var input = document.getElementById('latitude').value;
        var input2 = document.getElementById('longitude').value;
        var latlng = {lat: parseFloat(input), lng: parseFloat(input2)};
        geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === 'OK') {
                if (results[1]) {
                    map.setZoom(15);
                    infowindow.setContent(results[1].formatted_address);
                    document.getElementById('name').value =results[1].formatted_address.toString();
                    document.getElementById('autocomplete').value =results[1].formatted_address.toString();
                    infowindow.open(map, marker);
                    $.each(results[0].address_components, function(){
                        switch(this.types[0]){
                            case "postal_code":
                                document.getElementById('postal_code').value = this.short_name;
                                break;
                            case "route":
                                document.getElementById('route').value = this.short_name;
                                break;
                            case "locality":
                                document.getElementById('locality').value = this.short_name;
                                break
                            case "country":
                                document.getElementById('country').value = this.long_name;
                                break;
                        }
                    });
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
    }




    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };




                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1vpO5lk3BRcCB7HeoPotqui6QO0b6oHg&libraries=places&callback=initAutocomplete"
            async defer></script>

<script type="text/javascript">
    function showCompany(lat, lng) {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13,
            mapTypeId: 'roadmap'
        });
        var position = new google.maps.LatLng(document.getElementById("latitude").value,document.getElementById("longitude").value);
        map.setCenter(position);
        alert('ok');

    };
</script>