@section('javascript.header')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('javascript.footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>

        $(function() {
            var ausleihdauer=$('input[name="ausleihzeitraum"]').data('ausleihdauer')
            $('input[name="ausleihzeitraum"]').daterangepicker({

                // timePicker: true,
                // timePicker24Hour: true,
                showDropdowns: true,
                startDate: moment(),
                endDate: moment().add(ausleihdauer, 'day'),
                opens: "center",
                drops: "auto",
                // applyButtonClasses: "btn-primary",
                cancelClass: "btn-secondary",
                locale: {
                    format: 'DD.MM.YYYY',
                    separator: " - ",
                    applyLabel: "Anwenden",
                    cancelLabel: "Abbrechen",
                    fromLabel: "Von",
                    toLabel: "Bis",
                    customRangeLabel: "Custom",
                    weekLabel: "W",
                    daysOfWeek: [
                        "So",
                        "Mo",
                        "Di",
                        "Mi",
                        "Do",
                        "Fr",
                        "Sa"
                    ],
                    monthNames: [
                        "Januar",
                        "Februar",
                        "März",
                        "April",
                        "Mai",
                        "Juni",
                        "Juli",
                        "August",
                        "September",
                        "October",
                        "November",
                        "Dezember"
                    ],
                }
            });

        });

    </script>
@endsection
