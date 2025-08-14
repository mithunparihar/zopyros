var mapZoom = 15;
$(".smpbtn").show();
$("input[name=location]").on("change", function () {
    var address = $(this).val();
    if (address.length > 3) {
        getlocationByAddress(address, 15);
        hideMapBtn(false);
    }
});

$("input[name=location]").on("keyup", function () {
    var address = $(this).val();
    if (address.length > 3) {
        hideMapBtn(true);
    }
});
$(".smpbtn").on("click", function () {
    var address = $("input[name=location]").val();
    getlocationByAddress(address, 15);
    hideMapBtn(false);
    $(".mapCanvasBox").show();
});
$(".smpbtn").on("click", function () {
    var address = $("input[name=location]").val();
    hideMapBtn(false);
    $(".mapCanvasBox").show();
});

$(".hmpbtn").on("click", function () {
    $(".smpbtn").show();
    $(".hmpbtn").hide();
    $(".mapCanvasBox").hide();
    hideMapBtn(true);
});

if (preCategoryId) {
    getCategoryTags(preCategoryId);
}
if (preCountryId) {
    getSelectCountry(preCountryId,preStateId);
}
if (preStateId) {
    getSelectState(preStateId,preCityId);
    
}

function getSelectCountry(countryId,preStateId=null) {
    const Url = countryStates;
    const getResponse = ajaxUrl(Url, 'Post', {
        countryId: countryId,
        _token: $('meta[name=csrf-token]').attr('content')
    });
    getResponse.done(function(json) {
        let Html = '';
        Html += '<label class="form-label" for="country">Province / State</label>';
        Html += '<select id="states" name="states" class="select2 form-select" onChange=getSelectState(this.value)>';
        Html += '<option value="">Select Province / State</option>';
        json?.forEach((items) => {
            let  selected = '';
            if(preStateId==items?.id){  selected='selected';}
            Html += '<option value="' + items?.id + '" '+selected+' >' + items?.name + '</option>';
        });
        Html += '</select>';
        $('.stateBoxHere').html(Html);
        $('.select2').select2();
        const myCountryCode =  json[0]?.countryinfo?.sortname;
        googleAutocomplete(myCountryCode);
        getlocationByAddress(json[0]?.countryinfo?.name,4);
        hideMapBtn(false);
        // $('#location').val('');
        $('.LocationBox').hide();
    });
}

function getSelectState(stateId,preCityId=null) {
    const Url = statesCity;
    const getResponse = ajaxUrl(Url, 'Post', {
        stateId: stateId,
        _token: $('meta[name=csrf-token]').attr('content')
    });
    getResponse.done(function(json) {
        let Html = '';
        Html += '<label class="form-label" for="country">City</label>';
        Html += '<select id="city" class="select2 form-select" name="cities" onChange=getCityInfo(this.value)>';
        Html += '<option value="">Select City</option>';
        json?.forEach((items) => {
            let  selected = '';
            if(preCityId==items?.id){ 
                 selected='selected';
            }
            Html += '<option value="' + items?.id + '"  '+selected+' >' + items?.name + '</option>';
        });
        Html += '</select>';
        $('.cityBoxHere').html(Html);
        $('.select2').select2();
        getlocationByAddress(json[0]?.stateinfo?.name,6);
        hideMapBtn(false);
        
        if(preCityId){ getCityInfo(preCityId,true);  }
        else{
            // $('#location').val('');
            $('.LocationBox').hide();
        }
    });
}

function getCityInfo(cityId,showMap=true){
    const stateName = $('#states').find(":selected").html();
    const cityName = $('option[value='+cityId+']').html();
    if(showMap){
        getlocationByAddress(stateName+', '+cityName,12);
        hideMapBtn(false);
    }
    $('.LocationBox').show();
    // $('#location').val('');
}

function getlocationByAddress(address, zoom) {
    var geocoder = new google.maps.Geocoder();
    mapZoom = zoom;
    geocoder.geocode({ address: address }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var latitude = results[0].geometry.location.lat();
            var longitude = results[0].geometry.location.lng();
        }
        console.warn('address',results[0] ?? '');
        jQuery("#latitude").val(latitude);
        jQuery("#longitude").val(longitude);
        intilizeMap(latitude, longitude);
        $(".latlngbox").html(
            "latitude: " + latitude + " & longitude: " + longitude
        );
        // geoCodefunction(latitude, longitude);
    });
}


