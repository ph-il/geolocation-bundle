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
      this.setGeolocationInfo(info.latitude, info.longitude, info.geotype, info.cityname);
    }
  },

  setGeolocationInfo: function (latitude, longitude, geotype, cityname) {
    this.latitude = latitude;
    this.longitude = longitude;
    this.geotype = geotype;
    this.cityname = cityname;
  },

  saveGeolocationCookie: function () {
    $.cookie('phil-geolocation', '{"latitude": ' + this.latitude + ',"longitude":' + this.longitude + ',"geotype":"' + this.geotype + '","cityname":"' + this.cityname + '"}', { path: '/' });
  },

  getCurrentLocation: function (reloadPage) {
    reloadPage = typeof reloadPage !== 'undefined' ? reloadPage : true;

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
            philGeolocation.setGeolocationInfo(position.coords.latitude, position.coords.longitude, 'user', '');
            philGeolocation.saveGeolocationCookie();
            if (reloadPage) {
              window.location.reload();
            }
          }, function () {
            philGeolocation.geotype = 'err';
            philGeolocation.saveGeolocationCookie();
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

      philGeolocation.setGeolocationInfo(location.data('lat'), location.data('long'), 'city', location.text());
      philGeolocation.saveGeolocationCookie();

      var loc = window.location;
      $("body").each(function () {
        if ($(this).data("home") != undefined)
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
