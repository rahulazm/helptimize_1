'use strict';

/* eslint-disable require-jsdoc */
/* eslint-env jquery */
/* global moment, tui, chance */
/* global findCalendar, CalendarList, ScheduleList, generateSchedule */

(function(window, Calendar) {
    var cal, resizeThrottled;
    var useCreationPopup = false;
    var useDetailPopup = false;
    var datePicker, selectedCalendar;

    cal = new Calendar('#calendar', {
        defaultView: 'month',
        useCreationPopup: useCreationPopup,
        useDetailPopup: useDetailPopup,
        taskView: false,
        scheduleView: ['time'],
        calendars: CalendarList,
        template: {
            milestone: function(model) {
                return '<span class="calendar-font-icon ic-milestone-b"></span> <span style="background-color: ' + model.bgColor + '">' + model.title + '</span>';
            },
            allday: function(schedule) {
                return getTimeTemplate(schedule, true);
            },
            time: function(schedule) {
                return getTimeTemplate(schedule, false);
            },
            popupStateBusy: function() {
                return 'Test';
              },
              popupStateFree: function() {
                return 'Test1';
                // $('.tui-full-calendar-popup-container .tui-full-calendar-section-state').append('<select><option>--Select--</option></select>')
              }
              
              
        }
    });
// var x = cal._layout.container.childNodes[0].childNodes[1].childNodes[0].childNodes[0]
 // event handlers
    cal.on({
        'clickMore': function(e) {
            console.log('clickMore', e);
        },
        'clickSchedule': function(e) {
            console.log('clickSchedule', e);
        },
        'clickDayname': function(date) {
            console.log('clickDayname', date);
        },
        'beforeCreateSchedule': function(e) {
            $('#modal-new-schedule').modal('show');
            //$( "#modal-new-schedule" ).show();
            $( "#from_date" ).datepicker();
            $( "#to_date" ).datepicker();
            
            console.log('beforeCreateSchedule', e);
            $('#start-date').val(JSON.stringify(e.start._date));
            $('#end-date').val(JSON.stringify(e.end._date));
            var utcStartDate =  moment.utc(e.start._date).local();
            //var startMin = utcStartDate.format('HH:mm a');
            var startMin = $("#time_from_value").val();
            var utcEndDate =  moment.utc(e.end._date).local();
            //var endMin = utcEndDate.format('HH:mm a');
            var endMin = $("#time_to_value").val();

            var dbStartDate = utcStartDate.format('YYYY-MM-DD HH:mm:ss');
            var dbEndDate = utcEndDate.format('YYYY-MM-DD HH:mm:ss');

            /*utcStartDate = utcStartDate.format('DD/MM/YYYY');
            utcEndDate = utcEndDate.format('DD/MM/YYYY');*/

            utcStartDate = utcStartDate.format('d MMM yyyy');
            utcEndDate = utcEndDate.format('d MMM yyyy');

            localStorage.setItem('startDate1', utcStartDate);
            localStorage.setItem('endDate1', utcEndDate);
            localStorage.setItem('startMin', startMin);
            localStorage.setItem('endMin', endMin);
            localStorage.setItem('dbStartDate', dbStartDate);
            localStorage.setItem('dbEndDate', dbEndDate);           
            var diD = _getDateDiff(e.start._date, e.end._date);
            localStorage.setItem('noofdays', diD);
            if(diD < 7) {
                $('#recurring option').prop('disabled', true);
                $('#recurring option[value="One Time"]').prop('disabled', false);
            } else if(diD < 14) {
                $('#recurring option').prop('disabled', true);
                $('#recurring option[value="One Time"]').prop('disabled', false);
                $('#recurring option[value="Weekly"]').prop('disabled', false);
            } else if(diD < 30) {
                $('#recurring option').prop('disabled', true);
                $('#recurring option[value="Weekly"]').prop('disabled', false);
                $('#recurring option[value="One Time"]').prop('disabled', false);
                $('#recurring option[value="Twice Monthly"]').prop('disabled', false);

            }else if(diD < 59) {
                $('#recurring option').prop('disabled', true);
                $('#recurring option[value="Weekly"]').prop('disabled', false);
                $('#recurring option[value="One Time"]').prop('disabled', false);
                $('#recurring option[value="Twice Monthly"]').prop('disabled', false);
                $('#recurring option[value="Monthly"]').prop('disabled', false);
            }else{
                $('#recurring option').prop('disabled', false);
            }


            saveNewSchedule(e);
        },
        'beforeUpdateSchedule': function(e) {
            console.log('beforeUpdateSchedule', e);
            e.schedule.start = e.start;
            e.schedule.end = e.end;
            sessionStorage.setItem('startDate', e.start._date);
            sessionStorage.setItem('endDate', e.end._date);
            cal.updateSchedule(e.schedule.id, e.schedule.calendarId, e.schedule);
        },
        'beforeDeleteSchedule': function(e) {
            console.log('beforeDeleteSchedule', e);
            cal.deleteSchedule(e.schedule.id, e.schedule.calendarId);
        },
        'afterRenderSchedule': function(e) {
            var schedule = e.schedule;
        },
        'clickTimezonesCollapseBtn': function(timezonesCollapsed) {
            console.log('timezonesCollapsed', timezonesCollapsed);

            if (timezonesCollapsed) {
                cal.setTheme({
                    'week.daygridLeft.width': '77px',
                    'week.timegridLeft.width': '77px'
                });
            } else {
                cal.setTheme({
                    'week.daygridLeft.width': '60px',
                    'week.timegridLeft.width': '60px'
                });
            }

            return true;
        }
    });

    /**
     * Get time template for time and all-day
     * @param {Schedule} schedule - schedule
     * @param {boolean} isAllDay - isAllDay or hasMultiDates
     * @returns {string}
     */
    function getTimeTemplate(schedule, isAllDay) {
        var html = [];
        var start = moment(schedule.start.toUTCString());
        if (!isAllDay) {
            html.push('<strong>' + start.format('HH:mm') + '</strong> ');
        }
        if (schedule.isPrivate) {
            html.push('<span class="calendar-font-icon ic-lock-b"></span>');
            html.push(' Private');
        } else {
            if (schedule.isReadOnly) {
                html.push('<span class="calendar-font-icon ic-readonly-b"></span>');
            } else if (schedule.recurrenceRule) {
                html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
            } else if (schedule.attendees.length) {
                html.push('<span class="calendar-font-icon ic-user-b"></span>');
            } else if (schedule.location) {
                html.push('<span class="calendar-font-icon ic-location-b"></span>');
            }
            html.push(' ' + schedule.title);
        }

        return html.join('');
    }

    /**
     * A listener for click the menu
     * @param {Event} e - click event
     */
    function onClickMenu(e) {
        var target = $(e.target).closest('a[role="menuitem"]')[0];
        var action = getDataAction(target);
        var options = cal.getOptions();
        var viewName = '';

        console.log(target);
        console.log(action);
        switch (action) {
            case 'toggle-daily':
                viewName = 'day';
                break;
            case 'toggle-weekly':
                viewName = 'week';
                break;
            case 'toggle-monthly':
                options.month.visibleWeeksCount = 0;
                viewName = 'month';
                break;
            case 'toggle-weeks2':
                options.month.visibleWeeksCount = 2;
                viewName = 'month';
                break;
            case 'toggle-weeks3':
                options.month.visibleWeeksCount = 3;
                viewName = 'month';
                break;
            case 'toggle-narrow-weekend':
                options.month.narrowWeekend = !options.month.narrowWeekend;
                options.week.narrowWeekend = !options.week.narrowWeekend;
                viewName = cal.getViewName();

                target.querySelector('input').checked = options.month.narrowWeekend;
                break;
            case 'toggle-start-day-1':
                options.month.startDayOfWeek = options.month.startDayOfWeek ? 0 : 1;
                options.week.startDayOfWeek = options.week.startDayOfWeek ? 0 : 1;
                viewName = cal.getViewName();

                target.querySelector('input').checked = options.month.startDayOfWeek;
                break;
            case 'toggle-workweek':
                options.month.workweek = !options.month.workweek;
                options.week.workweek = !options.week.workweek;
                viewName = cal.getViewName();

                target.querySelector('input').checked = !options.month.workweek;
                break;
            default:
                break;
        }

        cal.setOptions(options, true);
        cal.changeView(viewName, true);

        setDropdownCalendarType();
        setRenderRangeText();
        setSchedules();
    }

    function onClickNavi(e) {
        var action = getDataAction(e.target);

        switch (action) {
            case 'move-prev':
                cal.prev();
                break;
            case 'move-next':
                cal.next();
                break;
            case 'move-today':
                cal.today();
                break;
            default:
                return;
        }

        setRenderRangeText();
        setSchedules();
    }

    function onNewSchedule() {
        var title = $('#new-schedule-title').val();
        var location = $('#new-schedule-location').val();
        var isAllDay = document.getElementById('new-schedule-allday').checked;
        /*var start = datePicker.getStartDate();
        var end = datePicker.getEndDate();*/
        var start = new Date($("#from_date").val());
        var end = new Date($("#to_date").val());

        console.log("onNewSchedule");
        console.log(cal);
        console.log("from_date datepicker: "+start);
        console.log("to_date datepicker: "+end);
        
        var calendar = selectedCalendar ? selectedCalendar : CalendarList[0];

        /*if (!title) {
            return;
        }*/

        cal.createSchedules([{
            id: String(chance.guid()),
            calendarId: calendar.id,
            title: title,
            isAllDay: isAllDay,
            start: start,
            end: end,
            category: isAllDay ? 'allday' : 'time',
            dueDateClass: '',
            color: calendar.color,
            bgColor: calendar.bgColor,
            dragBgColor: calendar.bgColor,
            borderColor: calendar.borderColor,
            raw: {
                location: location
            },
            state: 'Busy'
        }]);



        $('#start-date').val(JSON.stringify(start));
        $('#end-date').val(JSON.stringify(end));
        var utcStartDate =  moment(start).utc().local();
        //var startMin = utcStartDate.format('HH:mm a');
        var utcEndDate =  moment(end).utc().local();
        //var endMin = utcEndDate.format('HH:mm a');

        console.log("utcStartDate : "+utcStartDate);
        console.log("utcEndDate : "+utcEndDate);
        
        var startMin = $("#time_from_value").val();
        var endMin = $("#time_to_value").val();
        var dbStartMin = convertTo24Hour(startMin);
        var dbEndMin = convertTo24Hour(endMin);

        var dbStartDate = utcStartDate.format('YYYY-MM-DD HH:mm:ss');
        var dbEndDate = utcEndDate.format('YYYY-MM-DD HH:mm:ss');

        /*utcStartDate = utcStartDate.format('DD/MM/YYYY');
        utcEndDate = utcEndDate.format('DD/MM/YYYY');*/
        utcStartDate = utcStartDate.format('DD MMM YYYY');
        utcEndDate = utcEndDate.format('DD MMM YYYY');

        console.log("After formating....");
        console.log("utcStartDate : "+utcStartDate);
        console.log("utcEndDate : "+utcEndDate);

        console.log("time_from_value : "+startMin);
        console.log("time_to_value : "+endMin);

        localStorage.setItem('startDate', JSON.stringify(start));
        localStorage.setItem('endDate', JSON.stringify(end));
        localStorage.setItem('startDate1', utcStartDate);
        localStorage.setItem('endDate1', utcEndDate);
        localStorage.setItem('startMin', startMin);
        localStorage.setItem('endMin', endMin);
        localStorage.setItem('dbStartDate', dbStartDate);
        localStorage.setItem('dbEndDate', dbEndDate);           
        localStorage.setItem('dbStartMin', dbStartMin);
        localStorage.setItem('dbEndMin', dbEndMin);
        
        var diD = _getDateDiff(start, end);
        localStorage.setItem('noofdays', diD);
        if(diD < 7) {
            $('#recurring option').prop('disabled', true);
            $('#recurring option[value="One Time"]').prop('disabled', false);
        } else if(diD < 14) {
            $('#recurring option').prop('disabled', true);
            $('#recurring option[value="One Time"]').prop('disabled', false);
            $('#recurring option[value="Weekly"]').prop('disabled', false);
        } else if(diD < 30) {
            $('#recurring option').prop('disabled', true);
            $('#recurring option[value="Weekly"]').prop('disabled', false);
            $('#recurring option[value="One Time"]').prop('disabled', false);
            $('#recurring option[value="Twice Monthly"]').prop('disabled', false);

        }else if(diD < 59) {
            $('#recurring option').prop('disabled', true);
            $('#recurring option[value="Weekly"]').prop('disabled', false);
            $('#recurring option[value="One Time"]').prop('disabled', false);
            $('#recurring option[value="Twice Monthly"]').prop('disabled', false);
            $('#recurring option[value="Monthly"]').prop('disabled', false);
        }else{
            $('#recurring option').prop('disabled', false);
        }

        $('#modal-new-schedule').modal('hide');
        //$('#modal-new-schedule').hide();
        console.log(cal);
    }

    function onChangeNewScheduleCalendar(e) {
        var target = $(e.target).closest('a[role="menuitem"]')[0];
        var calendarId = getDataAction(target);
        changeNewScheduleCalendar(calendarId);
    }

    function changeNewScheduleCalendar(calendarId) {
        var calendarNameElement = document.getElementById('calendarName');
        var calendar = findCalendar(calendarId);
        var html = [];

        html.push('<span class="calendar-bar" style="background-color: ' + calendar.bgColor + '; border-color:' + calendar.borderColor + ';"></span>');
        html.push('<span class="calendar-name">' + calendar.name + '</span>');

        calendarNameElement.innerHTML = html.join('');

        selectedCalendar = calendar;
    }

    function createNewSchedule(event) {
        var start = event.start ? new Date(event.start.getTime()) : new Date();
        var end = event.end ? new Date(event.end.getTime()) : moment().add(1, 'hours').toDate();
        if (useCreationPopup) {
            cal.openCreationPopup({
                start: start,
                end: end
            });
        }

        console.log("createNewSchedule");
        console.log(event);
        // var option = '<option>Recurring</option>' +
        // '<option>All day</option>' +
        // '<option>Weekly</option>' +
        // '<option>Twice Monthly</option>'+
        // '<option>Monthly</option>'+
        // '<option>Every other month</option>'
        // $('.tui-full-calendar-popup-container .tui-full-calendar-popup-section:nth-child(3)').hide();
        // $('.tui-full-calendar-section-allday').hide();
        // $('.tui-full-calendar-section-state').html('<div class="custom-drop-down"><select>'+option+'</select></div>');
        // $('.tui-full-calendar-section-button-save').prepend('<div class="custom-drop-down"><select><option>Test1</option></select></div>')
    }
    function saveNewSchedule(scheduleData) {
        // scheduleData['sample'] = 'test'
        var calendar = scheduleData.calendar || findCalendar(scheduleData.calendarId);
        var schedule = {
            id: String(chance.guid()),
            title: scheduleData.title,
            isAllDay: scheduleData.isAllDay,
            start: scheduleData.start,
            end: scheduleData.end,
            category: scheduleData.isAllDay ? 'allday' : 'time',
            dueDateClass: '',
            color: calendar.color,
            bgColor: calendar.bgColor,
            dragBgColor: calendar.bgColor,
            borderColor: calendar.borderColor,
            location: scheduleData.location,
            raw: {
                class: ''/*scheduleData.raw['class']*/
            },
            state: scheduleData.state
        };
        if (calendar) {
            schedule.calendarId = calendar.id;
            schedule.color = calendar.color;
            schedule.bgColor = calendar.bgColor;
            schedule.borderColor = calendar.borderColor;
        }
        console.log(scheduleData)
       
        cal.createSchedules([schedule]);

        refreshScheduleVisibility();
    }

    function onChangeCalendars(e) {
        var calendarId = e.target.value;
        var checked = e.target.checked;
        var viewAll = document.querySelector('.lnb-calendars-item input');
        var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));
        var allCheckedCalendars = true;

        if (calendarId === 'all') {
            allCheckedCalendars = checked;

            calendarElements.forEach(function(input) {
                var span = input.parentNode;
                input.checked = checked;
                span.style.backgroundColor = checked ? span.style.borderColor : 'transparent';
            });

            CalendarList.forEach(function(calendar) {
                calendar.checked = checked;
            });
        } else {
            findCalendar(calendarId).checked = checked;

            allCheckedCalendars = calendarElements.every(function(input) {
                return input.checked;
            });

            if (allCheckedCalendars) {
                viewAll.checked = true;
            } else {
                viewAll.checked = false;
            }
        }

        refreshScheduleVisibility();
    }

    function refreshScheduleVisibility() {
        var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));

        CalendarList.forEach(function(calendar) {
            cal.toggleSchedules(calendar.id, !calendar.checked, false);
        });

        cal.render(true);

        calendarElements.forEach(function(input) {
            var span = input.nextElementSibling;
            span.style.backgroundColor = input.checked ? span.style.borderColor : 'transparent';
        });

                
        $('#start-date').val("ere");
    }

    function setDropdownCalendarType() {
        var calendarTypeName = document.getElementById('calendarTypeName');
        var calendarTypeIcon = document.getElementById('calendarTypeIcon');
        var options = cal.getOptions();
        var type = cal.getViewName();
        var iconClassName;

        if (type === 'day') {
            type = 'Daily';
            iconClassName = 'calendar-icon ic_view_day';
        } else if (type === 'week') {
            type = 'Weekly';
            iconClassName = 'calendar-icon ic_view_week';
        } else if (options.month.visibleWeeksCount === 2) {
            type = '2 weeks';
            iconClassName = 'calendar-icon ic_view_week';
        } else if (options.month.visibleWeeksCount === 3) {
            type = '3 weeks';
            iconClassName = 'calendar-icon ic_view_week';
        } else {
            type = 'Monthly';
            iconClassName = 'calendar-icon ic_view_month';
        }

        calendarTypeName.innerHTML = type;
        calendarTypeIcon.className = iconClassName;
    }

    function setRenderRangeText() {
        var renderRange = document.getElementById('renderRange');
        var options = cal.getOptions();
        var viewName = cal.getViewName();
        var html = [];
        if (viewName === 'day') {
            html.push(moment(cal.getDate().getTime()).format('YYYY.MM.DD'));
        } else if (viewName === 'month' &&
            (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
            html.push(moment(cal.getDate().getTime()).format('YYYY.MM'));
        } else {
            html.push(moment(cal.getDateRangeStart().getTime()).format('YYYY.MM.DD'));
            html.push(' ~ ');
            html.push(moment(cal.getDateRangeEnd().getTime()).format(' MM.DD'));
        }
        renderRange.innerHTML = html.join('');
    }

    function setSchedules() {
        cal.clear();
        generateSchedule(cal.getViewName(), cal.getDateRangeStart(), cal.getDateRangeEnd());
        cal.createSchedules(ScheduleList);
        // var schedules = [
        //     {id: 489273, title: 'Workout for 2019-04-05', isAllDay: false, start: '2018-02-01T11:30:00+09:00', end: '2018-02-01T12:00:00+09:00', goingDuration: 30, comingDuration: 30, color: '#ffffff', isVisible: true, bgColor: '#69BB2D', dragBgColor: '#69BB2D', borderColor: '#69BB2D', calendarId: 'logged-workout', category: 'time', dueDateClass: '', customStyle: 'cursor: default;', isPending: false, isFocused: false, isReadOnly: true, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''},
        //     // {id: 18073, title: 'completed with blocks', isAllDay: false, start: '2018-11-17T09:00:00+09:00', end: '2018-11-17T10:00:00+09:00', color: '#ffffff', isVisible: true, bgColor: '#54B8CC', dragBgColor: '#54B8CC', borderColor: '#54B8CC', calendarId: 'workout', category: 'time', dueDateClass: '', customStyle: '', isPending: false, isFocused: false, isReadOnly: false, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''}
        // ];
        // cal.createSchedules(schedules);
        refreshScheduleVisibility();
    }

    function setEventListener() {
        $('#menu-navi').on('click', onClickNavi);
        $('.dropdown-menu a[role="menuitem"]').on('click', onClickMenu);
        $('#lnb-calendars').on('change', onChangeCalendars);

        $('#btn-save-schedule').on('click', onNewSchedule);
        $('#btn-new-schedule').on('click', createNewSchedule);

        $('#dropdownMenu-calendars-list').on('click', onChangeNewScheduleCalendar);

        window.addEventListener('resize', resizeThrottled);
    }

    function getDataAction(target) {
        return target.dataset ? target.dataset.action : target.getAttribute('data-action');
    }

    function convertTo24Hour(time) {
        time = time.toLowerCase();
        var hours = parseInt(time.substr(0, 2));
        if(time.indexOf('am') != -1 && hours == 12) {
            time = time.replace('12', '0');
        }
        if(time.indexOf('pm')  != -1 && hours < 12) {
            time = time.replace(hours, (hours + 12));
        }
        return time.replace(/(am|pm)/, '');
    }

    resizeThrottled = tui.util.throttle(function() {
        cal.render();
    }, 50);

    window.cal = cal;

    setDropdownCalendarType();
    setRenderRangeText();
    setSchedules();
    setEventListener();
})(window, tui.Calendar);

// set calendars
(function() {
    var calendarList = document.getElementById('calendarList');
    var html = [];
    
    CalendarList.forEach(function(calendar) {
        html.push('<div class="lnb-calendars-item"><label>' +
            '<input type="checkbox" class="tui-full-calendar-checkbox-round" value="' + calendar.id + '" checked>' +
            '<span style="border-color: ' + calendar.borderColor + '; background-color: ' + calendar.borderColor + ';"></span>' +
            '<span>' + calendar.name + '</span>' +
            '</label></div>'
        );
    });
    
    calendarList.innerHTML = html.join('\n');
})();
