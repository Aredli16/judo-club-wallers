const hamburgerToggler = document.querySelector('.hamburger')
const navLinks = document.querySelector('.nav-links')

const toggleNav = () => {
    hamburgerToggler.children[0].classList.toggle('max-md:translate-y-[7px]')
    hamburgerToggler.children[0].classList.toggle('max-md:rotate-[135deg]')

    hamburgerToggler.children[1].classList.toggle('max-md:translate-y-[7px]')
    hamburgerToggler.children[1].classList.toggle('max-md:opacity-0')

    hamburgerToggler.children[2].classList.toggle('max-md:-translate-y-[7px]')
    hamburgerToggler.children[2].classList.toggle('max-md:-rotate-[135deg]')

    navLinks.classList.toggle('max-md:-translate-x-full')

    const ariaToggle = hamburgerToggler.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
    hamburgerToggler.setAttribute('aria-expanded', ariaToggle)
}

hamburgerToggler.addEventListener('click', toggleNav)