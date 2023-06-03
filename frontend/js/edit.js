import { get, post } from './api.js';

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
const saveBtnRef = document.getElementById('save-person-btn');

birthRef.oninput = (e) => {
    e.target.value = formatDate(e.target.value);
}

saveBtnRef.addEventListener('click', doUpdate);

loadRoles().then(() => {
    lazyLoadPerson(queryIdPerson);
})

async function lazyLoadPerson(id) {
    const person = await get('/api.php', 'person', 'get', {id: id});

    emailRef.value = person.email;
    nameRef.value = person.name;
    passwordRef.value = person.password;
    birthRef.value = person.birth;

    const checkboxes = document.getElementsByClassName('form-check-input');

    for (const checkbox of checkboxes) {
        for (const idRole of person.roles) {
            if (checkbox.parentElement.getAttribute('data-id') == idRole) {
               checkbox.checked = true; 
            } 
        }
    }

    console.log(person);
}

function doUpdate(e) {
    e.preventDefault();

    let roleIds = [];
    for (const checkbox of document.getElementsByClassName('form-check-input')) {
        if (checkbox.checked) {
            roleIds.push(checkbox.parentElement.getAttribute('data-id'));
        }
    }

    const data = {
        id: queryIdPerson,
        name: nameRef.value,
        email: emailRef.value,
        password: passwordRef.value,
        birth: birthRef.value,
        roles: roleIds
    };

    post('/api.php', 'person', 'update', data);
    return false;
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

function formatDate(input) {
    const inputValue = input.replace(/\D/g, '');

    const day = inputValue.slice(0, 2);
    const month = inputValue.slice(2, 4);
    const year = inputValue.slice(4, 8);

    let formattedDate = "";
    if (day != null) {
        formattedDate += day + "/";
    }
    if (month != null) {
        formattedDate += month + "/";
    }
    if (year != null) {
        formattedDate += year;
    }

    return formattedDate;
}