/* Modal mit Klasse 'modalAusleiheVerlaengern' */
/* Input mit ID 'verlaengerung_*id*' */

$('.ausleiheVerlaengern').click(function (event){
    var id =  $(this).data('id');
    var rueckgabeSoll =  $(this).data('rueckgabesoll');
    // $('#modalAusleiheVerlaengern').modal('show')

    $(function() {
        $('#verlaengerung_'+id).daterangepicker({

            // timePicker: true,
            // timePicker24Hour: true,
            showDropdowns: true,
            startDate: rueckgabeSoll,
            // endDate: rueckgabeSoll,
            minDate: rueckgabeSoll,
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