function googleAutocomplete(myCountryCode) {
    var ac = new google.maps.places.Autocomplete(
        document.getElementById("location"),
        {
            types: ["geocode"],
            componentRestrictions: { country: myCountryCode },
            strictBounds: true,
        }
    );
    ac.addListener("place_changed", function () {
        var place = ac.getPlace();
        console.warn('place',place);
        let latitude = place?.geometry?.location.lat();
        let longitude = place?.geometry?.location.lng();
        jQuery("#latitude").val(latitude);
        jQuery("#longitude").val(longitude);
        $(".latlngbox").html(
            "latitude:" + latitude + " & longitude:" + longitude
        );
        intilizeMap(latitude, longitude);
        // $('.smpbtn').show();
        geoCodefunction(latitude, longitude);
    });
}

async function intilizeMap(latitude = null, longitude = null) {
    const position = { lat: latitude ?? -25.344, lng: longitude ?? 131.031 };
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    map = new Map(document.getElementById("mapCanvas"), {
        zoom: mapZoom,
        center: position,
        mapId: "4504f8b37365c3d0",
    });

    // The marker, positioned at Uluru
    const beachFlagImg = document.createElement("img");
    beachFlagImg.src = $('meta[name=locationPin]').attr('content');
    beachFlagImg.width = 30;
    const marker = new AdvancedMarkerElement({
        map: map,
        position: position,
        gmpDraggable: true,
        content: beachFlagImg,
    });
    $("#mapCanvas").addClass("border");
    marker.addListener("click", ({ domEvent, latLng }) => {
        const { target } = domEvent;
        console.warn("Click Event Is Here");
    });
    $(".latlngbox").html(
        "latitude: " + position?.lat + " & longitude: " + position?.lng
    );
    google.maps.event.addListener(map, "click", function (event) {
        var result = [event.latLng.lat(), event.latLng.lng()];
        console.warn(result);
        marker.position = { lat: result[0], lng: result[1] };
        jQuery("#latitude").val(result[0]);
        jQuery("#longitude").val(result[1]);
        $(".latlngbox").html(
            "latitude: " + result[0] + " & longitude: " + result[1]
        );
    });

    marker.addListener("dragend", (event) => {
        const position = marker.position;
        jQuery("#latitude").val(position.lat);
        jQuery("#longitude").val(position.lng);
        $(".latlngbox").html(
            "latitude: " + position.lat + " & longitude: " + position.lng
        );
    });
}

function geoCodefunction(lat, lng) {
    var geocode = (geocoder = new google.maps.Geocoder());
    const latlng = new google.maps.LatLng(lat, lng);
    geocode.geocode({ latLng: latlng }, function (result, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            console.warn("full--", result[0]);
            let geoAddress = result[0].formatted_address;
            let geoPin =
                result[0].address_components[
                    result[0].address_components.length - 1
                ]?.long_name;
            let geoCountry =
                result[0].address_components[
                    result[0].address_components.length - 2
                ]?.long_name;
            let geoState =
                result[0].address_components[
                    result[0].address_components.length - 3
                ]?.long_name;
            let geoCity =
                result[0].address_components[
                    result[0].address_components.length - 6
                ]?.long_name;

            let selectedCountry = $('#country').find(':selected').html();
            selectedCountry = selectedCountry.trim().toUpperCase();

            let selectedCity = $('#city').find(':selected').html();
            selectedCity = selectedCity.trim().toUpperCase();
            if(geoCity.toUpperCase()!=selectedCity){
                $('#location').val('');
                alert('Please add correct address/location.');
            }

            // if( (geoCountry.toUpperCase()!=selectedCountry) || (geoCity.toUpperCase()!=selectedCity) ){
            //     $('#location').val('');
            //     hideMapBtn(true);
            //     $('.mapCanvasBox').hide();
            //     $('.smpbtn').hide();
            // }

        }
    });
}

function hideMapBtn(hide = true) {
    if (hide) {
        $(".hmpbtn").hide();
        $(".smpbtn").show();
    } else {
        $(".hmpbtn").show();
        $(".smpbtn").hide();
    }
}