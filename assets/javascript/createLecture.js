// Auto-detect lecturer's location
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(
    function (position) {
      document.getElementById("lat").value = position.coords.latitude;
      document.getElementById("lng").value = position.coords.longitude;
      document.getElementById(
        "location"
      ).value = `Lat: ${position.coords.latitude}, Lng: ${position.coords.longitude}`;
    },
    function (error) {
      document.getElementById("location").value = `Error: ${error.message}`;
      console.error("Error:", error.message);
    },
    {
      enableHighAccuracy: true, // forces GPS
      timeout: 10000, // wait up to 10s
      maximumAge: 0, // don’t use cached position
    }
  );
} else {
  document.getElementById("location").value = "Geolocation not supported";
}

const createLectureForm = document.getElementById("createLectureForm");
createLectureForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const lecturerId = e.target[0].value;
  const latitude = e.target[1].value;
  const longitude = e.target[2].value;
  const courseId = e.target[3].value;
  const topic = e.target[4].value;
  const date = e.target[5].value;
  const startTime = e.target[6].value;
  const endTime = e.target[7].value;
  const venue = e.target[8].value;
  const hallType = e.target[9].value;
  const qrCodeDuration = e.target[10].value;

  const lectureForm = new FormData();
  lectureForm.append("lecturerId", lecturerId);
  lectureForm.append("latitude", latitude);
  lectureForm.append("longitude", longitude);
  lectureForm.append("courseId", courseId);
  lectureForm.append("topic", topic);
  lectureForm.append("date", date);
  lectureForm.append("startTime", startTime);
  lectureForm.append("endTime", endTime);
  lectureForm.append("venue", venue);
  lectureForm.append("hallType", hallType);
  lectureForm.append("qrCodeDuration", qrCodeDuration);

  const request = await fetch("../controllers/lecture.php", {
    method: "POST",
    body: lectureForm,
    headers: {
      action: "createLecture",
    },
  }).then((result) => result.json())
  alert(request.response);
});
