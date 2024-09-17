/*!
 * This code is taken from the Bootstrap documentation for color mode toggling.
 * Bootstrap's docs (https://getbootstrap.com/)
 *
 * Modifications:
 * - Customized for integration with a custom menu structure.
 * - Added logic to indicate the currently selected theme in the dropdown menu.
 * - Adapted for use in a project by winfried (https://github.com/herrwinfried), 2024.
 */

(() => {
    const getStoredTheme = () => localStorage.getItem('theme')
    const setStoredTheme = theme => localStorage.setItem('theme', theme)

    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme()
        if (storedTheme) {
            return storedTheme
        }

        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
    }

    const setTheme = theme => {
        if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-bs-theme', 'dark')
        } else {
            document.documentElement.setAttribute('data-bs-theme', theme)
        }
    }

    setTheme(getPreferredTheme())

    const showActiveTheme = (theme, focus = false) => {
        const themeSwitcher = document.querySelector('#bd-theme')

        if (!themeSwitcher) {
            return
        }

        document.querySelectorAll('[data-bs-theme-value]').forEach(toggle => {
            toggle.classList.remove('active')
            const icon = toggle.querySelector('i')
            if (icon) {
                icon.style.fontWeight = 'normal';
            }

            if (toggle.getAttribute('data-bs-theme-value') === theme) {
                toggle.classList.add('active')
                if (icon) {
                    icon.style.fontWeight = 'bold';
                }
            }
        })

        if (focus) {
            themeSwitcher.focus()
        }
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        const storedTheme = getStoredTheme()
        if (storedTheme !== 'light' && storedTheme !== 'dark') {
            setTheme(getPreferredTheme())
        }
    })

    window.addEventListener('DOMContentLoaded', () => {
        showActiveTheme(getPreferredTheme())

        document.querySelectorAll('[data-bs-theme-value]')
            .forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const theme = toggle.getAttribute('data-bs-theme-value')
                    setStoredTheme(theme)
                    setTheme(theme)
                    showActiveTheme(theme, true)
                })
            })
    })
})()
