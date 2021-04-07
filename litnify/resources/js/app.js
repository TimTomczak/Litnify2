require('./bootstrap');

// Daterangepicker
require('./moment.min')
require('./daterangepicker')

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('./service-worker.js')
        .then(function (reg){
            console.log("Successfully registered service worker !");
        })
        .catch(function (err){

            console.log("Service worker not registered!");
        })
}
