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
<!--                <a class="btn btn-hero-success my-2" href="{{ route('calendar.create') }}">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> {{ __('back/apartment.new') }}</span>
                </a>-->
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <!-- Full Calendar (functionality is initialized in js/pages/be_comp_calendar.min.js which was auto compiled from _js/pages/be_comp_calendar.js ) -->
    <!-- For more info and examples you can check out https://fullcalendar.io/ -->
    <div class="row no-gutters flex-xl-10-auto">


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
                    <form class="js-form-add-event push mb-2">
                        <div class="input-group">
                            <input type="text" class="js-add-event form-control border-0" placeholder="Add Event..">
                            <div class="input-group-append">
                                <span class="input-group-text border-0 bg-white"><i class="fa fa-fw fa-plus-circle"></i></span>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <select class="js-select2 form-control" id="apartment-select" style="width: 100%;" data-placeholder="To apartment...">
                                <option></option>
                                @foreach ($apartments as $apartment)
                                    <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Event List -->
                    <ul id="js-events" class="list list-events">
                        @foreach (config('settings.calendar_add_events') as $event)
                            <li><div class="js-event p-2 text-white font-size-sm font-w500 bg-warning">{{ $event['title'][current_locale()] }}</div></li>
                        @endforeach
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
                @include('back.layouts.partials.session')
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

@push('modals')
    <div class="modal fade" id="status-modal" tabindex="-1" role="dialog" aria-labelledby="status--modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">{{ __('back/app.statuses.main_title') }}</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-11">
                                <div class="row mb-3">
                                    <div class="col-md-4" id="apartment-image"></div>
                                    <div class="col-md-8" id="order-info"></div>
                                </div>
                                <table class="table table-sm" id="order-table" style="width: 100%;"></table>
                                <div class="row mb-2 mt-4">
                                    <div class="col-md-4" id="order-edit-btn"></div>
                                    <div class="col-md-4" id="apartment-edit-btn"></div>
                                    <div class="col-md-4" id="order-delete-btn"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            {{ __('back/app.statuses.cancel') }} <i class="fa fa-times ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endpush

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

                let zauzetost = [];
                {!! $calendars->toJson() !!}.forEach((item) => {
                    let color = item.color;
                    if (item.order.invoice == 'service') {
                        color = '#ffb119';
                    }

                    zauzetost.push({
                        title: item.title,
                        start: item.start,
                        end: item.end,
                        allDay: true,
                        color: color,
                        order: item.order,
                        order_options: item.order_options
                    });
                });

                let calendar = new FullCalendar.Calendar(document.getElementById('js-calendar'), {
                    themeSystem: 'bootstrap',
                    firstDay: 1,
                    editable: true,
                    droppable: true,
                    headerToolbar: {
                        left: 'title',
                        right: 'prev,next dayGridMonth'
                    },
                    drop: function(info) {
                        pageCompCalendar.makeOrder(info);
                        //console.log(info)
                        //alert(info.draggedEl.innerText + " was put on " + info.dateStr.toLocaleString());
                        //info.draggedEl.parentNode.remove();
                    },
                    eventResize: function(info) {
                        pageCompCalendar.moveOrder(info.event);
                    },
                    eventDrop: function(info) {
                        pageCompCalendar.moveOrder(info.event);
                    },
                    eventClick: function(info) {
                        pageCompCalendar.showOrder(
                            info.event.extendedProps.order,
                            info.event.extendedProps.order_options
                        );
                    },
                    events: zauzetost
                });

                calendar.render();
            }

            static makeOrder(data) {
                if (!$('#apartment-select').val()) {
                    return errorToast.fire('{{ __('back/app.calendar_make_apartment_error') }}');
                }

                let item = {
                    type: 'service',
                    apartment_id: $('#apartment-select').val(),
                    date: data.dateStr,
                };

                this.moveOrder(item);
            }

            /**
             *
             * @param data
             */
            static moveOrder(data) {
                axios.post("{{ route('api.calendar.move') }}", {data: data})
                .then(response => {
                    if (response.data.success) {
                        return successToast.fire(response.data.message);
                    } else {
                        return errorToast.fire(response.data.message);
                    }
                });
            }

            /**
             *
             * @param order
             * @param options
             */
            static showOrder(order, options) {
                $('#status-modal').modal('show');

                let base_url = window.location.origin;
                let address = order.apartment.address + ', ' + order.apartment.city;

                let order_description = '<h4 class="font-w400">' + order.apartment.title + ' - <small class="text-gray-dark">' + address + '</small></h4>';

                order_description += `<address>
                                        <strong>` + order.payment_fname + ' ' + order.payment_lname + `</strong><br>
                                        <abbr title="Email">E:</abbr> ` + order.payment_email + `<br>
                                        <abbr title="Phone">P:</abbr> ` + order.payment_phone + `
                                    </address>`;
                order_description += `<address>
                                        <strong>od: </strong> ` + new Date(order.date_from).toLocaleDateString() + `, <strong>do: </strong> ` + new Date(order.date_to).toLocaleDateString() + `<br>
                                        Ukupno: ` + options.total_days + ` dana<br>
                                        Odraslih ` + options.adults + `, Djece ` + options.children + `
                                    </address>`;

                let order_table = '';

                for (let i = 0; i < options.total.items.length; i++) {
                    order_table += this.orderRowItemView(options.total.items[i]);
                }
                for (let i = 0; i < options.total.total.length; i++) {
                    order_table += this.orderRowTotalView(options.total.total[i]);
                }

                let order_edit_btn = document.createElement('a');
                order_edit_btn.setAttribute('class', 'btn btn-info btn-block');
                order_edit_btn.setAttribute('href', base_url + '/{{ current_locale() }}/admin/order/' + order.id + '/edit');
                order_edit_btn.text = 'Edit Order'

                let order_delete_btn = document.createElement('a');
                order_delete_btn.setAttribute('class', 'btn btn-danger btn-block');
                order_delete_btn.setAttribute('href', base_url + '/{{ current_locale() }}/admin/order/' + order.id + '/delete');
                order_delete_btn.text = 'Delete Order';

                let apartment_edit_btn = document.createElement('a');
                apartment_edit_btn.setAttribute('class', 'btn btn-secondary btn-block');
                apartment_edit_btn.setAttribute('href', base_url + '/{{ current_locale() }}/admin/apartment/' + order.apartment_id + '/edit');
                apartment_edit_btn.text = 'Edit Apartment';

                $('#apartment-image').html('<img class="img-thumbnail" src="' + base_url + '/' + order.apartment.image + '" alt="">');
                $('#order-info').html(order_description);
                $('#order-table').html(order_table);
                $('#order-edit-btn').html(order_edit_btn);
                $('#order-delete-btn').html(order_delete_btn);
                $('#apartment-edit-btn').html(apartment_edit_btn);
            }

            /**
             *
             * @param item
             * @returns {string}
             */
            static orderRowItemView(item) {
                return `<tr style="height: 36px;">
                            <td>` + item.price_text + ' * ' + item.count + ' ' + item.title + `</td>
                            <td>` + item.total_text + `</td>
                        </tr>`
            }

            /**
             *
             * @param item
             * @returns {string}
             */
            static orderRowTotalView(item) {
                return `<tr style="height: 36px;">
                            <td class="text-right pr-3">` + item.title + `</td>
                            <td>` + item.total_text + `</td>
                        </tr>`
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
        jQuery(() => {
            pageCompCalendar.init();

            $('#apartment-select').select2({});
        });
    </script>

@endpush
