import 'vanillajs-datepicker/css/datepicker.css';

// Import other libraries
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import PerfectScrollbar from 'perfect-scrollbar';
import { Datepicker } from 'vanillajs-datepicker';

window.PerfectScrollbar = PerfectScrollbar;

import jQuery from 'jquery';
import select2 from 'select2';
select2();
window.$ = jQuery;

document.addEventListener('DOMContentLoaded', () => {
    const fromYearInput = document.querySelector('input[name="fromYear"]');
    const untilYearInput = document.querySelector('input[name="untilYear"]');
    const publicationDate = document.querySelector('input[name="publication_date"]');

    const publicationFromDateInput = document.querySelector('input[name="publication_date_from"]');
    const publicationUntilDateInput = document.querySelector('input[name="publication_date_to"]');

    if (fromYearInput) {
        new Datepicker(fromYearInput, {
            pickLevel: 1,
            format: 'yyyy-mm',
            autohide: true
        });
    }

    if (untilYearInput) {
        new Datepicker(untilYearInput, {
            pickLevel: 1,
            format: 'yyyy-mm',
            autohide: true
        });
    }

    if (publicationDate) {
        new Datepicker(publicationDate, {
            pickLevel: 1,
            format: 'yyyy-mm',
            autohide: true
        });
    }

    if (publicationFromDateInput) {
        new Datepicker(publicationFromDateInput, {
            pickLevel: 1,
            format: 'yyyy-mm',
            autohide: true
        });
    }

    if (publicationUntilDateInput) {
        new Datepicker(publicationUntilDateInput, {
            pickLevel: 1,
            format: 'yyyy-mm',
            autohide: true
        });
    }
});

document.addEventListener('alpine:init', () => {
    Alpine.data('mainState', () => {
        let lastScrollTop = 0;
        const init = function () {
            window.addEventListener('scroll', () => {
                let st = window.pageYOffset || document.documentElement.scrollTop;
                if (st > lastScrollTop) {
                    // downscroll
                    this.scrollingDown = true;
                    this.scrollingUp = false;
                } else {
                    // upscroll
                    this.scrollingDown = false;
                    this.scrollingUp = true;
                    if (st == 0) {
                        // reset
                        this.scrollingDown = false;
                        this.scrollingUp = false;
                    }
                }
                lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
            });
        };

        const getTheme = () => {
            if (window.localStorage.getItem('dark')) {
                return JSON.parse(window.localStorage.getItem('dark'));
            }
            return (
                !!window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            );
        };

        const setTheme = (value) => {
            window.localStorage.setItem('dark', value);
        };

        return {
            init,
            isDarkMode: getTheme(),
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode;
                setTheme(this.isDarkMode);
            },
            isSidebarOpen: window.innerWidth > 1024,
            isSidebarHovered: false,
            handleSidebarHover(value) {
                if (window.innerWidth < 1024) {
                    return;
                }
                this.isSidebarHovered = value;
            },
            handleWindowResize() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false;
                } else {
                    this.isSidebarOpen = true;
                }
            },
            scrollingDown: false,
            scrollingUp: false,
        };
    });
});

Alpine.plugin(collapse);
Alpine.start();
