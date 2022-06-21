@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('js/plugins/fullcalendar/main.min.css') }}">

    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/magnific-popup/magnific-popup.css') }}">
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/apartment.titles') }}</h1>
                <a class="btn btn-hero-success my-2" href="{{ route('calendar.create') }}">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> {{ __('back/apartment.new') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <!-- Full Calendar (functionality is initialized in js/pages/be_comp_calendar.min.js which was auto compiled from _js/pages/be_comp_calendar.js ) -->
    <!-- For more info and examples you can check out https://fullcalendar.io/ -->
    <div class="row no-gutters flex-xl-10-auto">
        @include('back.layouts.partials.session')

        <div class="col-xl-3">
            <div class="content">
                <!-- Toggle Side Content -->
                <div class="d-xl-none push">
                    <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
                    <button type="button" class="btn btn-block btn-alt-primary" data-toggle="class-toggle" data-target="#side-content" data-class="d-none">
                        Calendar Options
                    </button>
                </div>
                <!-- END Toggle Side Content -->

                <!-- Side Content -->
                <div id="side-content" class="d-none d-xl-block push">
                    <!-- Add Event Form -->
                    <form class="js-form-add-event push">
                        <div class="input-group">
                            <input type="text" class="js-add-event form-control border-0" placeholder="Add Event..">
                            <div class="input-group-append">
                                            <span class="input-group-text border-0 bg-white">
                                                <i class="fa fa-fw fa-plus-circle"></i>
                                            </span>
                            </div>
                        </div>
                    </form>
                    <!-- END Add Event Form -->

                    <!-- Event List -->
                    <ul id="js-events" class="list list-events">
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-info">Codename X</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-success">Weekend Adventure</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-info">Project Mars</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-warning">Meeting</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-success">Walk the dog</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-info">AI schedule</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-success">Cinema</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-danger">Project X</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-warning">Skype Meeting</div>
                        </li>
                    </ul>
                    <div class="text-center">
                        <em class="font-size-sm text-muted">
                            <i class="fa fa-arrows-alt"></i> Drag and drop events on the calendar
                        </em>
                    </div>
                    <!-- END Event List -->
                </div>
                <!-- END Side Content -->
            </div>
        </div>
        <div class="col-xl-9 bg-body-dark">
            <div class="content">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <!-- Calendar Container -->
                        <div id="js-calendar" class="p-xl-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

@endsection

@push('js_after')
    <script src="{{ asset('js/ag-input-field.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- Page JS Helpers (Magnific Popup Plugin) -->
    <script>jQuery(function(){Dashmix.helpers('magnific-popup');});</script>

    <script src="{{ asset('js/plugins/fullcalendar/main.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        class pageCompCalendar {
            /*
             * Add event to the events list
             *
             */
            static addEvent() {
                let eventInput      = jQuery('.js-add-event');
                let eventInputVal   = '';

                // When the add event form is submitted
                jQuery('.js-form-add-event').on('submit', e => {
                    // Get input value
                    eventInputVal = eventInput.prop('value');

                    // Check if the user entered something
                    if (eventInputVal) {
                        // Add it to the events list
                        jQuery('#js-events')
                        .prepend('<li>' + '<div class="js-event p-2 text-white font-size-sm font-w500 bg-info">' +
                            jQuery('<div />').text(eventInputVal).html() +
                            '</div>' + '</li>');

                        // Clear input field
                        eventInput.prop('value', '');
                    }

                    return false;
                });
            }

            /*
             * Init drag and drop event functionality
             *
             */
            static initEvents() {
                new FullCalendar.Draggable(document.getElementById('js-events'), {
                    itemSelector: '.js-event',
                    eventData: function(eventEl) {
                        return {
                            title: eventEl.innerText,
                            backgroundColor: getComputedStyle(eventEl).backgroundColor,
                            borderColor: getComputedStyle(eventEl).backgroundColor
                        };
                    }
                });
            }

            /*
             * Init calendar demo functionality
             *
             */
            static initCalendar() {
                let date = new Date();
                let d    = date.getDate();
                let m    = date.getMonth();
                let y    = date.getFullYear();

                let calendar = new FullCalendar.Calendar(document.getElementById('js-calendar'), {
                    themeSystem: 'bootstrap',
                    firstDay: 1,
                    editable: true,
                    droppable: true,
                    headerToolbar: {
                        left: 'title',
                        right: 'prev,next today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    drop: function(info) {
                        info.draggedEl.parentNode.remove();
                    },
                    events: [
                        {
                            title: 'Gaming Day',
                            start: new Date(y, m, 1),
                            allDay: true
                        },
                        {
                            title: 'Skype Meeting',
                            start: new Date(y, m, 3)
                        },
                        {
                            title: 'Project X',
                            start: new Date(y, m, 9),
                            end: new Date(y, m, 12),
                            allDay: true,
                            color: '#e04f1a'
                        },
                        {
                            title: 'Work',
                            start: new Date(y, m, 17),
                            end: new Date(y, m, 19),
                            allDay: true,
                            color: '#82b54b'
                        },
                        {
                            id: 999,
                            title: 'Hiking (repeated)',
                            start: new Date(y, m, d - 1, 15, 0)
                        },
                        {
                            id: 999,
                            title: 'Hiking (repeated)',
                            start: new Date(y, m, d + 3, 15, 0)
                        },
                        {
                            title: 'Landing Template',
                            start: new Date(y, m, d - 3),
                            end: new Date(y, m, d - 3),
                            allDay: true,
                            color: '#ffb119'
                        },
                        {
                            title: 'Lunch',
                            start: new Date(y, m, d + 7, 15, 0),
                            color: '#82b54b'
                        },
                        {
                            title: 'Coding',
                            start: new Date(y, m, d, 8, 0),
                            end: new Date(y, m, d, 14, 0),
                        },
                        {
                            title: 'Trip',
                            start: new Date(y, m, 25),
                            end: new Date(y, m, 27),
                            allDay: true,
                            color: '#ffb119'
                        },
                        {
                            title: 'Reading',
                            start: new Date(y, m, d + 8, 20, 0),
                            end: new Date(y, m, d + 8, 22, 0)
                        },
                        {
                            title: 'Follow us on Twitter',
                            start: new Date(y, m, 22),
                            allDay: true,
                            url: 'http://twitter.com/pixelcave',
                            color: '#3c90df'
                        }
                    ]
                });

                calendar.render();
            }

            /*
             * Init functionality
             *
             */
            static init() {
                this.addEvent();
                this.initEvents();
                this.initCalendar();
            }
        }

        // Initialize when page loads
        jQuery(() => { pageCompCalendar.init(); });
    </script>

@endpush
