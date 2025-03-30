import './bootstrap';
// import Alpine from 'alpinejs'
import './ultils'

// Alpine.start()

// If you want Alpine's instance to be available everywhere.
// window.Alpine = Alpine

Noty.overrideDefaults({
    theme: 'limitless',
    layout: 'topRight',
    type: 'alert',
    timeout: 2500
});

window.addEventListener('alert', event => {
    new Noty({
        title: event.detail.title ?? '',
        text: event.detail.message,
        type: event.detail.type ?? 'alert',
    }).show();
});


import './fullcalendar.js'
// import './datepicker.js'

$('#filter-select-year').change(function () {
  $('#frm-filter-seminar').submit()
})

import "./docx-viewer";
