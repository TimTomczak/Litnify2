import moment from "moment";
$(function() {
    var ausleihadatum=$('input[name="ausleihzeitraumEdit"]').data('ausleihdatum')
    var rueckgabesoll=$('input[name="ausleihzeitraumEdit"]').data('rueckgabesoll')
    $('input[name="ausleihzeitraumEdit"]').daterangepicker({

        // timePicker: true,
        // timePicker24Hour: true,
        showDropdowns: true,
        startDate: ausleihadatum,
        endDate: rueckgabesoll,
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
