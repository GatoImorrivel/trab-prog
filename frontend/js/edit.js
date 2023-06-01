import { get } from './api.js';

const urlParams = new URLSearchParams(window.location.search);
const queryIdPerson = urlParams.get('id');

if (queryIdPerson === null) {
    window.location.href = 'http://localhost:3000/list.html';
}

// Person Form
const emailRef = document.getElementById('email');
const nameRef = document.getElementById('name');
const passwordRef = document.getElementById('password');
const birthRef = document.getElementById('birth');
const roleSelectRef = document.getElementById('role-select-container');

loadRoles();
lazyLoadPerson();

async function lazyLoadPerson() {
    const data = await get('/api.php', 'person', 'get', {id: queryIdPerson});
    const person = data[0];

    emailRef.value = person.email;
    nameRef.value = person.name;
    passwordRef.value = person.password;
    birthRef.value = person.birth;

    console.log(person);
}

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
