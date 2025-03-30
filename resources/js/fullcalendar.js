function padNumber(number) {
    return number < 10 ? '0' + number : number;
}

function formatDate(date) {
    const day = padNumber(date.getDate());
    const month = padNumber(date.getMonth() + 1);
    const year = date.getFullYear();
    return day + '-' + month + '-' + year;
}


const FullCalendarBasic = function () {

    const _componentFullCalendarBasic = async function () {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }

        const getEvents = async (params) => {
            const response = await axios({
                method: 'get',
                url: `${window.location.origin}/api/events`,
                params
            });

            return response.data.data;
        };

        const loadEvents = async (calendar) => {
            let startDayWeek = calendar.view.activeStart;
            let endDayWeek = calendar.view.activeEnd;

            const firstDay = new Date(startDayWeek);
            const lastDay = new Date(endDayWeek);

            const events = await getEvents({
                start: formatDate(firstDay),
                end: formatDate(lastDay)
            });
            calendar.removeAllEvents();
            calendar.addEventSource(events);
        };

        const calendarOptions = {
            locale: 'vi',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'today'
            },
            initialView: 'timeGridWeek',
            navLinks: true,
            nowIndicator: true,
            weekNumberCalculation: 'ISO',
            editable: false,
            height: 'auto',
            slotMinTime: "07:00",
            slotMaxTime: "20:00",
            selectable: false,
            dayMaxEvents: true,
            eventContent: function (arg) {
                let arrayOfDomNodes = [];

                let timeEvent = document.createElement('div');
                if (arg.timeText) {
                    timeEvent.innerHTML = arg.timeText;
                    timeEvent.classList = "fc-event-time fc-sticky";
                }

                let titleEvent = document.createElement('div');
                if (arg.event._def.title) {
                    titleEvent.innerHTML = arg.event._def.title;
                    titleEvent.classList = "fc-event-title fc-sticky";
                }

                let imgEventWrap = document.createElement('div');
                if (arg.event.extendedProps?.team?.thumbnail) {
                    let imgEvent = `<span class="fc-event-team fc-sticky">${arg.event.extendedProps?.team?.name} </span>`;
                    imgEventWrap.classList = "fc-event-img";
                    imgEventWrap.innerHTML = imgEvent;
                }

                arrayOfDomNodes = [timeEvent, titleEvent, imgEventWrap];

                return { domNodes: arrayOfDomNodes };
            },
        };

        const calendarBasicViewElement = document.querySelector('.fullcalendar-basic');

        if (calendarBasicViewElement) {
            const calendar = new FullCalendar.Calendar(calendarBasicViewElement, calendarOptions);
            calendar.render();

            document.querySelectorAll('.sidebar-control').forEach(function (sidebarToggle) {
                sidebarToggle.addEventListener('click', function () {
                    calendar.updateSize();
                });
            });
            await loadEvents(calendar);
            calendar.on('datesSet', function (info) {
                loadEvents(calendar);
            });
        }
    };

    return {
        init: function () {
            _componentFullCalendarBasic();
        }
    }
}();

document.addEventListener('DOMContentLoaded', function () {
    FullCalendarBasic.init();
});
