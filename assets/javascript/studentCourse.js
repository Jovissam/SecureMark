const courseContainer = document.getElementById("courseContainer");
const departmentSelect = document.querySelector(".department-select");
const facultySelect = document.querySelector(".faculty-select");
const userId = document.getElementById("studentId").textContent;

document.addEventListener("DOMContentLoaded", async () => {
  const departmentId = document.getElementById("departmentId").textContent;

  const courseList = await fetch(
    "../controllers/getCourses.php", {
      headers: {
        "Content-Type": "application/json",
        "type": "department",
        "departmentId": departmentId
      }
    }
  ).then((result) => result.json());

  function displayCourses(courseList) {
    courseContainer.innerHTML = "";

    if (courseList.length === 0) {
      courseContainer.innerHTML = `<p class="text-center text-secondary">No courses available</p>`;
      return;
    } else {
      courseList.forEach((item) => {
        courseContainer.innerHTML += `
            <div class="col-md-6 rounded-4 containers lecturer-courses p-2 px-3">
                        <div class=" card-body d-flex justify-content-between align-items-center">
                            <!-- Course Info -->
                            <div class="course-info">
                                <h5 class="mb-1 fw-bold text-primary">${item.courseCode}</h5>
                                <p class="mb-0 text-muted">${item.courseTitle}</p>
                                <p class="mb-0 text-muted">${item.firstName} ${item.lastName}</p>
                            </div>
                            <!-- Actions -->
                          <form id="registerCourseBtn">
                            <div class="course-actions d-flex gap-2 flex-wrap justify-content-end justify-content-md-center">
                              <input type="hidden" name="studentId" value="${item.id}"/>
                              <button type='submit' class="btn btn-outline-primary btn-sm">Register</button>
                            </div>
                          </form>
                            
                        </div>
                    </div>
        `;
      });
    }
  }
  displayCourses(courseList);

  function searchCourse() {
    // get userinput to lowercase
    const userInput = document
      .getElementById("courseSearch")
      .value.toLowerCase();

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

  // GET DEPARTMENTS BASED ON FACULTY
  async function getDepartments() {
    facultySelect.addEventListener("change", async function () {
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

  // filter by another department
  departmentSelect.addEventListener("change", async function () {
    const departmentId = departmentSelect.value;

    const courseListt = await fetch(
      "../controllers/getCourses.php",{
          headers: {
            "Content-Type": "application/json",
            "type": "department",
            "departmentId": departmentId
          }
        }
    ).then((result) => result.json());
    displayCourses(courseListt);
  });
});

// course registration

function registerCourse(form) {
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    console.log("heyy");

    const studentId = userId;
    const courseId = form[0].value;

    const registerForm = new FormData();
    registerForm.append("studentId", studentId);
    registerForm.append("courseId", courseId);

    const request = await fetch("../controllers/getCourses.php", {
      method: "POST",
      body: registerForm,
      headers: {
        "type": "registerStudent"
      }
    }).then((result) => result.json());

    if (request.response == "success") {
      alert("Course registered successfully");
      // window.location.reload();
    } else {
      alert(request.response);
    }
  });
}
document.addEventListener("submit", function (e) {
  if (e.target && e.target.id == "registerCourseBtn"){
    e.preventDefault();
    registerCourse(e.target);
  }
  });
// courseContainer.innerHTML += `
//             <div class=" col-md-6 rounded-4 containers lecturer-courses p-3">
//                         <div class=" card-body d-flex justify-content-between align-items-center">
//                             <!-- Course Info -->
//                             <div class="course-info">
//                                 <h5 class="mb-1 fw-bold text-primary">${item.courseCode}</h5>
//                                 <p class="mb-0 text-muted">${item.courseTitle}</p>
//                                 <small class="text-secondary">Semester: ${item.semester} | Units: ${item.units}</small>
//                             </div>
//                             <!-- Actions -->
//                             <div class="course-actions d-flex gap-2 flex-wrap justify-content-end justify-content-md-center">
//                                 <a href="viewCourse.php?courseId=${item.id}"><button class="btn btn-outline-primary btn-sm">View</button></a>
//                                 <a href="createLecture.php?courseId=${item.id}"><button class="btn btn-outline-success btn-sm">Attendance</button></a>
//                                 <button class="btn btn-outline-dark btn-sm">Edit</button>
//                             </div>
//                         </div>
//                     </div>
//         `;
