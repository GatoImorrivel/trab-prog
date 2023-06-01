import { get, post } from "./api.js";

const btnRef = document.getElementById('submit-btn');

// Form
const emailRef = document.getElementById('email');
const nameRef = document.getElementById('name');
const passwordRef = document.getElementById('password');
const birthRef = document.getElementById('birth');

btnRef.addEventListener('click', create);
birthRef.addEventListener('change', formatDate);

function create(e) {
    e.preventDefault();

    const data = {
        name: nameRef.value,
        email: emailRef.value,
        password: passwordRef.value,
        birth: birthRef.value
    };

    post('/api.php', 'person', 'save', data);
    return false;
}

function formatDate() {
    var inputDate = document.getElementById("birth").value;
    var parts = inputDate.split("-");
    var formattedDate = parts[2] + "-" + parts[1] + "-" + parts[0];
    document.getElementById("birth").value = formattedDate;
}