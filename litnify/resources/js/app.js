require('./bootstrap');

// Daterangepicker
require('./moment.min')
require('./daterangepicker')

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('./service-worker.js')
        .then(function (reg){
            console.log('Registration successful, scope is:', reg.scope);
        })
        .catch(function (err){

            console.log('Service worker registration failed, error:', err);
        })
}
