import './bootstrap'

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import PerfectScrollbar from 'perfect-scrollbar'
import 'vanillajs-datepicker/css/datepicker.css';

import { Datepicker } from 'vanillajs-datepicker';

window.PerfectScrollbar = PerfectScrollbar
import jQuery from 'jquery';
import select2 from "select2"
select2();
window.$ = jQuery;

document.addEventListener('DOMContentLoaded', () => {
    const fromYearInput = document.querySelector('input[name="fromYear"]');
    const untilYearInput = document.querySelector('input[name="untilYear"]');
    const publicationDate = document.querySelector('input[name="publication_date"]');

    if (fromYearInput) {
        new Datepicker(fromYearInput, {
            pickLevel: 2,
            format: 'yyyy',
            autohide: true
        });
    }

    if (untilYearInput) {
        new Datepicker(untilYearInput, {
            pickLevel: 2,
            format: 'yyyy',
            autohide: true
        });
    }

    if (publicationDate) {
        new Datepicker(publicationDate, {
            pickLevel: 2,
            format: 'yyyy',
            autohide: true
        });
    }
});
document.addEventListener('alpine:init', () => {
    Alpine.data('mainState', () => {
        let lastScrollTop = 0
        const init = function () {
            window.addEventListener('scroll', () => {
                let st =
                    window.pageYOffset || document.documentElement.scrollTop
                if (st > lastScrollTop) {
                    // downscroll
                    this.scrollingDown = true
                    this.scrollingUp = false
                } else {
                    // upscroll
                    this.scrollingDown = false
                    this.scrollingUp = true
                    if (st == 0) {
                        //  reset
                        this.scrollingDown = false
                        this.scrollingUp = false
                    }
                }
                lastScrollTop = st <= 0 ? 0 : st // For Mobile or negative scrolling
            })
        }

        const getTheme = () => {
            if (window.localStorage.getItem('dark')) {
                return JSON.parse(window.localStorage.getItem('dark'))
            }
            return (
                !!window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            )
        }
        const setTheme = (value) => {
            window.localStorage.setItem('dark', value)
        }
        return {
            init,
            isDarkMode: getTheme(),
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode
                setTheme(this.isDarkMode)
            },
            isSidebarOpen: window.innerWidth > 1024,
            isSidebarHovered: false,
            handleSidebarHover(value) {
                if (window.innerWidth < 1024) {
                    return
                }
                this.isSidebarHovered = value
            },
            handleWindowResize() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false
                } else {
                    this.isSidebarOpen = true
                }
            },
            scrollingDown: false,
            scrollingUp: false,
        }
    })
})

Alpine.plugin(collapse)

Alpine.start()
