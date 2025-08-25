// Auto-detect lecturer's location
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function (position) {
    document.getElementById("lat").value = position.coords.latitude;
    document.getElementById("lng").value = position.coords.longitude;
    document.getElementById(
      "location"
    ).value = `Lat: ${position.coords.latitude}, Lng: ${position.coords.longitude}`;
  });
} else {
  document.getElementById("location").value = "Geolocation not supported";
}
