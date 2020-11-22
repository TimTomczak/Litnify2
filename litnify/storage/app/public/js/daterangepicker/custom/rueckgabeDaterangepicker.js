/* Modal mit Klasse 'modalAusleiheVerlaengern' */
/* Input mit ID 'verlaengerung_*id*' */

$('.ausleiheRueckgabe').click(function (event){
    var id =  $(this).data('id');
    var ausleihdatum =  $(this).data('ausleihdatum');
    // $('#modalAusleiheVerlaengern').modal('show')

    $(function() {
        $('#rueckgabe_'+id).daterangepicker({

            // timePicker: true,
            // timePicker24Hour: true,
            showDropdowns: true,
            startDate: moment(),
            // endDate: rueckgabeSoll,
            minDate: ausleihdatum,
            opens: "center",
            drops: "auto",
            singleDatePicker: true,
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

});
