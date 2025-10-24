document.addEventListener("DOMContentLoaded", () => {

    // Auto-detect student's location
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

    // start scan
    const scanBtn = document.getElementById("scan-btn");
    scanBtn.addEventListener("click", () => {
        document.getElementById("scan-container").classList.remove("d-none")
        startScanner()
    })


    const html5QrCode = new Html5Qrcode("preview");
    const status = document.getElementById("statusMessage");

    function startScanner() {
        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                html5QrCode.start({
                    facingMode: "environment"
                }, // use back camera
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    qrCodeMessage => handleScan(qrCodeMessage),
                    errorMessage => console.log(errorMessage)
                );
            } else {
                status.innerHTML = `<div class="alert alert-warning">No camera detected.</div>`;
            }
        }).catch(err => {
            status.innerHTML = `<div class="alert alert-danger">Camera access denied: ${err}</div>`;
        });
    }
    //  HANDLE SCAN DATA
    function handleScan(qrData) {
        html5QrCode.stop()
        // .then(() => {
        //     status.innerHTML = `<div class="alert alert-info">Processing QR code...</div>`;

        //     fetch('../controllers/attendance.php', {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json'
        //         },
        //         body: JSON.stringify({
        //             token: qrData
        //         })
        //     })
        //         .then(res => res.json())
        //         .then(data => {
        //             if (data.success) {
        //                 status.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        //             } else {
        //                 status.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        //             }
        //         })
        //         .catch(err => {
        //             status.innerHTML = `<div class="alert alert-danger">Error: ${err}</div>`;
        //         });
        // });
        document.getElementById("scan-data").value = qrData;
    }

    // SUBMIT FORM DATA
    const attendanceForm = document.getElementById("attendance-form");

    attendanceForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const lectureId = e.target[0].value;
        const studentId = e.target[1].value;
        const lat = e.target[2].value;
        const lng = e.target[3].value;
        const qrCode = e.target[5].value;
        if (!lectureId || !studentId || !lat || !lng || !qrCode) {
            status.innerHTML = `<div class="alert alert-warning">Error getting your details: make sure you scan and allow location access</div>`
        } else {
            const submitForm = new FormData();

            submitForm.append("lectureId", lectureId)
            submitForm.append("studentId", studentId)
            submitForm.append("lat", lat)
            submitForm.append("lng", lng)
            submitForm.append("qrCode", qrCode)

            const request = await fetch ("../controllers/lecture.php", {
                method: "POST",
                body: submitForm,
                headers:{
                    "action": "smartMark"
                }
            }).then((result)=>result.json())
        }

    })
})