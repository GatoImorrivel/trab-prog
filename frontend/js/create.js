const btnRef = document.getElementById('submit-btn');

// Form
const emailRef = document.getElementById('email');
const nameRef = document.getElementById('name');
const passwordRef = document.getElementById('password');
const birthRef = document.getElementById('birth');

btnRef.addEventListener('click', create);

function create(e) {
    e.preventDefault();

    fetch('http://localhost:8080/api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: nameRef.value,
            email: emailRef.value,
            password: passwordRef.value,
            birth: birthRef.value,
        })
    }).then(data => {
        console.log(data);
    }).catch(e => {
        console.log(e);
    });
}