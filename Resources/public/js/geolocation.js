var isPhilLocationMenu = false;

var philGeolocation =
{
  latitude: 0,
  longitude: 0,
  geotype: 'undefined',
  cityname: '',

  init: function () {
    var info = $.cookie('phil-geolocation');

    if (typeof info !== 'undefined') {
      this.latitude = info.latitude;
      this.longitude = info.longitude;
      this.geotype = info.geotype;
      this.cityname = info.cityname;
    }
  },

  saveGeolocationCookie: function () {
    $.cookie('phil-geolocation', {'latitude': this.latitude, 'longitude': this.longitude, 'geotype': this.geotype, 'cityname': this.cityname});
  },

  getCurrentLocation: function (reloadPage) {
    reloadPage = typeof reloadPage !== 'undefined' ? reloadPage : true;

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
            this.latitude = position.coords.latitude;
            this.longitude = position.coords.longitude;
            this.geotype = 'user';
            this.cityname = '';
            this.saveGeolocationCookie();
            if (reloadPage) {
              window.location.reload();
            }
          }, function () {
            this.geotype = 'err';
            this.saveGeolocationCookie();
            if (reloadPage) {
              window.location.reload();
            }
          },
          {
            timeout: 5000
          });
    }
    else {
      this.geotype = 'default';
      this.saveGeolocationCookie();
      if (reloadPage) {
        window.location.reload();
      }
    }
  },

  getDefaultLocation: function() {
    if (this.geotype == 'undefined' || this.geotype == 'ip') {
      this.getCurrentLocation();
    }
  },

  prepareCurrentLocationClickEvent: function () {
    $('#locationMenu a:first').click(function (e) {
      e.preventDefault();
      e.stopPropagation();
      philGeolocation.getCurrentLocation();
    });
  },

  prepareCityClickEvent: function () {
    $('#locationMenu a:not(:first)').click(function (e) {
      e.preventDefault();
      e.stopPropagation();

      var location = $(this);

      philGeolocation.longitude = location.data('long');
      philGeolocation.latitude = location.data('lat');
      philGeolocation.geotype = 'city';
      philGeolocation.cityName = location.text();
      philGeolocation.saveGeolocationCookie();

      var loc = window.location;
      $("body").each(function () {
        loc = $(this).data("home");
      });
      window.location = loc;
    });
  },

  prepareLocationMenu: function(currentPositionText, citiesList) {
    var city,
        menu = $('#locationMenu'),
        menuToPush = [];

    menu.append('<a href="#" class="locationMenuCities">' + currentPositionText + '</a>');

    for (cities in citiesList) {

      if (cities.title != null && cities.title != '') {
        menuToPush.push('<div id="' + cities.id + '" class="locationMenuSeparator">' + cities.title + '</div>');
      }

      for (city in cities.datas) {
        menuToPush.push('<a href="#" data-lat="' + city.lat + '" data-long="' + city.lon + '" class="cities">' + city.name + '</a>');
      }

    }

    menu.append(menuToPush.join(''));

    this.prepareCurrentLocationClickEvent();
    this.prepareCityClickEvent();

    isPhilLocationMenu = true;
  }


};

philGeolocation.init();
