const password =  document.getElementById('password')
const reapetPassword =  document.getElementById('repeat_password')
const showPasswordBtns = document.querySelectorAll('.password-show')


//######################### SHOWING AND HIDDING PASSWORD ############################################
showPasswordBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        const clickedBtnId = e.target.id
        toggleShowPassword(clickedBtnId)
    })
})



function toggleShowPassword(clickedBtnId) {
    let passwordInput
    if (clickedBtnId === 'show-password') {
        passwordInput = document.getElementById('password')
    }
    if (clickedBtnId === 'show-repeat-password') {
        passwordInput = document.getElementById('repeat-password')
    }

    if (passwordInput.getAttribute('type') === 'password') {
        passwordInput.setAttribute('type', 'text')
    }
    else {
        passwordInput.setAttribute('type', 'password')
    }
}