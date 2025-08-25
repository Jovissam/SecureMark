const loginContainer = document.querySelector(".login-form");
const signupContainer = document.querySelector(".signup-form");
const loginBtn = document.querySelector(".login-btn");
const registerBtn = document.querySelector(".register-btn");

loginBtn.addEventListener("click", function () {
  switchView(loginContainer, signupContainer);
});

registerBtn.addEventListener("click", function () {
  switchView(signupContainer, loginContainer);
});

function switchView(view1, view2) {
  loader();
  view1.classList.remove("d-none");
  view2.classList.add("d-none");
}
function loader() {
  const loaderContainer = document.querySelector(".loader-container");
  loaderContainer.classList.remove("d-none");
  setTimeout(() => {
    loaderContainer.classList.add("d-none");
  }, 1000);
}

// GET DEPARTMENTS BASED ON FACULTY
async function getDepartments() {
  const facultySelect = document.querySelector(".faculty-select");

  facultySelect.addEventListener("change", async function () {
    const departmentSelect = document.querySelector(".department-select");
    const facultyId = facultySelect.value;

    const departmentList = await fetch(
      "controllers/getDepartments.php?facultyId=" + facultyId
    ).then((result) => result.json());
    departmentSelect.innerHTML =
      "<option selected>Choose Your Department</option>";
    departmentList.forEach((dept) => {
      departmentSelect.innerHTML += `<option value="${dept.id}">${dept.name}</option>`;
    });
  });
}
getDepartments();

// Arrange mat no
document.getElementById("mat-no").addEventListener("input", (e) => {
  let matNo = e.target.value;
  if (matNo.length > 3) {
    e.target.value = matNo.substring(0, 3).toUpperCase() + matNo.substring(3);
  } else {
    e.target.value = matNo.toUpperCase(3);
  }
});

// SIGN UP
const signupForm = document.getElementById("signupForm");
const signupStatus = document.getElementById("signupStatus");
signupForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  signupStatus.textContent = "";
  const firstName = e.target[0].value;
  const lastname = e.target[1].value;
  const matNo = e.target[2].value;
  const level = parseFloat(e.target[3].value);
  const faculty = parseFloat(e.target[4].value);
  const department = parseFloat(e.target[4].value);

  const form = new FormData();
  form.append("firstName", firstName);
  form.append("lastName", lastname);
  form.append("matNo", matNo);
  form.append("level", level);
  form.append("faculty", faculty);
  form.append("department", department);
  console.log(faculty);
  

  const result = await fetch("controllers/signup.php", {
    method: "POST",
    body: form,
  }).then((result) => result.json());
  signupStatus.textContent = result.response;
  if (result.response === "success") {
    signupStatus.textContent = "Registration successful, you will be redirected shortly";

    setTimeout(() => {
      location.reload()
    }, 2000);
  }
});


// SUBMIT LOGIN INFORMATION
const loginForm = document.getElementById("loginForm");

loginForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  console.log(e);
  const userId = e.target[0].value;
  const password = e.target[1].value;
  const deviceId = screen.width + "x" + screen.height;

  const form = new FormData();
  form.append("userId", userId);
  form.append("password", password);
  form.append("deviceId", deviceId);

  const result = await fetch("controllers/login.php", {
    method: "POST",
    body: form,
  }).then((result) => result.json());

  const loginStatus = document.getElementById("loginStatus");
  loginStatus.textContent = result.response;
  if (result.role == "student") {
    setTimeout(() => {
      window.location.href = "student/dashboard.php";
    }, 1000)
  }
  if (result.role == "lecturer") {
    setTimeout(() => {
      window.location.href = "lecturer/dashboard.php";
    }, 1000)
  }
});
