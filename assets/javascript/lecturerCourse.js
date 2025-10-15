const courseContainer = document.getElementById("courseContainer");

// GET DEPARTMENTS BASED ON FACULTY
async function getDepartments() {
  const facultySelect = document.querySelector(".faculty-select");

  facultySelect.addEventListener("change", async function () {
    const departmentSelect = document.querySelector(".department-select");
    const facultyId = facultySelect.value;

    const departmentList = await fetch(
      "../controllers/getDepartments.php?facultyId=" + facultyId
    ).then((result) => result.json());
    departmentSelect.innerHTML =
      "<option selected>Choose Your Department</option>";
    departmentList.forEach((dept) => {
      departmentSelect.innerHTML += `<option value="${dept.id}">${dept.name}</option>`;
    });
  });
}
getDepartments();



document.addEventListener("DOMContentLoaded", async () => {
    const lecturerId = document.getElementById("lecturerId").textContent;

    const courseList = await fetch(
      "../controllers/getCourses.php?lecturerId=" + lecturerId
    ).then((result) => result.json());

  function displayCourses(courseList) {
    courseContainer.innerHTML = "";

    courseList.forEach((item) => {
      courseContainer.innerHTML += `
            <div class=" col-md-6 rounded-4 containers lecturer-courses p-3">
                        <div class=" card-body d-flex justify-content-between align-items-center">
                            <!-- Course Info -->
                            <div class="course-info">
                                <h5 class="mb-1 fw-bold text-primary">${item.courseCode}</h5>
                                <p class="mb-0 text-muted">${item.courseTitle}</p>
                                <small class="text-secondary">Semester: ${item.semester} | Units: ${item.units}</small>
                            </div>
                            <!-- Actions -->
                            <div class="course-actions d-flex gap-2 flex-wrap justify-content-end justify-content-md-center">
                                <a href="viewCourse.php?courseId=${item.id}"><button class="btn btn-outline-primary btn-sm">View</button></a>
                                <a href="createLecture.php?courseId=${item.id}"><button class="btn btn-outline-success btn-sm">Attendance</button></a>
                                <button class="btn btn-outline-dark btn-sm">Edit</button>
                            </div>
                        </div>
                    </div>
        `;
    });
  }
  displayCourses(courseList)

  function searchCourse() {
    // get userinput to lowercase
    const userInput = document.getElementById("courseSearch").value.toLowerCase();

    const result = courseList.filter((item) => {
      const resultOutput = `${item.courseCode}, ${item.courseTitle}`;
      const converted = resultOutput.toLowerCase();
      return converted.includes(userInput);
    });

    if (userInput == 0 || result.length == 0) {
      displayCourses(courseList);
    } else {
      displayCourses(result);
    }
  }
  document.getElementById("searchBtn").addEventListener("click", () => {
    searchCourse();
  });

  // function filter by session
  function searchBySession(entry){
      const sessionId = entry.target.value;
      const result = courseList.filter((session) => {
        const out = `${session.sessionId}`;
        return out.includes(sessionId);
      })
    if (result.length == 0) {
      displayCourses(courseList);
    } else{
      displayCourses(result);
    }
  }
  
  document.getElementById("courseFilter").addEventListener("change", (event) => {
    searchBySession(event);
  });






});
