"use strict"

// variables
let coursesEl = document.getElementById("courses");
let addcoursebutton = document.getElementById("addcourse");
let coursecodeInput = document.getElementById("coursecode");
let coursenameInput = document.getElementById("coursename");
let progressionInput = document.getElementById("progression");
let coursesyllabusInput = document.getElementById("coursesyllabus");

window.addEventListener('load', getCourses);
addcoursebutton.addEventListener("click", addCourse);

function getCourses() {
    coursesEl.innerHTML = '';

    fetch('http://studenter.miun.se/~olfa1902/Webbutveckling_III/Moment_5/courses.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(course => {
            coursesEl.innerHTML +=
            `<div class="course">
            <p>
            <b>Kurskod:</b> ${course.coursecode}
            <br>
            <b>Kursnamn</b> ${course.name}
            <br>
            <b>Progression</b> ${course.progression}
            <br>
            <b>Ramschema</b> ${course.coursesyllabus}
            </p>
            <button id="${course.id}" onClick="deleteCourse(${course.id})">Radera</button>
            </div>`
        });
    })
}

function deleteCourse(id) {
    fetch('http://studenter.miun.se/~olfa1902/Webbutveckling_III/Moment_5/courses.php?id=' + id, {
        method: 'DELETE',
    })
    .then(response => response.json())
    .then(data => {
        getCourses();
    })
    .catch(error => {
        console.log('Error: ', error);
    })
}

function addCourse() {
    let coursecode = coursecodeInput.value;
    let coursename = coursenameInput.value;
    let progression = progressionInput.value;
    let coursesyllabus = coursesyllabusInput.value;

    let course = {'coursecode': coursecode, 'coursename': coursename, 'progression': progression, 'coursesyllabus': coursesyllabus};

    fetch('http://studenter.miun.se/~olfa1902/Webbutveckling_III/Moment_5/courses.php?id=', {
        method: 'POST',
        body: JSON.stringify(course),
    })
    .then(response => response.json())
    .then(data => {
        getCourses();
    })
    .catch(error => {
        console.log('Error: ', error);
    })
}