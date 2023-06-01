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
const roleSelectRef = document.getElementById('role-select-container');
birthRef.addEventListener('change', formatDate);

loadRoles();

async function loadRoles() {
    const roles = await get('/api.php', 'role', 'getAll');
    roleSelectRef.innerHTML = '';

    for (const role of roles) {
        const div = document.createElement('div');
        const checkbox = document.createElement('input');
        const label = document.createElement('span');

        checkbox.setAttribute('type', 'checkbox');
        checkbox.setAttribute('class', 'form-check-input');

        div.setAttribute('class', 'form-check');
        div.setAttribute('data-id', role.idRole);

        label.setAttribute('class', 'form-check-label');

        label.textContent = role.role;

        div.appendChild(checkbox);
        div.appendChild(label);

        roleSelectRef.appendChild(div)
    }
}

// Role Form
const roleNameRef = document.getElementById('role-name');

function createPerson(e) {
    e.preventDefault();

    let roleIds = [];
    for (const checkbox of document.getElementsByClassName('form-check-input')) {
        if (checkbox.checked) {
            roleIds.push(checkbox.parentElement.getAttribute('data-id'));
        }
    }

    console.log(roleIds);

    const data = {
        name: nameRef.value,
        email: emailRef.value,
        password: passwordRef.value,
        birth: birthRef.value,
        roles: roleIds
    };

    post('/api.php', 'person', 'save', data);
    return false;
}

async function createRole(e) {
    e.preventDefault();

    const data = {
        role: roleNameRef.value,
    };

    await post('/api.php', 'role', 'save', data);
    loadRoles();
    return false;
}

function formatDate() {
    var inputDate = document.getElementById("birth").value;
    var parts = inputDate.split("-");
    var formattedDate = parts[2] + "-" + parts[1] + "-" + parts[0];
    document.getElementById("birth").value = formattedDate;
}