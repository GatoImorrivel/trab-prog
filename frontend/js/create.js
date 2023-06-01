import { get, post } from "./api.js";

const createPersonBtnRef = document.getElementById('create-person-btn');
const createRoleBtnRef = document.getElementById('create-role-btn');

createPersonBtnRef.addEventListener('click', createPerson);
createRoleBtnRef.addEventListener('click', createRole);

// Person Form
const emailRef = document.getElementById('email');
const nameRef = document.getElementById('name');
const passwordRef = document.getElementById('password');
const birthRef = document.getElementById('birth');

birthRef.addEventListener('change', formatDate);

// Role Form
const roleNameRef = document.getElementById('role-name');

function createPerson(e) {
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

function createRole(e) {
    e.preventDefault();

    const data = {
        role: roleNameRef.value,
    };

    post('/api.php', 'role', 'save', data);
    return false;
}

function formatDate() {
    var inputDate = document.getElementById("birth").value;
    var parts = inputDate.split("-");
    var formattedDate = parts[2] + "-" + parts[1] + "-" + parts[0];
    document.getElementById("birth").value = formattedDate;
}